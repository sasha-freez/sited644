<?php
/**
 * Plugin Name: GigsBot Concert Pages
 * Description: Страницы концертов /concert/artist-city-date/
 * Version: 1.2
 */

defined('ABSPATH') or die('No access');

define('CONCERT_GIGSBOT_API',   'https://api.tcket.ru');
define('CONCERT_GIGSBOT_TOKEN', 'gigsbot2026');

// Slug города
function concert_city_to_slug($city) {
    $map = [
        'Москва'=>'moskva','Санкт-Петербург'=>'spb','Ростов-на-Дону'=>'rostov-na-donu',
        'Екатеринбург'=>'ekaterinburg','Казань'=>'kazan','Краснодар'=>'krasnodar',
        'Нижний Новгород'=>'nizhniy-novgorod','Сочи'=>'sochi','Ставрополь'=>'stavropol',
        'Калининград'=>'kaliningrad','Геленджик'=>'gelendzhik','Самара'=>'samara',
        'Воронеж'=>'voronezh','Киров'=>'kirov','Новосибирск'=>'novosibirsk',
        'Тюмень'=>'tyumen','Уфа'=>'ufa','Ярославль'=>'yaroslavl',
        'Красноярск'=>'krasnoyarsk','Владивосток'=>'vladivostok','Пермь'=>'perm',
        'Пенза'=>'penza','Оренбург'=>'orenburg','Ижевск'=>'izhevsk',
        'Волгоград'=>'volgograd','Хабаровск'=>'khabarovsk','Иркутск'=>'irkutsk',
        'Челябинск'=>'chelyabinsk','Тула'=>'tula','Астрахань'=>'astrahan',
        'Барнаул'=>'barnaul','Томск'=>'tomsk','Рязань'=>'ryazan',
        'Саратов'=>'saratov','Липецк'=>'lipetsk','Кемерово'=>'kemerovo',
        'Ульяновск'=>'ulyanovsk','Омск'=>'omsk','Крым'=>'krym',
        'Элиста'=>'elista','Тамбов'=>'tambov','Сургут'=>'surgut',
        'Смоленск'=>'smolensk','Великий Новгород'=>'velikiy-novgorod',
        'Пятигорск'=>'pyatigorsk','Анапа'=>'anapa','Симферополь'=>'simferopol',
        'Тверь'=>'tver','Брянск'=>'bryansk','Южно-Сахалинск'=>'yuzhno-sakhalinsk',
        'Саранск'=>'saransk','Курган'=>'kurgan','Благовещенск'=>'blagoveshchensk',
        'Архангельск'=>'arkhangelsk','Набережные Челны'=>'naberezhnye-chelny',
        'Чита'=>'chita','Чебоксары'=>'cheboksary','Курск'=>'kursk',
        'Владимир'=>'vladimir','Тольятти'=>'tolyatti','Магнитогорск'=>'magnitogorsk',
        'Орск'=>'orsk','Белгород'=>'belgorod','Ялта'=>'yalta','Орёл'=>'orel',
        'Мурманск'=>'murmansk','Лазаревское'=>'lazarevskoe','Иваново'=>'ivanovo',
        'Псков'=>'pskov','Новороссийск'=>'novorossiysk','Севастополь'=>'sevastopol',
        'Петропавловск-Камчатский'=>'petropavlovsk-kamchatsky',
        'Новокузнецк'=>'novokuznetsk','Махачкала'=>'makhachkala',
        'Йошкар-Ола'=>'yoshkar-ola','Владикавказ'=>'vladikavkaz',
        'Суздаль'=>'suzdal','Череповец'=>'cherepovets','Абакан'=>'abakan',
        'Якутск'=>'yakutsk','Ханты-Мансийск'=>'khanty-mansiysk',
        'Стерлитамак'=>'sterlitamak','Кострома'=>'kostroma','Коломна'=>'kolomna',
        'Нижний Тагил'=>'nizhniy-tagil','Улан-Удэ'=>'ulan-ude',
        'Таганрог'=>'taganrog','Серпухов'=>'serpukhov','Обнинск'=>'obninsk',
        'Вологда'=>'vologda','Уссурийск'=>'ussuriysk','Сызрань'=>'syzran',
        'Петрозаводск'=>'petrozavodsk','Нальчик'=>'nalchik','Братск'=>'bratsk',
        'Сыктывкар'=>'syktyvkar','Нижнекамск'=>'nizhnekamsk','Находка'=>'nakhodka',
        'Мичуринск'=>'michurinsk','Майкоп'=>'maykop','Кисловодск'=>'kislovodsk',
        'Керчь'=>'kerch','Горно-Алтайск'=>'gorno-altaysk','Феодосия'=>'feodosiya',
        'Дмитров'=>'dmitrov','Чехов'=>'chekhov','Балаково'=>'balakovo',
        'Апатиты'=>'apatity','Златоуст'=>'zlatoust','Выборг'=>'vyborg',
        'Волгодонск'=>'volgodonsk','Ступино'=>'stupino','Северодвинск'=>'severodvinsk',
        'Рыбинск'=>'rybinsk','Рубцовск'=>'rubtsovsk','Орехово-Зуево'=>'orekhovo-zuevo',
        'Нижневартовск'=>'nizhniy-vartovsk',
    ];
    return isset($map[$city]) ? $map[$city] : null;
}


