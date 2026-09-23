<?php
/** Batch the theme's repeated directory, thumbnail and option lookups. */
if (!defined('ABSPATH')) exit;

/** Fetch directory matches for a whole page, preserving SQL title collation. */
function modernrock_prime_artist_directory($names) {
    global $wpdb;
    if (!isset($GLOBALS['modernrock_artist_directory'])) $GLOBALS['modernrock_artist_directory'] = [];
    $cache =& $GLOBALS['modernrock_artist_directory'];
    $missing = [];
    foreach ($names as $name) {
        if (!is_string($name) || $name === '' || array_key_exists($name, $cache)) continue;
        $missing[$name] = $name;
        $cache[$name] = ['artist' => null, 'photo' => null];
    }
    foreach (array_chunk(array_values($missing), 100) as $chunk) {
        $parts = []; $args = [];
        foreach ($chunk as $name) { $parts[] = 'SELECT %s AS requested_name'; $args[] = $name; }
        $names_sql = $wpdb->prepare(implode(' UNION ALL ', $parts), $args);
        $rows = $wpdb->get_results("SELECT n.requested_name, p.ID, p.post_name,
            (p.post_type='post' AND EXISTS (SELECT 1 FROM {$wpdb->term_relationships} r
             JOIN {$wpdb->term_taxonomy} t ON t.term_taxonomy_id=r.term_taxonomy_id
             WHERE r.object_id=p.ID AND t.taxonomy='category' AND t.term_id=12)) AS is_artist
            FROM ($names_sql) n JOIN {$wpdb->posts} p ON p.post_title=n.requested_name
            WHERE p.post_status='publish' ORDER BY p.ID ASC", ARRAY_A);
        foreach ($rows as $row) {
            $entry =& $cache[$row['requested_name']];
            if ($entry['photo'] === null) $entry['photo'] = $row;
            if ($row['is_artist'] && $entry['artist'] === null) $entry['artist'] = $row;
            unset($entry);
        }
        // Preserve the former slug fallback without an OR across two indexes.
        $parts = []; $args = [];
        foreach ($chunk as $name) {
            if ($cache[$name]['artist'] !== null) continue;
            $parts[] = 'SELECT %s AS requested_name, %s AS requested_slug';
            $args[] = $name; $args[] = sanitize_title($name);
        }
        if ($parts) {
            $names_sql = $wpdb->prepare(implode(' UNION ALL ', $parts), $args);
            $rows = $wpdb->get_results("SELECT n.requested_name, p.ID, p.post_name
                FROM ($names_sql) n JOIN {$wpdb->posts} p ON p.post_name=n.requested_slug
                WHERE p.post_status='publish' AND p.post_type='post'
                AND EXISTS (SELECT 1 FROM {$wpdb->term_relationships} r
                    JOIN {$wpdb->term_taxonomy} t ON t.term_taxonomy_id=r.term_taxonomy_id
                    WHERE r.object_id=p.ID AND t.taxonomy='category' AND t.term_id=12)
                ORDER BY p.ID ASC", ARRAY_A);
            foreach ($rows as $row) {
                if ($cache[$row['requested_name']]['artist'] === null) $cache[$row['requested_name']]['artist'] = $row;
            }
        }
        $ids = [];
        foreach ($chunk as $name) {
            if ($cache[$name]['photo']) $ids[] = (int) $cache[$name]['photo']['ID'];
        }
        if ($ids) {
            _prime_post_caches(array_unique($ids), false, true);
            modernrock_prime_thumbnail_ids($ids);
        }
    }
}

function modernrock_artist_directory_entry($name) {
    $name = (string) $name;
    modernrock_prime_artist_directory([$name]);
    return $GLOBALS['modernrock_artist_directory'][$name] ?? ['artist' => null, 'photo' => null];
}

function modernrock_artist_photo($name, $size = 'medium', $fallback = '') {
    $entry = modernrock_artist_directory_entry($name);
    if ($entry['photo']) {
        $thumbnail = get_post_thumbnail_id((int) $entry['photo']['ID']);
        if ($thumbnail) {
            $image = wp_get_attachment_image_src($thumbnail, $size);
            if (!empty($image[0])) return $image[0];
        }
    }
    return $fallback;
}

function modernrock_prime_thumbnail_ids($posts) {
    $ids = [];
    foreach ($posts as $post) {
        $id = get_post_thumbnail_id($post);
        if ($id) $ids[] = $id;
    }
    if ($ids) _prime_post_caches(array_unique($ids), false, true);
}

// Templates call wp_get_attachment_image_src directly, bypassing WP's automatic
// thumbnail preloading in the_post_thumbnail(). Prime only frontend post lists.
add_filter('the_posts', function ($posts, $query) {
    if (!is_admin() && $posts && $posts[0] instanceof WP_Post) modernrock_prime_thumbnail_ids($posts);
    return $posts;
}, 20, 2);

function modernrock_prime_concert_rows($events, $artist = '', $city = '') {
    $names = []; $options = [];
    foreach ($events as $event) {
        if ($artist !== '') $event['artist'] = $artist;
        if ($city !== '') $event['city'] = $city;
        if ($artist === '' && !empty($event['artist'])) $names[] = $event['artist'];
        $key = modernrock_event_key($event);
        if ($key === '') continue;
        $options[] = '_transient_gigsbot_event_v1_' . $key;
        $options[] = '_transient_timeout_gigsbot_event_v1_' . $key;
    }
    if ($names) modernrock_prime_artist_directory($names);
    if ($options && !wp_using_ext_object_cache()) wp_prime_option_caches(array_unique($options));
}

/** Editor dropdowns need titles, not 10,000 bodies, term lists and meta sets. */
function modernrock_directory_titles($category) {
    global $wpdb;
    $category = (int) $category;
    if (!in_array($category, [12, 13], true)) return [];
    $key = $category . ':' . get_current_user_id() . ':' . (int) is_admin();
    if (isset($GLOBALS['modernrock_directory_titles'][$key])) return $GLOBALS['modernrock_directory_titles'][$key];
    // Let WordPress retain its admin status/permission/category rules, but fetch
    // only IDs. Loading bodies, metadata and taxonomy for this selector is wasteful.
    $query = new WP_Query([
        'cat' => $category, 'posts_per_page' => 10000, 'orderby' => 'title', 'order' => 'ASC',
        'fields' => 'ids', 'no_found_rows' => true,
        'update_post_meta_cache' => false, 'update_post_term_cache' => false,
    ]);
    $titles = [];
    foreach (array_chunk($query->posts, 1000) as $ids) {
        $id_list = implode(',', array_map('intval', $ids));
        $rows = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts} WHERE ID IN ($id_list)", OBJECT_K);
        foreach ($ids as $id) {
            if (isset($rows[$id])) $titles[] = apply_filters('the_title', $rows[$id]->post_title, $id);
        }
    }
    return $GLOBALS['modernrock_directory_titles'][$key] = $titles;
}

function modernrock_clear_directory_titles() {
    unset($GLOBALS['modernrock_directory_titles'], $GLOBALS['modernrock_artist_directory'], $GLOBALS['modernrock_venue_ids']);
}
add_action('save_post_post', 'modernrock_clear_directory_titles');
add_action('deleted_post', 'modernrock_clear_directory_titles');
add_action('set_object_terms', function ($object_id, $terms, $tt_ids, $taxonomy) {
    if ($taxonomy === 'category') modernrock_clear_directory_titles();
}, 10, 4);
add_action('edited_category', 'modernrock_clear_directory_titles');
add_action('delete_category', 'modernrock_clear_directory_titles');

/** Use the main paginated query once; templates previously repeated it. */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query() || $query->is_feed()) return;
    $path = (string) wp_parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if ($query->is_home() && preg_match('~^/(?:page/[1-9][0-9]*/?)?$~', $path)) {
        $query->set('cat', '3,5,6,16,8,10,23,16,17,141');
        $query->set('posts_per_page', 21);
        $query->set('ignore_sticky_posts', true);
    } elseif ($query->is_category(3)) {
        $query->set('posts_per_page', 15);
    }
});

