<?php
/** Public afisha section URLs; historical article permalinks stay unchanged. */
if (!defined('ABSPATH')) exit;

function modernrock_afisha_sections() {
    static $sections = null;
    if ($sections !== null) return $sections;
    $sections = [];
    $terms = get_terms(['taxonomy' => 'category', 'parent' => 2872, 'hide_empty' => false]);
    if (is_wp_error($terms)) return $sections;
    foreach ($terms as $term) {
        $slug = preg_replace('~^tickets_|_(?:tickets|tockets)$~', '', $term->slug);
        $sections[$slug] = $term;
    }
    return $sections;
}

function modernrock_afisha_section_url($term, $page = 1) {
    if (!($term instanceof WP_Term) || $term->taxonomy !== 'category') return '';
    if ((int) $term->term_id === 2872) {
        return home_url('/afisha/moskva/' . ($page > 1 ? 'page/' . (int) $page . '/' : ''));
    }
    if ((int) $term->parent !== 2872) return '';
    $slug = preg_replace('~^tickets_|_(?:tickets|tockets)$~', '', $term->slug);
    return home_url('/afisha/genre/' . $slug . ($page > 1 ? '/page/' . (int) $page : ''));
}

function modernrock_afisha_genre_url($genre, $city_slug) {
    if ($city_slug === 'moskva') {
        foreach (modernrock_afisha_sections() as $term) {
            if ($term->name === $genre) return modernrock_afisha_section_url($term);
        }
    }
    return add_query_arg('genre', $genre, home_url('/afisha/' . $city_slug . '/'));
}

add_action('init', function () {
    foreach (modernrock_afisha_sections() as $slug => $term) {
        add_rewrite_rule('^afisha/genre/' . preg_quote($slug, '~') . '/page/([0-9]+)/?$', 'index.php?cat=' . $term->term_id . '&paged=$matches[1]', 'top');
        add_rewrite_rule('^afisha/genre/' . preg_quote($slug, '~') . '/?$', 'index.php?cat=' . $term->term_id, 'top');
    }
});

// get_term_link powers the sitemap, breadcrumbs and taxonomy navigation, not post permalinks.
add_filter('term_link', function ($url, $term) {
    return modernrock_afisha_section_url($term) ?: $url;
}, 20, 2);

function modernrock_afisha_migrate_link($url) {
    $parts = wp_parse_url($url);
    if (!$parts || !isset($parts['path'])) return $url;
    if (isset($parts['host']) && !in_array(strtolower($parts['host']), ['modernrock.ru', 'www.modernrock.ru'], true)) return $url;
    if (preg_match('~^/tickets/page/([0-9]+)/?$~', $parts['path'], $root_page)) {
        $slug = '';
        $page = (int) $root_page[1];
    } elseif (preg_match('~^/tickets(?:/([^/]+))?(?:/page/([0-9]+))?/?$~', $parts['path'], $match)) {
        $slug = $match[1] ?? '';
        $page = (int) ($match[2] ?? 1);
    } else {
        return $url;
    }
    $term = $slug === '' ? get_term(2872, 'category') : get_category_by_slug($slug);
    $target = modernrock_afisha_section_url($term, max(1, $page));
    if (!$target) return $url;
    if (!empty($parts['query'])) $target .= '?' . $parts['query'];
    if (!empty($parts['fragment'])) $target .= '#' . $parts['fragment'];
    return $target;
}

add_action('template_redirect', function () {
    if (is_admin() || is_feed()) return;
    $request = $_SERVER['REQUEST_URI'] ?? '/';
    $target = modernrock_afisha_migrate_link($request);
    if ($target !== $request) {
        wp_safe_redirect($target, 301);
        exit;
    }
    $path = trim((string) wp_parse_url($request, PHP_URL_PATH), '/');
    if (!preg_match('~^afisha/genre/([^/]+)(?:/page/([0-9]+))?$~', $path, $match)) return;
    $sections = modernrock_afisha_sections();
    $term = $sections[$match[1]] ?? null;
    $genre = modernrock_legacy_genre($term);
    if ($genre === '' || !function_exists('gigsbot_template_redirect')) return;
    $page = max(1, (int) ($match[2] ?? 1));
    $GLOBALS['modernrock_afisha_landing'] = ['genre' => $genre, 'base' => modernrock_afisha_section_url($term)];
    set_query_var('gigsbot_city', 'moskva');
    set_query_var('gigsbot_page', $page);
    global $wp_query;
    $wp_query->is_404 = false;
    $wp_query->is_category = true;
    $wp_query->is_archive = true;
    $wp_query->queried_object = $term;
    $wp_query->queried_object_id = $term->term_id;
    status_header(200);
    gigsbot_template_redirect();
}, 0);

function modernrock_afisha_content_links($content) {
    if (is_admin() || strpos($content, '/tickets') === false) return $content;
    return preg_replace_callback('~(\bhref\s*=\s*)(["\x27])([^"\x27]*)\2~i', function ($match) {
        $url = html_entity_decode($match[3], ENT_QUOTES, 'UTF-8');
        $target = modernrock_afisha_migrate_link($url);
        return $target === $url ? $match[0] : $match[1] . $match[2] . esc_url($target) . $match[2];
    }, $content);
}
add_filter('the_content', 'modernrock_afisha_content_links', 20);
add_filter('widget_text', 'modernrock_afisha_content_links', 20);
add_filter('widget_custom_html_content', 'modernrock_afisha_content_links', 20);
add_filter('wp_nav_menu_objects', function ($items) {
    foreach ($items as $item) $item->url = modernrock_afisha_migrate_link($item->url);
    return $items;
});
add_filter('bcn_breadcrumb_url', 'modernrock_afisha_migrate_link');
add_filter('bcn_breadcrumb_title', function ($title, $types, $id) {
    return (int) $id === 2872 && in_array('category', $types, true) ? 'Афиша' : $title;
}, 20, 3);