function concert_city_prepositional($city) {
    $map = [
        'Москва'=>'Москве','Санкт-Петербург'=>'Санкт-Петербурге','Екатеринбург'=>'Екатеринбурге',
        'Казань'=>'Казани','Краснодар'=>'Краснодаре','Нижний Новгород'=>'Нижнем Новгороде',
        'Новосибирск'=>'Новосибирске','Ростов-на-Дону'=>'Ростове-на-Дону','Самара'=>'Самаре',
        'Уфа'=>'Уфе','Воронеж'=>'Воронеже','Пермь'=>'Перми','Тюмень'=>'Тюмени',
        'Красноярск'=>'Красноярске','Владивосток'=>'Владивостоке','Ярославль'=>'Ярославле',
        'Ижевск'=>'Ижевске','Барнаул'=>'Барнауле','Иркутск'=>'Иркутске',
        'Хабаровск'=>'Хабаровске','Оренбург'=>'Оренбурге','Челябинск'=>'Челябинске',
        'Томск'=>'Томске','Кемерово'=>'Кемерово','Волгоград'=>'Волгограде',
        'Рязань'=>'Рязани','Саратов'=>'Саратове','Тула'=>'Туле','Омск'=>'Омске',
        'Пенза'=>'Пензе','Астрахань'=>'Астрахани','Липецк'=>'Липецке','Киров'=>'Кирове',
        'Калининград'=>'Калининграде','Ульяновск'=>'Ульяновске','Ставрополь'=>'Ставрополе',
        'Сочи'=>'Сочи','Сургут'=>'Сургуте','Смоленск'=>'Смоленске','Тверь'=>'Твери',
        'Брянск'=>'Брянске','Мурманск'=>'Мурманске','Курск'=>'Курске','Белгород'=>'Белгороде',
        'Владимир'=>'Владимире','Иваново'=>'Иваново','Псков'=>'Пскове','Тольятти'=>'Тольятти',
        'Магнитогорск'=>'Магнитогорске','Нижний Тагил'=>'Нижнем Тагиле',
        'Пятигорск'=>'Пятигорске','Анапа'=>'Анапе','Геленджик'=>'Геленджике',
        'Симферополь'=>'Симферополе','Севастополь'=>'Севастополе','Ялта'=>'Ялте',
        'Керчь'=>'Керчи','Феодосия'=>'Феодосии','Новороссийск'=>'Новороссийске',
        'Махачкала'=>'Махачкале','Владикавказ'=>'Владикавказе','Нальчик'=>'Нальчике',
        'Кисловодск'=>'Кисловодске','Якутск'=>'Якутске','Абакан'=>'Абакане',
        'Улан-Удэ'=>'Улан-Удэ','Благовещенск'=>'Благовещенске','Чита'=>'Чите',
        'Элиста'=>'Элисте','Тамбов'=>'Тамбове','Орёл'=>'Орле','Орск'=>'Орске',
        'Саранск'=>'Саранске','Йошкар-Ола'=>'Йошкар-Оле','Чебоксары'=>'Чебоксарах',
        'Набережные Челны'=>'Набережных Челнах','Великий Новгород'=>'Великом Новгороде',
        'Архангельск'=>'Архангельске','Северодвинск'=>'Северодвинске',
        'Петрозаводск'=>'Петрозаводске','Сыктывкар'=>'Сыктывкаре','Вологда'=>'Вологде',
        'Череповец'=>'Череповце','Выборг'=>'Выборге','Кострома'=>'Костроме',
        'Рыбинск'=>'Рыбинске','Коломна'=>'Коломне','Серпухов'=>'Серпухове',
        'Дмитров'=>'Дмитрове','Обнинск'=>'Обнинске','Чехов'=>'Чехове','Майкоп'=>'Майкопе',
        'Таганрог'=>'Таганроге','Волгодонск'=>'Волгодонске','Сызрань'=>'Сызрани',
        'Нижнекамск'=>'Нижнекамске','Стерлитамак'=>'Стерлитамаке','Курган'=>'Кургане',
        'Ханты-Мансийск'=>'Ханты-Мансийске','Нижневартовск'=>'Нижневартовске',
        'Рубцовск'=>'Рубцовске','Горно-Алтайск'=>'Горно-Алтайске','Находка'=>'Находке',
        'Уссурийск'=>'Уссурийске','Лазаревское'=>'Лазаревском','Апатиты'=>'Апатитах',
        'Крым'=>'Крыму','Суздаль'=>'Суздале','Петропавловск-Камчатский'=>'Петропавловске-Камчатском',
        'Южно-Сахалинск'=>'Южно-Сахалинске','Новокузнецк'=>'Новокузнецке',
        'Братск'=>'Братске','Якутск'=>'Якутске','Мичуринск'=>'Мичуринске',
        'Балаково'=>'Балаково','Златоуст'=>'Златоусте','Ступино'=>'Ступино',
    ];
    return isset($map[$city]) ? $map[$city] : $city;
}

