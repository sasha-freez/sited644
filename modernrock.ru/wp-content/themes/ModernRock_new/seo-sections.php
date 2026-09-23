<?php
if (!defined('ABSPATH')) exit;

function modernrock_section_copy($term = null) {
    $term = $term ?: get_queried_object();
    if (!($term instanceof WP_Term)) return [];
    $copy = [
        3 => ['Новости музыки и концертной жизни', 'Новости музыки: релизы, выступления артистов, фестивали и события концертной жизни на ModernRock.'],
        5 => ['Репортажи с концертов и фестивалей', 'Репортажи с концертов и фестивалей: фотографии, впечатления и обзоры выступлений российских и зарубежных артистов.'],
        6 => ['Статьи и истории о музыке', 'Статьи о музыке и музыкальной индустрии: истории артистов, обзоры, подборки и авторские материалы редакции ModernRock.'],
        7 => ['Музыкальные видео и концертные записи', 'Музыкальные клипы, видеоинтервью и записи выступлений: видеоматериалы об артистах и концертной жизни на ModernRock.'],
        8 => ['Конкурсы и розыгрыши билетов', 'Конкурсы ModernRock: условия участия, розыгрыши билетов на концерты и итоги завершённых конкурсов.'],
        9 => ['Рецензии на музыкальные альбомы', 'Рецензии на альбомы российских и зарубежных исполнителей: впечатления, разбор звучания и оценки релизов от редакции ModernRock.'],
        10 => ['Интервью с музыкантами', 'Интервью с музыкантами: разговоры о творчестве, записи альбомов, концертных турах и жизни музыкальной сцены.'],
        12 => ['Группы и исполнители — концерты и билеты', 'Каталог групп и исполнителей по алфавиту: страницы артистов, расписание концертов, площадки и ссылки на билеты.'],
        13 => ['Концертные клубы и площадки', 'Клубы и концертные площадки: афиша выступлений, адреса, расписание событий и билеты на концерты.'],
        16 => ['ModernRock TV — видеоинтервью и выступления', 'ModernRock TV: видеобеседы с музыкантами, концертные репортажи и выступления артистов в архиве редакции.'],
        17 => ['Музыкальные клипы', 'Клипы российских и зарубежных исполнителей: музыкальные видео и публикации об их съёмках на ModernRock.'],
        21 => ['Музыкальные подборки и топ-10', 'Тематические подборки музыки: десять песен, альбомов, артистов и фактов, собранных редакцией ModernRock.'],
        22 => ['Любимые альбомы музыкантов', 'Любимые альбомы музыкантов: записи, повлиявшие на артистов, их музыкальные вкусы и истории знакомства с музыкой.'],
        23 => ['Музыкальный блог ModernRock', 'Авторские истории, впечатления от концертов и фестивалей, музыкальные открытия и наблюдения в блоге ModernRock.'],
        25 => ['Музыкальные новинки и релизы', 'Публикации о новых песнях и альбомах: музыкальные открытия, презентации релизов и рассказы об исполнителях.'],
        176 => ['Статьи о музыке и артистах', 'Истории групп и исполнителей, музыкальные факты, обзоры и тематические статьи редакции ModernRock.'],
        1323 => ['Музыкальные фестивали', 'Музыкальные фестивали: анонсы, программы, участники и публикации о выступлениях и фестивальной жизни.'],
        3029 => ['ModernRock Sounds — музыка и альбомы', 'ModernRock Sounds: альбомы, песни и музыкальные подборки с информацией об исполнителях и релизах.'],
        3030 => ['Альбомы и релизы — #Leaks', 'Каталог альбомов и музыкальных релизов #Leaks: исполнители, названия записей и подборки по музыкальным жанрам.'],
        97 => ['Тексты песен групп и исполнителей', 'Тексты песен российских и зарубежных групп и исполнителей в каталоге ModernRock.'],
        1 => ['Другие музыкальные публикации', 'Музыкальные публикации из архива ModernRock: материалы об исполнителях, альбомах и концертной жизни.'],
    ];
    if (isset($copy[$term->term_id])) return $copy[$term->term_id];
    if ((int) $term->parent === 3030) {
        return [$term->name . ' — альбомы и релизы', 'Музыка в разделе «' . $term->name . '»: альбомы и релизы исполнителей, сведения о записях и публикации каталога #Leaks.'];
    }
    if ((int) $term->parent === 2872) {
        return [$term->name . ' — архив событий', 'Архив событий раздела «' . $term->name . '»: даты, исполнители и площадки. Актуальные концерты доступны в городской афише ModernRock.'];
    }
    return [$term->name . ' — музыкальные материалы', 'Материалы раздела «' . $term->name . '»: публикации об артистах, их музыке и выступлениях в архиве ModernRock.'];
}

