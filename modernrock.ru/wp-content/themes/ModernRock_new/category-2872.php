<?php get_header(); ?>
<?php
// === Настройки ===
$GIGSBOT_API = 'https://api.tcket.ru';
$GIGSBOT_TOKEN = 'gigsbot2026';
$PER_PAGE = 20;
$PLACEHOLDER = 'https://modernrock.ru/wp-content/uploads/2023/07/like-fest.jpg';

$gigsbot_afisha_internal_url = function($item, $city_name) {
    global $wpdb;
    $artist_slug = sanitize_title($item['artist']);
    $post_exists = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM wp_posts WHERE post_name = %s AND post_status = 'publish' AND post_type = 'post' LIMIT 1",
        $artist_slug
    ));
    if ($post_exists && function_exists('concert_city_to_slug')) {
        $city_slug_for_url = concert_city_to_slug($city_name);
        $date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $item['date']);
        $ts = strtotime($date_str);
        if ($city_slug_for_url && $ts) {
            $internal_url = home_url('/concert/' . $artist_slug . '-' . $city_slug_for_url . '-' . date('Y-m-d', $ts) . '/');
            return ['url' => $internal_url, 'internal' => true];
        }
    }
    return ['url' => $item['url'], 'internal' => false];
};

// === Определяем город ===
if (isset($_POST['set_city'])) {
    $_SESSION['geocity'] = sanitize_text_field($_POST['set_city']);
}
$current_city = isset($_SESSION['geocity']) ? $_SESSION['geocity'] : 'Москва';

// === Текущая страница пагинации ===
$currentPageURL = explode('/page/', $_SERVER["REQUEST_URI"]);
$currentPage = isset($currentPageURL[1]) ? (int)$currentPageURL[1] : 1;

// === Получаем список городов ===
$cities_response = wp_remote_get($GIGSBOT_API . '/api/cities?token=' . $GIGSBOT_TOKEN, ['timeout' => 5]);
$all_cities = ['Москва', 'Санкт-Петербург'];
if (!is_wp_error($cities_response)) {
    $cities_data = json_decode(wp_remote_retrieve_body($cities_response), true);
    if (!empty($cities_data['cities'])) $all_cities = $cities_data['cities'];
}

// === Получаем концерты города ===
$concerts_url = $GIGSBOT_API . '/api/city_web?token=' . $GIGSBOT_TOKEN . '&city=' . urlencode($current_city) . '&page=' . $currentPage . '&per_page=' . $PER_PAGE;
$concerts_response = wp_remote_get($concerts_url, ['timeout' => 5]);
$concerts = [];
$total = 0;
$total_pages = 1;
if (!is_wp_error($concerts_response)) {
    $concerts_data = json_decode(wp_remote_retrieve_body($concerts_response), true);
    if (!empty($concerts_data['concerts'])) {
        $concerts = $concerts_data['concerts'];
        $total = $concerts_data['total'];
        $total_pages = $concerts_data['pages'];
    }
}

// === Функция: получить фото артиста из WordPress ===
function get_artist_photo($artist_name, $placeholder) {
    global $wpdb;
    // Ищем страницу артиста по названию
    $post = $wpdb->get_row($wpdb->prepare(
        "SELECT ID FROM wp_posts WHERE post_title = %s AND post_status = 'publish' AND post_type = 'post' LIMIT 1",
        $artist_name
    ));
    if ($post) {
        $thumb_id = get_post_thumbnail_id($post->ID);
        if ($thumb_id) {
            $img = wp_get_attachment_image_src($thumb_id, 'full');
            if (!empty($img[0])) return $img[0];
        }
    }
    return $placeholder;
}

// === Функция: форматирование даты ===
function format_concert_date($date_str) {
    $date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $date_str);
    $ts = strtotime($date_str);
    if (!$ts) return $date_str;
    $months = [1=>'января',2=>'февраля',3=>'марта',4=>'апреля',5=>'мая',6=>'июня',
               7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'];
    $day = date('j', $ts);
    $month = $months[(int)date('n', $ts)];
    $year = date('Y', $ts);
    $time = date('H:i', $ts);
    return $time !== '00:00' ? "$day $month $year, $time" : "$day $month $year";
}
?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />

<div class="tickets">
    <div class="tk-land">
        <div class="tk-calendar">
            <a href="http://modernrock.ru/afisha-koncertov">Календарь событий</a>
        </div>
        <form method="post">
            <select name="set_city" id="set_city" onChange="this.form.submit();">
                <?php foreach ($all_cities as $city): ?>
                    <option value="<?php echo esc_attr($city); ?>" <?php if ($city === $current_city) echo 'selected="selected"'; ?>>
                        <?php echo esc_html($city); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <div class="ticket_list">
        <div class="h3">Концерты в <?php echo esc_html($current_city); ?></div>

        <?php if (empty($concerts)): ?>
            <div class="ticket_no">В ближайшее время событий не запланировано.</div>
        <?php else: ?>

        <?php foreach ($concerts as $c):
            $date_fmt = format_concert_date($c['date']);
            $date_iso = substr(preg_replace('/\+\d{2}:\d{2}$/', '', $c['date']), 0, 19);
            $artist_photo = get_artist_photo($c['artist'], $PLACEHOLDER);
            $is_yandex = ($c['source'] === 'yandex');
            $gigsbot_afisha_link = $gigsbot_afisha_internal_url($c, $current_city);
            $gigsbot_afisha_url = $gigsbot_afisha_link['url'];
            $gigsbot_afisha_rel = $gigsbot_afisha_link['internal'] ? '' : ' rel="nofollow" target="_blank"';
        ?>
        <!-- Schema.org Event -->
        <div itemscope itemtype="https://schema.org/Event">
            <meta itemprop="name" content="<?php echo esc_attr($c['artist']); ?>">
            <meta itemprop="startDate" content="<?php echo esc_attr($date_iso); ?>">
            <div itemprop="location" itemscope itemtype="https://schema.org/Place">
                <meta itemprop="name" content="<?php echo esc_attr($c['place']); ?>">
                <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <meta itemprop="addressLocality" content="<?php echo esc_attr($current_city); ?>">
                    <meta itemprop="addressCountry" content="RU">
                </div>
            </div>
            <?php if ($c['price']): ?>
            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <meta itemprop="price" content="<?php echo esc_attr($c['price']); ?>">
                <meta itemprop="priceCurrency" content="RUB">
                <meta itemprop="url" content="<?php echo esc_attr($c['url']); ?>">
            </div>
            <?php endif; ?>

            <div class="item">
                <div class="img">
                    <a href="<?php echo esc_url($gigsbot_afisha_url); ?>"<?php echo $gigsbot_afisha_rel; ?>>
                        <b></b><img src="<?php echo esc_url(kama_thumb_src('w=165&h=96', $artist_photo)); ?>"
                             width="165" height="96"
                             alt="<?php echo esc_attr($c['artist']); ?>"
                             itemprop="image" />
                    </a>
                </div>
                <div class="desc">
                    <div class="name">
                        <a href="<?php echo esc_url($gigsbot_afisha_url); ?>"<?php echo $gigsbot_afisha_rel; ?>>
                            <?php echo esc_html($c['artist']); ?>
                        </a>
                    </div>
                    <div class="club"><?php echo esc_html($c['place']); ?>, <?php echo esc_html($current_city); ?></div>
                    <div class="date"><?php echo esc_html($date_fmt); ?></div>
                    <?php if ($c['price']): ?>
                    <div class="price">билеты от <?php echo number_format($c['price'], 0, '', ' '); ?> руб.</div>
                    <?php endif; ?>
                    <?php if ($is_yandex): ?>
                    <div style="font-size:11px; color:#888; margin-top:3px;">Скидка 10% по промокоду <b>TX692473</b></div>
                    <?php endif; ?>
                </div>
                <div class="buytickets">
                    <div class="buy">
                        <a href="<?php echo esc_url($gigsbot_afisha_url); ?>"<?php echo $gigsbot_afisha_rel; ?>>Купить билет</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php
        // Пагинация
        if ($total_pages > 1):
            $url_base = $currentPageURL[0];
            $url_page = $url_base . '/page/';
        ?>
        <div class="pagination" style="margin: 20px 0; text-align: center;">
            <?php if ($currentPage > 1): ?>
                <a href="<?php echo $url_page . ($currentPage - 1); ?>" style="margin: 0 5px;">← Назад</a>
            <?php endif; ?>
            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                <?php if ($p == $currentPage): ?>
                    <strong style="margin: 0 5px;"><?php echo $p; ?></strong>
                <?php elseif ($p <= 3 || $p >= $total_pages - 2 || abs($p - $currentPage) <= 2): ?>
                    <a href="<?php echo $p == 1 ? $url_base : $url_page . $p; ?>" style="margin: 0 5px;"><?php echo $p; ?></a>
                <?php elseif (abs($p - $currentPage) == 3): ?>
                    <span style="margin: 0 5px;">...</span>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($currentPage < $total_pages): ?>
                <a href="<?php echo $url_page . ($currentPage + 1); ?>" style="margin: 0 5px;">Вперёд →</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>