function gigsbot_concert_rewrite_rules() {
    add_rewrite_rule(
        '^concert/([a-z0-9\-]+)-(\d{4}-\d{2}-\d{2})/?$',
        'index.php?gigsbot_concert_slug=$matches[1]&gigsbot_concert_date=$matches[2]',
        'top'
    );
}
add_action('init', 'gigsbot_concert_rewrite_rules');

function gigsbot_concert_query_vars($vars) {
    $vars[] = 'gigsbot_concert_slug';
    $vars[] = 'gigsbot_concert_date';
    return $vars;
}
add_filter('query_vars', 'gigsbot_concert_query_vars');

function gigsbot_parse_concert_slug($slug) {
    $city_slugs = [
        'moskva','spb','ekaterinburg','kazan','novosibirsk','krasnodar',
        'nizhniy-novgorod','rostov-na-donu','samara','ufa','voronezh',
        'perm','tyumen','krasnoyarsk','vladivostok','irkutsk','khabarovsk',
        'chelyabinsk','barnaul','omsk','volgograd','tula','ryazan',
        'saratov','yaroslavl','tomsk','kemerovo','izhevsk','orenburg',
        'penza','tolyatti','ulyanovsk','lipetsk','astrahan',
        'naberezhnye-chelny','kirov','cheboksary','kaliningrad','murmansk',
        'tver','bryansk','smolensk','surgut','novorossiysk','kursk',
        'belgorod','vladimir','pskov','makhachkala','yakutsk','vladikavkaz',
        'nalchik','stavropol','sochi','gelendzhik','anapa','pyatigorsk',
        'kislovodsk','simferopol','sevastopol','yalta','saransk',
        'yoshkar-ola','syktyvkar','petrozavodsk','arkhangelsk','chita',
        'ulan-ude','blagoveshchensk','yuzhno-sakhalinsk',
        'petropavlovsk-kamchatsky','abakan','khanty-mansiysk','magnitogorsk',
        'nizhniy-tagil','taganrog','novokuznetsk','bratsk','ussuriysk',
        'nakhodka','velikiy-novgorod','tambov','orel','kurgan','elista',
        'nizhnekamsk','sterlitamak','kolomna','serpukhov','vologda',
        'cherepovets','rybinsk','kostroma','ivanovo','zlatoust','vyborg',
        'volgodonsk','severodvinsk','rubtsovsk','orekhovo-zuevo',
        'nizhniy-vartovsk','gorno-altaysk','feodosiya','kerch','suzdal',
    ];
    usort($city_slugs, function($a, $b) { return strlen($b) - strlen($a); });
    foreach ($city_slugs as $city) {
        if (substr($slug, -(strlen($city))) === $city && strlen($slug) > strlen($city)) {
            return [substr($slug, 0, strlen($slug) - strlen($city) - 1), $city];
        }
    }
    $parts = explode('-', $slug);
    $city = array_pop($parts);
    return [implode('-', $parts), $city];
}