/** Cache public search IDs/counts briefly; keep WP's matching and ranking intact. */
function modernrock_cached_public_query($args, $context) {
    if (is_admin() || is_user_logged_in()) return new WP_Query($args);
    $key = 'modernrock_search_v1_' . md5(wp_json_encode([
        $context, $args, get_locale(), get_option('modernrock_search_generation', '1'),
    ]));
    $cached = get_transient($key);
    $query = new WP_Query();
    if (is_array($cached) && isset($cached['ids'], $cached['found'], $cached['pages'])) {
        $restore = function ($posts, $current) use ($query, $cached) {
            if ($current !== $query) return $posts;
            $ids = array_map('intval', $cached['ids']);
            if ($ids) _prime_post_caches($ids, true, true);
            $current->found_posts = (int) $cached['found'];
            $current->max_num_pages = (int) $cached['pages'];
            return $ids;
        };
        add_filter('posts_pre_query', $restore, 20, 2);
        try {
            $query->query($args);
        } finally {
            remove_filter('posts_pre_query', $restore, 20);
        }
        return $query;
    }
    $query->query($args);
    global $wpdb;
    if (!$wpdb->last_error) {
        set_transient($key, [
            'ids' => wp_list_pluck($query->posts, 'ID'),
            'found' => (int) $query->found_posts, 'pages' => (int) $query->max_num_pages,
        ], 90);
    }
    return $query;
}

function modernrock_invalidate_search_results() {
    update_option('modernrock_search_generation', microtime(), true);
}
add_action('save_post_post', 'modernrock_invalidate_search_results');
add_action('save_post_page', 'modernrock_invalidate_search_results');
add_action('deleted_post', 'modernrock_invalidate_search_results');
add_action('set_object_terms', function ($object_id, $terms, $tt_ids, $taxonomy) {
    if ($taxonomy === 'category') modernrock_invalidate_search_results();
}, 10, 4);
