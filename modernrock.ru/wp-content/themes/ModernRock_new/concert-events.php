<?php
/** Keep the selected API event intact when opening its concert page. */
if (!defined('ABSPATH')) exit;

function modernrock_event_name($name) {
    return mb_strtolower(trim(html_entity_decode((string) $name, ENT_QUOTES, 'UTF-8')), 'UTF-8');
}

/** Verified venue aliases: the jazz club is inside the Ogorod restaurant. */
function modernrock_event_place($event) {
    $place = isset($event['place']) && is_string($event['place']) ? $event['place'] : '';
    $aliases = ['огород', 'академ джаз клуб', 'академ-джаз-клуб проспект мира'];
    if (modernrock_event_name($event['city'] ?? '') === 'москва'
        && in_array(modernrock_event_name($place), $aliases, true)) {
        return 'Академ Джаз Клуб (Огород)';
    }
    return $place;
}

/** No price or picture: refreshing either must not change the event address. */
function modernrock_event_key($event) {
    foreach (['artist', 'city', 'date', 'place', 'url'] as $field) {
        if (empty($event[$field]) || !is_string($event[$field])) return '';
    }
    $date = modernrock_event_date($event['date']);
    $url = esc_url_raw(html_entity_decode($event['url'], ENT_QUOTES, 'UTF-8'));
    if (!$date || !$url) return '';
    // Affiliate wrappers can change without changing the ticket's destination.
    parse_str((string) wp_parse_url($url, PHP_URL_QUERY), $query);
    foreach (['ulp', 'dl'] as $field) {
        if (isset($query[$field]) && is_string($query[$field]) && preg_match('~^https?://~i', $query[$field])) {
            $url = $query[$field];
            break;
        }
    }
    return substr(hash('sha256', wp_json_encode([
        modernrock_event_name($event['artist']), modernrock_event_name($event['city']),
        $date['iso'], modernrock_event_name($event['place']), $event['source'] ?? '', $url,
    ])), 0, 32);
}

/** Keep the exact offer that was displayed in a city, artist or venue list. */
function modernrock_remember_event($event) {
    $key = modernrock_event_key($event);
    if ($key === '') return '';
    static $seen = [];
    if (!isset($seen[$key]) || $seen[$key] !== $event) {
        $cache_key = 'gigsbot_event_v1_' . $key;
        if (get_transient($cache_key) !== $event) set_transient($cache_key, $event, DAY_IN_SECONDS);
        $seen[$key] = $event;
    }
    return $key;
}

function modernrock_events_api($path, $params) {
    if (!defined('CONCERT_GIGSBOT_API') || !defined('CONCERT_GIGSBOT_TOKEN')) {
        return new WP_Error('event_unavailable', 'Не настроен источник афиши.');
    }
    $params['token'] = CONCERT_GIGSBOT_TOKEN;
    $response = wp_remote_get(CONCERT_GIGSBOT_API . $path . '?' . http_build_query($params), ['timeout' => 8]);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return new WP_Error('event_unavailable', 'Не удалось обновить афишу.');
    }
    $data = json_decode(wp_remote_retrieve_body($response), true);
    return is_array($data) ? $data : new WP_Error('event_unavailable', 'Некорректный ответ источника афиши.');
}

/** Reuse the exact snapshot used by the city list, including its cache lifetime. */
function modernrock_city_events($city) {
    $has_page = in_array($city, ['Москва', 'Санкт-Петербург'], true);
    $key = 'gigsbot_city_snapshot_v1_' . md5($city . ($has_page ? '&has_page=1' : ''));
    $events = get_transient($key);
    if (is_array($events)) return $events;
    $events = [];
    $pages = 1;
    for ($page = 1; $page <= $pages; ++$page) {
        $params = ['city' => $city, 'page' => $page, 'per_page' => 1000];
        if ($has_page) $params['has_page'] = 1;
        $data = modernrock_events_api('/api/city_web', $params);
        if (is_wp_error($data)) return $data;
        if (!isset($data['concerts'], $data['pages']) || !is_array($data['concerts']) || (int) $data['pages'] > 20) {
            return new WP_Error('event_unavailable', 'Не удалось получить полную афишу.');
        }
        $pages = max(1, (int) $data['pages']);
        $events = array_merge($events, $data['concerts']);
    }
    set_transient($key, $events, 15 * MINUTE_IN_SECONDS);
    return $events;
}

function modernrock_artist_events($artist) {
    $key = 'gigsbot_web_artist_v2_' . md5($artist);
    $data = get_transient($key);
    if (!is_array($data) || !isset($data['concerts']) || !is_array($data['concerts'])) {
        $data = modernrock_events_api('/api/concerts_web', ['artist' => $artist]);
        if (is_wp_error($data)) return $data;
        if (!isset($data['concerts']) || !is_array($data['concerts'])) {
            return new WP_Error('event_unavailable', 'Не удалось получить концерты артиста.');
        }
        set_transient($key, $data, DAY_IN_SECONDS);
    }
    $events = [];
    foreach ($data['concerts'] as $event) {
        $event['artist'] = $artist;
        $events[] = $event;
    }
    if (!$events && !empty($data['_modernrock_api_unavailable'])) {
        return new WP_Error('event_unavailable', 'Не удалось обновить концерты артиста.');
    }
    return $events;
}

function modernrock_matching_events($events, $artist, $city, $day, $key = '') {
    $matches = [];
    foreach ($events as $event) {
        if (modernrock_event_name($event['artist'] ?? '') !== modernrock_event_name($artist)
            || modernrock_event_name($event['city'] ?? '') !== modernrock_event_name($city)
            || substr($event['date'] ?? '', 0, 10) !== $day) continue;
        $event_key = modernrock_event_key($event);
        if ($event_key && ($key === '' || hash_equals($event_key, $key))) $matches[$event_key] = $event;
    }
    return array_values($matches);
}

function modernrock_resolve_concert($artist, $city, $city_slug, $day, $key = '') {
    if ($key !== '') {
        $selected = get_transient('gigsbot_event_v1_' . $key);
        if (is_array($selected)) {
            $matches = modernrock_matching_events([$selected], $artist, $city, $day, $key);
            if ($matches) return $matches[0];
        }
    }
    $unavailable = false;
    // Legacy links have no event key; the city listing is their primary source.
    foreach (['city', 'artist'] as $source) {
        $events = $source === 'city' ? modernrock_city_events($city) : modernrock_artist_events($artist);
        if (is_wp_error($events)) { $unavailable = true; continue; }
        $matches = modernrock_matching_events($events, $artist, $city, $day, $key);
        if (count($matches) === 1) return $matches[0];
        if (count($matches) > 1) return new WP_Error('event_ambiguous', 'На этот день найдено несколько концертов.');
    }
    // Older events can be absent from the upcoming-event feeds. Never substitute
    // another offer for a specifically selected event, even in this fallback.
    $event = modernrock_events_api('/api/concert_page', ['artist' => modernrock_event_name($artist), 'city' => $city_slug, 'date' => $day]);
    if (is_wp_error($event)) return $event;
    if (!empty($event['artist'])) {
        $event['artist'] = $artist;
        $matches = modernrock_matching_events([$event], $artist, $city, $day, $key);
        if ($matches) return $matches[0];
    }
    return new WP_Error($unavailable ? 'event_unavailable' : 'event_not_found', 'Концерт не найден.');
}