function gigsbot_concert_template_redirect() {
    $concert_slug = get_query_var('gigsbot_concert_slug');
    $concert_date = get_query_var('gigsbot_concert_date');
    if (!$concert_slug || !$concert_date) return;

    list($artist_slug, $city_slug) = gigsbot_parse_concert_slug($concert_slug);

    global $wpdb;
    $artist_post = $wpdb->get_row($wpdb->prepare(
        "SELECT p.ID, p.post_title FROM {$wpdb->posts} p
         JOIN {$wpdb->term_relationships} r ON r.object_id=p.ID
         JOIN {$wpdb->term_taxonomy} t ON t.term_taxonomy_id=r.term_taxonomy_id
         WHERE p.post_name=%s AND p.post_status='publish' AND p.post_type='post'
         AND t.taxonomy='category' AND t.term_id=12 LIMIT 1", $artist_slug
    ));
    $not_found = function () {
        global $wp_query;
        set_query_var('gigsbot_concert_slug', '');
        set_query_var('gigsbot_concert_date', '');
        $wp_query->set_404();
        status_header(404);
        include get_404_template();
        exit;
    };
    if (!$artist_post) $not_found();
    $artist_name = $artist_post->post_title;
    $city_name = '';
    foreach (gigsbot_city_slugs() as $name) {
        if (concert_city_to_slug($name) === $city_slug) { $city_name = $name; break; }
    }
    if (!$city_name || !modernrock_event_date($concert_date)) $not_found();
    $event_key = '';
    if (isset($_GET['event'])) {
        if (!is_string($_GET['event']) || !preg_match('/^[a-f0-9]{32}$/D', $_GET['event'])) $not_found();
        $event_key = $_GET['event'];
    }
    $concert = modernrock_resolve_concert($artist_name, $city_name, $city_slug, $concert_date, $event_key);
    if (is_wp_error($concert)) {
        if ($concert->get_error_code() === 'event_ambiguous') {
            wp_safe_redirect(get_permalink($artist_post->ID), 302);
            exit;
        }
        if ($concert->get_error_code() === 'event_unavailable') {
            header('Retry-After: 300');
            wp_die('Не удалось обновить афишу. Попробуйте открыть концерт чуть позже.', 'Афиша временно недоступна', ['response' => 503]);
        }
        $not_found();
    }
    if ($event_key !== '') $GLOBALS['modernrock_selected_event_key'] = $event_key;

    $concert_place = modernrock_event_place($concert);
    $concert_genres = function_exists('gigsbot_event_genres') ? gigsbot_event_genres($concert) : [];

    // Фото артиста
    $thumb_id = get_post_thumbnail_id($artist_post->ID);
    $artist_photo = '';
    if ($thumb_id) { $img = wp_get_attachment_image_src($thumb_id, 'full'); if (!empty($img[0])) $artist_photo = $img[0]; }
    if (!$artist_photo && !empty($concert['picture'])) $artist_photo = $concert['picture'];

    // Дата
    $date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $concert['date']);
    $ts = strtotime($date_str);
    $months = [1=>'января',2=>'февраля',3=>'марта',4=>'апреля',5=>'мая',6=>'июня',
               7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'];
    $day   = date('j', $ts);
    $month = $months[(int)date('n', $ts)];
    $year  = date('Y', $ts);
    $time  = date('H:i', $ts);
    $date_fmt  = "$day $month $year" . ($time !== '00:00' ? ", $time" : '');
    $date_iso  = substr($date_str, 0, 19);
    $is_yandex = ($concert['source'] === 'yandex');
    $is_ticketland = ($concert['source'] === 'ticketland');
    $artist_url = home_url('/groups/' . $artist_slug . '.html');
    $canonical  = home_url('/concert/' . $concert_slug . '-' . $concert_date . '/');
    if ($event_key !== '') $canonical = add_query_arg('event', $event_key, $canonical);
    $city_slug_afisha = concert_city_to_slug($concert['city']);
    $city_url = $city_slug_afisha ? home_url('/afisha/' . $city_slug_afisha . '/') : null;

    // Шаблонное описание
    $description = $artist_name . ' выступит в ' . concert_city_prepositional($concert['city']) . ' ' . $day . ' ' . $month . ' ' . $year . ' на площадке ' . $concert_place . '.';
    if ($concert['price']) $description .= ' Билеты от ' . number_format($concert['price'], 0, '', ' ') . ' рублей — покупайте заранее.';

    // Похожие концерты в том же городе
    $cp_similar_has_page_cities = ['Москва', 'Санкт-Петербург'];
    $cp_similar_has_page_param = in_array($concert['city'], $cp_similar_has_page_cities, true) ? '&has_page=1' : '';
    $similar_cache = 'gigsbot_similar_' . md5($concert['city'] . $concert_date . $cp_similar_has_page_param);
    $similar = get_transient($similar_cache);
    if ($similar === false) {
        $sresp = wp_remote_get(CONCERT_GIGSBOT_API . '/api/city_web?token=' . CONCERT_GIGSBOT_TOKEN
            . '&city=' . urlencode($concert['city']) . '&page=1&per_page=50' . $cp_similar_has_page_param, ['timeout' => 5]);
        $similar = [];
        if (!is_wp_error($sresp)) {
            $sdata = json_decode(wp_remote_retrieve_body($sresp), true);
            if (!empty($sdata['concerts'])) {
                foreach ($sdata['concerts'] as $sc) {
                    if (substr($sc['date'], 0, 10) !== $concert_date && count($similar) < 4) {
                        $similar[] = $sc;
                    }
                }
            }
        }
        set_transient($similar_cache, $similar, DAY_IN_SECONDS);
    }

    $seo_title = $artist_name . ' — концерт в ' . concert_city_prepositional($concert['city']) . ' ' . $day . ' ' . $month . ' ' . $year . ' | ModernRock';
    $seo_desc  = 'Концерт ' . $artist_name . ' ' . $day . ' ' . $month . ' ' . $year . ' в ' . $concert_place . ', ' . $concert['city'] . '. Купить билеты по официальным ценам.';

    add_filter('pre_get_document_title', function() use ($seo_title) { return $seo_title; }, 99);
    add_filter('aioseo_title',           function() use ($seo_title) { return $seo_title; }, 99);
    add_filter('aioseo_description',     function() use ($seo_desc)  { return $seo_desc;  }, 99);

    get_header();
    ?>
    <script type="application/ld+json">
    <?php echo json_encode([
        '@context'=>'https://schema.org','@type'=>'Event',
        'name'=>$artist_name.' — концерт в '.$concert['city'],
        'startDate'=>$date_iso,
        'location'=>['@type'=>'Place','name'=>$concert_place,
            'address'=>['@type'=>'PostalAddress','addressLocality'=>$concert['city'],'addressCountry'=>'RU']],
        'performer'=>['@type'=>'MusicGroup','name'=>$artist_name],
        'offers'=>['@type'=>'Offer','price'=>$concert['price']?:0,'priceCurrency'=>'RUB',
            'url'=>$concert['url'],'availability'=>'https://schema.org/InStock'],
        'image'=>$artist_photo,
    ], JSON_UNESCAPED_UNICODE); ?>
    </script>
    <link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
    <style>
    .cp { max-width: 780px; }
    .cp-crumb { font-size: 13px; color: #999; margin-bottom: 24px; }
    .cp-crumb a { color: #999; text-decoration: none; }
    .cp-crumb a:hover { color: #333; }
    .cp-hero { display: flex; gap: 28px; align-items: flex-start; margin-bottom: 28px; }
    .cp-photo { flex-shrink: 0; width: 220px; height: 220px; object-fit: cover; border-radius: 12px; }
    .cp-info { flex: 1; }
    .cp-artist { font-size: 28px; font-weight: 700; margin: 0 0 14px 0; line-height: 1.2; }
    .cp-meta { margin-bottom: 16px; }
    .cp-meta-row { font-size: 15px; color: #444; margin-bottom: 6px; }
    .cp-meta-row a { color: #0e920e; text-decoration: none; }
    .cp-meta-row a:hover { text-decoration: underline; }
    .cp-price { font-size: 16px; font-weight: 600; color: #111; margin-bottom: 16px; }

    .cp-icon { display: inline-block; vertical-align: -3px; margin-right: 8px; color: #0e920e; }
    .cp-btn { display: block; width: 100%; box-sizing: border-box; text-align: center; background: #0e920e; color: #fff !important; font-size: 17px; font-weight: 600; padding: 15px 28px; border-radius: 8px; text-decoration: none !important; box-shadow: 0 2px 10px rgba(14,146,14,0.28); }
    .cp-btn:hover { background: #0a7a0a; }
    .cp-nofee { font-size: 13px; color: #2e7d32; font-weight: 600; margin-top: 8px; text-align: center; }
    .cp-promo { background: #eef9ee; border: 1px solid #cdebc7; border-radius: 12px; padding: 18px; margin-top: 14px; }
    .cp-promo-ttl { display: flex; align-items: center; gap: 8px; font-size: 17px; font-weight: 700; color: #0e920e; margin-bottom: 8px; }
    .cp-promo-icon { flex-shrink: 0; }
    .cp-promo-txt { font-size: 13px; color: #555; margin-bottom: 12px; line-height: 1.5; }
    .cp-promo-code { background: #fff; border: 2px dashed #0e920e; border-radius: 8px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; cursor: pointer; }
    .cp-promo-code b { font-size: 20px; letter-spacing: 2px; }
    .cp-promo-copy { font-size: 13px; color: #0e920e; font-weight: 600; }
    .cp-promo-link { display: block; background: #0e920e; color: #fff !important; text-align: center; padding: 12px; border-radius: 8px; font-size: 15px; text-decoration: none !important; font-weight: 600; }
    .cp-promo-more { display: block; text-align: center; margin-top: 10px; font-size: 12px; color: #0e920e; text-decoration: none; }
    .cp-promo-more:hover { text-decoration: underline; }
    .cp-desc { font-size: 15px; line-height: 1.7; color: #555; margin-bottom: 24px; border-left: 3px solid #eee; padding-left: 14px; }
    .cp-similar { margin-top: 32px; }
    .cp-similar h3 { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    .cp-similar h3 a { color: inherit; text-decoration: none; }
    .cp-similar h3 a:hover { text-decoration: underline; }
    .cp-similar-list { display: flex; flex-direction: column; gap: 10px; }
    .cp-similar-item { display: flex; align-items: center; gap: 12px; padding: 10px 16px; background: #f9f9f9; border-radius: 8px; text-decoration: none; color: #333; }
    .cp-similar-photo { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
    .cp-similar-info { flex: 1; min-width: 0; }
    .cp-similar-item:hover { background: #f0f0f0; }
    .cp-similar-name { font-weight: 600; font-size: 15px; }
    .cp-similar-meta { font-size: 13px; color: #888; margin-top: 2px; }
    .cp-similar-price { font-size: 14px; font-weight: 600; color: #0e920e; white-space: nowrap; }
    .cp-back { color: #0e920e; font-size: 14px; text-decoration: none; display: inline-block; margin-top: 24px; }
    .cp-back:hover { text-decoration: underline; }
    @media (max-width: 600px) {
        .cp-hero { flex-direction: column; }
        .cp-photo { width: 100%; height: 240px; }
        .cp-artist { font-size: 22px; }
    }
    </style>

    <div class="block_left">
    <div class="cp">
        <div class="cp-crumb">
            <a href="<?php echo home_url('/'); ?>">ModernRock</a> →
            <a href="<?php echo esc_url($artist_url); ?>"><?php echo esc_html($artist_name); ?></a> →
            Концерт в <?php echo esc_html(concert_city_prepositional($concert['city'])); ?>
        </div>

        <div class="cp-hero">
            <?php if ($artist_photo): ?>
            <img class="cp-photo" src="<?php echo esc_url($artist_photo); ?>" alt="<?php echo esc_attr($artist_name); ?>" />
            <?php endif; ?>

            <div class="cp-info">
                <h1 class="cp-artist"><?php echo esc_html($artist_name); ?></h1>
                <div class="cp-meta">
                    <?php if ($concert_genres): ?><div class="cp-meta-row cp-genres"><?php echo esc_html(implode(' · ', $concert_genres)); ?></div><?php endif; ?>
                    <?php
                    $cp_city_html = $city_url
                        ? '<a href="' . esc_url($city_url) . '">' . esc_html($concert['city']) . '</a>'
                        : esc_html($concert['city']);
                    $cp_venue_html = esc_html($concert_place);
                    $cp_venue_post = $wpdb->get_row($wpdb->prepare(
                        "SELECT p.post_name FROM wp_posts p JOIN wp_term_relationships tr ON tr.object_id = p.ID WHERE tr.term_taxonomy_id = 13 AND p.post_title = %s AND p.post_status = 'publish' LIMIT 1",
                        $concert['place']
                    ));
                    if ($cp_venue_post) {
                        $cp_venue_html = '<a href="' . esc_url(home_url('/club/' . $cp_venue_post->post_name . '.html')) . '">' . esc_html($concert_place) . '</a>';
                    }
                    ?>
                    <div class="cp-meta-row"><svg class="cp-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg> <?php echo $cp_city_html; ?>, <?php echo $cp_venue_html; ?></div>
                    <div class="cp-meta-row"><svg class="cp-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg> <?php echo esc_html($date_fmt); ?></div>
                </div>

                <div class="cp-cta">
                <?php if ($concert['price']): ?>
                <div class="cp-price">от <?php echo number_format($concert['price'], 0, '', ' '); ?> ₽</div>
                <?php endif; ?>

                <a href="<?php echo esc_url($concert['url']); ?>" rel="nofollow" target="_blank" class="cp-btn">Купить билет →</a>

                <?php if ($is_ticketland): ?>
                <div class="cp-nofee">✓ Билеты без сервисного сбора</div>
                <?php endif; ?>


                <?php if ($is_yandex): ?>
                <div class="cp-promo">
                    <div class="cp-promo-ttl"><svg class="cp-promo-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41L13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5" fill="currentColor" stroke="none"/></svg> Скидка 100% на сервисный сбор</div>
                    <div class="cp-promo-txt">Скопируй промокод и введи в приложении «Яндекс Афиша» — сервисный сбор обнулится. Работает только там.</div>
                    <div class="cp-promo-code" onclick="navigator.clipboard.writeText('AN300764'); document.getElementById('cpl').textContent='Скопировано ✓'; setTimeout(()=>document.getElementById('cpl').textContent='Скопировать',2000);">
                        <b>AN300764</b>
                        <span id="cpl" class="cp-promo-copy">Скопировать</span>
                    </div>
                    <a href="<?php echo esc_url($concert['url']); ?>" rel="nofollow" target="_blank" class="cp-promo-link">Перейти с промокодом →</a>
                    <a href="https://modernrock.ru/promo" class="cp-promo-more">Все промокоды Яндекс Афиши →</a>
                </div>
                <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="cp-desc"><?php echo esc_html($description); ?></div>

        <?php if (!empty($similar)): ?>
        <div class="cp-similar">
            <h3><?php if ($city_url): ?><a href="<?php echo esc_url($city_url); ?>">Ещё концерты в <?php echo esc_html(concert_city_prepositional($concert['city'])); ?></a><?php else: ?>Ещё концерты в <?php echo esc_html(concert_city_prepositional($concert['city'])); ?><?php endif; ?></h3>
            <div class="cp-similar-list">
            <?php modernrock_prime_concert_rows($similar); foreach ($similar as $sc):
                $sc_date = preg_replace('/\+\d{2}:\d{2}$/', '', $sc['date']);
                $sc_ts = strtotime($sc_date);
                $sc_fmt = date('j', $sc_ts) . ' ' . $months[(int)date('n', $sc_ts)];
                $sc_link = modernrock_event_link($sc);
                $sc_url = $sc_link['url'];
                $sc_photo = modernrock_artist_photo($sc['artist'], 'medium');
            ?>
            <a href="<?php echo esc_url($sc_url); ?>" class="cp-similar-item">
                <?php if ($sc_photo): ?>
                <img class="cp-similar-photo" src="<?php echo esc_url($sc_photo); ?>" alt="<?php echo esc_attr($sc['artist']); ?>" loading="lazy" />
                <?php endif; ?>
                <div class="cp-similar-info">
                    <div class="cp-similar-name"><?php echo esc_html($sc['artist']); ?></div>
                    <div class="cp-similar-meta"><?php echo esc_html($sc_fmt); ?> · <?php echo esc_html(modernrock_event_place($sc)); ?></div>
                </div>
                <?php if ($sc['price']): ?>
                <div class="cp-similar-price">от <?php echo number_format($sc['price'], 0, '', ' '); ?> ₽</div>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <a href="<?php echo esc_url($artist_url); ?>" class="cp-back">← Все концерты <?php echo esc_html($artist_name); ?></a>
    </div>
    </div>

    <aside class="block_right">
        <?php
        $tpl = get_template_directory();
        if (file_exists($tpl.'/sn_adv_google.php')) include $tpl.'/sn_adv_google.php';
        if (file_exists($tpl.'/sn_banners_r.php'))  include $tpl.'/sn_banners_r.php';
        ?>
    </aside>
    <?php get_footer(); exit;
}
add_action('template_redirect', 'gigsbot_concert_template_redirect');

function gigsbot_concert_activation() {
    gigsbot_concert_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'gigsbot_concert_activation');