function modernrock_archive_heading() {
    $term = get_queried_object();
    $copy = modernrock_section_copy($term);
    echo '<h1 class="h1">' . esc_html($copy ? $copy[0] : get_the_archive_title()) . '</h1>';
}

function modernrock_legacy_genre($term) {
    if (!($term instanceof WP_Term) || (int) $term->parent !== 2872 || !function_exists('gigsbot_artist_genres')) return '';
    $data = gigsbot_artist_genres();
    if (!isset($data['genres'][$term->name])) return '';
    return $term->name;
}

require_once __DIR__ . '/afisha-routes.php';

function modernrock_legacy_routes() {
    return [
        'gigs' => 'moskva', 'spb' => 'spb', 'gigs-moskva' => 'moskva', 'gigs-spb' => 'spb',
        'groups/moskva' => 'moskva', 'groups/sankt-peterburg' => 'spb',
        'groups/ekaterinburg' => 'ekaterinburg', 'groups/koncerty' => 'moskva',
    ];
}
add_action('template_redirect', function () {
    if (is_admin() || is_feed()) return;
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
    $path = preg_replace('~/page/\d+$~', '', $path);
    $routes = modernrock_legacy_routes();
    $target = isset($routes[$path]) ? home_url('/afisha/' . $routes[$path] . '/') : '';
    if ($path === 'redkassa' && !isset($_GET['event'])) $target = home_url('/afisha/moskva/');
    if ($target) {
        wp_safe_redirect($target, 301);
        exit;
    }

}, 1);

function modernrock_venue_page() {
    return is_singular('post') && has_category(13, get_queried_object_id())
        ? max(1, min(1000, (int) modernrock_search_term('concert_page'))) : 1;
}

function modernrock_service_page() {
    return is_page(['dobavit-novost', 'redkassa']);
}

function modernrock_page_description() {
    if (!is_page()) return '';
    $map = [
        'about_us' => 'О ModernRock: редакция музыкального портала, авторы и контакты для связи, сотрудничества и предложений.',
        'reklama-na-sajte' => 'Реклама на ModernRock: баннеры, брендирование и специальные проекты. Контакты редакции, актуальные медиакит и условия размещения по запросу.',
        'nashi-partnery' => 'Партнёры ModernRock: концертные агентства, музыкальные лейблы, билетные сервисы и клубы. Контакты для сотрудничества.',
        'pravoobladatelyam' => 'Информация для правообладателей материалов на ModernRock: порядок обращения в редакцию и контакты для решения вопросов о публикациях.',
        'dobavit-novost' => 'Служебная страница редакции ModernRock для подготовки новостей. Для работы требуется вход под учётной записью редактора.',
        'redkassa' => 'Информация о покупке билетов на концерты. Актуальные предложения и ссылки на билетные сервисы доступны в афише ModernRock.',
    ];
    return $map[get_post_field('post_name', get_queried_object_id())] ?? '';
}

// Redirected archives and editor tools are not indexable sitemap destinations.
add_filter('aioseo_sitemap_exclude_terms', function ($ids) {
    foreach (get_terms(['taxonomy' => 'category', 'hide_empty' => false]) as $term) {
        $path = trim((string) parse_url(get_term_link($term), PHP_URL_PATH), '/');
        if ($term->term_id === 2872 || isset(modernrock_legacy_routes()[$path])) $ids[] = $term->term_id;
    }
    return array_values(array_unique($ids));
});
add_filter('aioseo_sitemap_exclude_posts', function ($ids) {
    foreach (['gigs-moskva', 'gigs-spb', 'redkassa', 'dobavit-novost'] as $slug) {
        $post = get_page_by_path($slug);
        if ($post) $ids[] = $post->ID;
    }
    return array_values(array_unique($ids));
});

// Reuse AIOSEO's current SEO values for social previews, including pagination.
function modernrock_social_tags($tags = []) {
    if (!function_exists('aioseo')) return $tags;
    $tags['og:title'] = aioseo()->helpers->encodeOutputHtml(aioseo()->meta->title->getTitle());
    $tags['og:description'] = aioseo()->helpers->encodeOutputHtml(aioseo()->meta->description->getDescription());
    $tags['og:url'] = esc_url(aioseo()->helpers->canonicalUrl());
    return $tags;
}
add_filter('aioseo_facebook_tags', 'modernrock_social_tags', 1000);
add_action('wp_head', function () {
    if (!function_exists('aioseo') || is_404() || aioseo()->social->output->isAllowed()) return;
    $tags = modernrock_social_tags([
        'og:type' => 'website', 'og:site_name' => 'ModernRock', 'og:locale' => 'ru_RU',
        'og:image' => home_url('/images/modernrock.jpg'),
    ]);
    foreach ($tags as $property => $value) {
        if ($value !== '') echo '<meta property="' . esc_attr($property) . '" content="' . esc_attr(html_entity_decode($value, ENT_QUOTES, 'UTF-8')) . '" />' . "\n";
    }
}, 20);
