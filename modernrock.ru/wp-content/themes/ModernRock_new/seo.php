<?php
/** AIOSEO owns the head tags; templates supply data through its filters. */
if (!defined('ABSPATH')) exit;
require_once __DIR__ . '/seo-sections.php';

/** Preserve content title rules through filters; AIOSEO owns the actual meta tags. */
function modernrock_content_title($title) {
    if (is_tag('russkaya-scena')) return 'Родные – современные русские группы';
    if (!is_singular('post')) return $title;
    $id = get_queried_object_id();
    if (get_post_meta($id, 'auto_seo', true) == 1) {
        $manual = trim((string) get_post_meta($id, '_aioseop_title', true));
        return $manual !== '' ? $manual : $title;
    }
    $name = get_the_title($id);
    $path = trim((string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    if (strpos($path, 'leaks/') === 0) {
        $artist = get_post_meta($id, 'data_ngroup', true) ?: get_post_meta($id, 'group_afisha', true);
        $album = get_post_meta($id, 'album', true);
        $year = get_post_meta($id, 'data_leaks', true);
        if ($artist && $album) return $artist . ' — ' . $album . ($year ? ' (' . $year . ')' : '') . ' слушать онлайн бесплатно';
    }
    if (has_category(12, $id)) return $name . ': концерты ' . date('Y') . '-' . date('Y', strtotime('+1 year')) . ' и билеты';
    if (has_category(13, $id)) return $name . ' — афиша и концерты ' . date('Y');
    foreach (get_the_category($id) as $term) {
        if ((int) $term->parent !== 2872) continue;
        $date = (string) get_post_meta($id, 'data_afisha', true);
        $city = get_post_meta($id, 'city', true);
        $city_prep = function_exists('gigsbot_city_prepositional') ? gigsbot_city_prepositional($city) : $city;
        if (preg_match('~^\d{4}-\d{2}-\d{2}~', $date)) {
            return $name . ($city_prep ? ' в ' . $city_prep : '') . ', билеты на ' . (int) substr($date, 8, 2) . ' ' . date_gigs($date, 0) . ' ' . substr($date, 0, 4);
        }
        break;
    }
    return $title;
}
add_filter('wp_title', 'modernrock_content_title', 0);
add_filter('aioseo_title', 'modernrock_content_title', 0);

// Preserve the old attachment-list redirect without emitting headers during theme loading.
add_action('template_redirect', function () {
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'attachment') {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}, -1);


function modernrock_seo_search_kind() {
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    if (is_search() || $path === 'search') return 'site';
    if ($path === 'groups' && isset($_GET['q'])) return 'concerts';
    return '';
}

function modernrock_seo_city() {
    $slug = get_query_var('gigsbot_city');
    return $slug && function_exists('gigsbot_slug_to_city') ? gigsbot_slug_to_city($slug) : '';
}

function modernrock_seo_genre() {
    if (!modernrock_seo_city()) return '';
    $genre = $GLOBALS['modernrock_afisha_landing']['genre'] ?? modernrock_search_term('genre');
    $data = function_exists('gigsbot_artist_genres') ? gigsbot_artist_genres() : ['genres' => []];
    return isset($data['genres'][$genre]) ? $genre : '';
}

function modernrock_seo_title($title) {
    $search = modernrock_seo_search_kind();
    if ($search) {
        $query = is_search() ? get_search_query(false) : modernrock_search_term('q');
        $title = ($search === 'concerts' ? 'Поиск концертов' : 'Поиск по сайту') . ($query !== '' ? ': ' . $query : '') . ' | ModernRock';
        $page = is_search() ? max(1, (int) get_query_var('paged')) : modernrock_search_page();
    } elseif ($city = modernrock_seo_city()) {
        $genre = modernrock_seo_genre();
        $title = ($genre !== '' ? $genre . ' — концерты' : 'Концерты') . ' в ' . gigsbot_city_prepositional($city) . ' ' . date('Y') . ' — афиша и билеты | ModernRock';
        $page = max(1, (int) get_query_var('gigsbot_page'));
    } elseif (is_category() && !is_search()) {
        $copy = modernrock_section_copy();
        $title = $copy[0] . ' | ModernRock';
        $page = max(1, (int) get_query_var('paged'));
    } elseif (is_tag()) {
        // Existing tag titles can be custom; only supply the page suffix.
        $page = max(1, (int) get_query_var('paged'));
    } elseif (modernrock_venue_page() > 1) {
        $page = modernrock_venue_page();
    } else {
        return $title;
    }
    return $title . ($page > 1 ? ' — страница ' . $page : '');
}
add_filter('aioseo_title', 'modernrock_seo_title', 1000);
add_filter('wp_title', 'modernrock_seo_title', 1000);

function modernrock_seo_description($description) {
    $search = modernrock_seo_search_kind();
    $city = modernrock_seo_city();
    if ($search) {
        $description = $search === 'concerts'
            ? 'Поиск артистов, площадок и городов: ближайшие концерты и билеты на ModernRock.'
            : 'Поиск новостей музыки, репортажей, рецензий и других материалов ModernRock.';
    } elseif ($city) {
        $genre = modernrock_seo_genre();
        $description = ($genre !== '' ? $genre . ': афиша концертов' : 'Афиша концертов') . ' в ' . gigsbot_city_prepositional($city) . ' на ' . date('Y') . ' год. Расписание, площадки и билеты.';
    } elseif (get_query_var('gigsbot_concert_slug')) {
        return $description;
    } elseif (is_front_page()) {
        $description = 'Новости музыки, афиша концертов в Москве, Санкт-Петербурге и других городах. Расписание выступлений, рецензии и билеты на ModernRock.';
    } elseif (is_category()) {
        $copy = modernrock_section_copy();
        $description = $copy[1];
    } elseif (modernrock_page_description() !== '') {
        $description = modernrock_page_description();
    } elseif (is_singular('post') && !get_post_meta(get_queried_object_id(), 'auto_seo', true)) {
        $id = get_queried_object_id();
        if (has_category(12, $id)) {
            $description = 'Афиша концертов ' . get_the_title($id) . ': расписание выступлений в Москве, Санкт-Петербурге и других городах, площадки и билеты.';
        } elseif (has_category(13, $id)) {
            $description = get_the_title($id) . ' — афиша площадки: ближайшие концерты, расписание выступлений и билеты.';
        }
    }
    if (trim((string) $description) === '') {
        if (is_category() || is_tag() || is_tax()) {
            $description = term_description();
            if (trim(wp_strip_all_tags($description)) === '') {
                $description = single_term_title('', false) . ' — публикации, новости и материалы музыкального портала ModernRock.';
            }
        } elseif (is_singular()) {
            $description = get_the_excerpt(get_queried_object_id());
        }
    }
    $description = trim(preg_replace('/\s+/u', ' ', wp_strip_all_tags(strip_shortcodes((string) $description))));
    $page = $city ? max(1, (int) get_query_var('gigsbot_page')) : max((int) get_query_var('paged'), modernrock_venue_page());
    if ($page > 1) $description .= ' Страница ' . $page . '.';
    return $description;
}
add_filter('aioseo_description', 'modernrock_seo_description', 1000);

function modernrock_seo_canonical($url) {
    if (!empty($GLOBALS['modernrock_afisha_landing'])) {
        $page = max(1, (int) get_query_var('gigsbot_page'));
        return rtrim($GLOBALS['modernrock_afisha_landing']['base'], '/') . ($page > 1 ? '/page/' . $page : '');
    }
    if ($city = modernrock_seo_city()) {
        $page = max(1, (int) get_query_var('gigsbot_page'));
        $url = home_url('/afisha/' . get_query_var('gigsbot_city') . '/' . ($page > 1 ? 'page/' . $page . '/' : ''));
        $genre = modernrock_seo_genre();
        return $genre !== '' ? add_query_arg('genre', rawurlencode($genre), $url) : $url;
    }
    if (get_query_var('gigsbot_concert_slug') && get_query_var('gigsbot_concert_date')) {
        $url = home_url('/concert/' . get_query_var('gigsbot_concert_slug') . '-' . get_query_var('gigsbot_concert_date') . '/');
        return !empty($GLOBALS['modernrock_selected_event_key'])
            ? add_query_arg('event', $GLOBALS['modernrock_selected_event_key'], $url) : $url;
    }
    if ($search = modernrock_seo_search_kind()) {
        $query = is_search() ? get_search_query(false) : modernrock_search_term('q');
        $url = is_search() ? add_query_arg('s', rawurlencode($query), home_url('/')) : add_query_arg('q', rawurlencode($query), home_url($search === 'concerts' ? '/groups' : '/search'));
        $page = is_search() ? max(1, (int) get_query_var('paged')) : modernrock_search_page();
        return $page > 1 ? add_query_arg(is_search() ? 'paged' : 'search_page', $page, $url) : $url;
    }
    if (is_paged() && (is_category() || is_tag() || is_home())) {
        return strtok(get_pagenum_link((int) get_query_var('paged'), false), '?');
    }
    if (modernrock_venue_page() > 1) return add_query_arg('concert_page', modernrock_venue_page(), get_permalink(get_queried_object_id()));
    if (is_front_page()) return home_url('/');
    return $url;
}
add_filter('aioseo_canonical_url', 'modernrock_seo_canonical', 1000);

function modernrock_seo_robots($robots) {
    if (!(int) get_option('blog_public')) return $robots;
    if (is_attachment()) {
        $robots['noindex'] = 'noindex';
        $robots['nofollow'] = 'nofollow';
        return $robots;
    }
    if (modernrock_seo_search_kind() || (modernrock_seo_genre() !== '' && empty($GLOBALS['modernrock_afisha_landing'])) || modernrock_service_page() || (is_category(12) && modernrock_search_term('gr') !== '')) {
        $robots['noindex'] = 'noindex';
        unset($robots['nofollow']);
    } elseif (is_paged() && (is_category() || is_tag() || is_home())) {
        unset($robots['noindex'], $robots['nofollow']);
    }
    return $robots;
}
add_filter('aioseo_robots_meta', 'modernrock_seo_robots', 1000);

// A sitemap is a child of the sitemap index, never an ordinary page URL.
add_filter('aioseo_sitemap_additional_pages', function ($entries) {
    return array_values(array_filter($entries, function ($entry) {
        return strpos($entry['loc'], 'gigsbot_sitemap') === false;
    }));
});
add_filter('aioseo_sitemap_indexes', function ($entries) {
    if (function_exists('gigsbot_city_slugs')) {
        $entries[] = ['loc' => home_url('/?gigsbot_sitemap=1'), 'count' => count(gigsbot_city_slugs())];
    }
    return $entries;
});
add_filter('aioseo_sitemap_exclude_terms', function ($ids) {
    $ids[] = 2902; // Internal search category is not an indexable landing page.
    return array_values(array_unique($ids));
});
