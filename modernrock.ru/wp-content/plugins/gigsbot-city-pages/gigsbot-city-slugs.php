<?php
/**
 * Plugin Name: GigsBot City Pages
 * Description: SEO-страницы афиши по городам /afisha/moskva/ и т.д.
 * Version: 1.3
 */

defined('ABSPATH') or die('No access');

function gigsbot_city_slugs() {
    return [
        'moskva'                    => 'Москва',
        'spb'                       => 'Санкт-Петербург',
        'rostov-na-donu'            => 'Ростов-на-Дону',
        'ekaterinburg'              => 'Екатеринбург',
        'kazan'                     => 'Казань',
        'krasnodar'                 => 'Краснодар',
        'nizhniy-novgorod'          => 'Нижний Новгород',
        'sochi'                     => 'Сочи',
        'stavropol'                 => 'Ставрополь',
        'kaliningrad'               => 'Калининград',
        'gelendzhik'                => 'Геленджик',
        'samara'                    => 'Самара',
        'voronezh'                  => 'Воронеж',
        'kirov'                     => 'Киров',
        'novosibirsk'               => 'Новосибирск',
        'tyumen'                    => 'Тюмень',
        'ufa'                       => 'Уфа',
        'yaroslavl'                 => 'Ярославль',
        'krasnoyarsk'               => 'Красноярск',
        'vladivostok'               => 'Владивосток',
        'perm'                      => 'Пермь',
        'penza'                     => 'Пенза',
        'orenburg'                  => 'Оренбург',
        'izhevsk'                   => 'Ижевск',
        'volgograd'                 => 'Волгоград',
        'khabarovsk'                => 'Хабаровск',
        'irkutsk'                   => 'Иркутск',
        'chelyabinsk'               => 'Челябинск',
        'tula'                      => 'Тула',
        'astrahan'                  => 'Астрахань',
        'barnaul'                   => 'Барнаул',
        'tomsk'                     => 'Томск',
        'ryazan'                    => 'Рязань',
        'saratov'                   => 'Саратов',
        'lipetsk'                   => 'Липецк',
        'kemerovo'                  => 'Кемерово',
        'ulyanovsk'                 => 'Ульяновск',
        'omsk'                      => 'Омск',
        'krym'                      => 'Крым',
        'elista'                    => 'Элиста',
        'tambov'                    => 'Тамбов',
        'surgut'                    => 'Сургут',
        'smolensk'                  => 'Смоленск',
        'velikiy-novgorod'          => 'Великий Новгород',
        'pyatigorsk'                => 'Пятигорск',
        'anapa'                     => 'Анапа',
        'simferopol'                => 'Симферополь',
        'tver'                      => 'Тверь',
        'bryansk'                   => 'Брянск',
        'yuzhno-sakhalinsk'         => 'Южно-Сахалинск',
        'saransk'                   => 'Саранск',
        'kurgan'                    => 'Курган',
        'blagoveshchensk'           => 'Благовещенск',
        'arkhangelsk'               => 'Архангельск',
        'naberezhnye-chelny'        => 'Набережные Челны',
        'chita'                     => 'Чита',
        'cheboksary'                => 'Чебоксары',
        'kursk'                     => 'Курск',
        'vladimir'                  => 'Владимир',
        'tolyatti'                  => 'Тольятти',
        'magnitogorsk'              => 'Магнитогорск',
        'orsk'                      => 'Орск',
        'belgorod'                  => 'Белгород',
        'yalta'                     => 'Ялта',
        'orel'                      => 'Орёл',
        'murmansk'                  => 'Мурманск',
        'lazarevskoe'               => 'Лазаревское',
        'ivanovo'                   => 'Иваново',
        'pskov'                     => 'Псков',
        'novorossiysk'              => 'Новороссийск',
        'sevastopol'                => 'Севастополь',
        'petropavlovsk-kamchatsky'  => 'Петропавловск-Камчатский',
        'novokuznetsk'              => 'Новокузнецк',
        'makhachkala'               => 'Махачкала',
        'yoshkar-ola'               => 'Йошкар-Ола',
        'vladikavkaz'               => 'Владикавказ',
        'suzdal'                    => 'Суздаль',
        'cherepovets'               => 'Череповец',
        'abakan'                    => 'Абакан',
        'yakutsk'                   => 'Якутск',
        'khanty-mansiysk'           => 'Ханты-Мансийск',
        'sterlitamak'               => 'Стерлитамак',
        'kostroma'                  => 'Кострома',
        'kolomna'                   => 'Коломна',
        'nizhniy-tagil'             => 'Нижний Тагил',
        'ulan-ude'                  => 'Улан-Удэ',
        'taganrog'                  => 'Таганрог',
        'serpukhov'                 => 'Серпухов',
        'obninsk'                   => 'Обнинск',
        'vologda'                   => 'Вологда',
        'ussuriysk'                 => 'Уссурийск',
        'syzran'                    => 'Сызрань',
        'petrozavodsk'              => 'Петрозаводск',
        'nalchik'                   => 'Нальчик',
        'bratsk'                    => 'Братск',
        'syktyvkar'                 => 'Сыктывкар',
        'nizhnekamsk'               => 'Нижнекамск',
        'nakhodka'                  => 'Находка',
        'michurinsk'                => 'Мичуринск',
        'maykop'                    => 'Майкоп',
        'kislovodsk'                => 'Кисловодск',
        'kerch'                     => 'Керчь',
        'gorno-altaysk'             => 'Горно-Алтайск',
        'feodosiya'                 => 'Феодосия',
        'dmitrov'                   => 'Дмитров',
        'chekhov'                   => 'Чехов',
        'balakovo'                  => 'Балаково',
        'apatity'                   => 'Апатиты',
        'zlatoust'                  => 'Златоуст',
        'vyborg'                    => 'Выборг',
        'volgodonsk'                => 'Волгодонск',
        'stupino'                   => 'Ступино',
        'severodvinsk'              => 'Северодвинск',
        'rybinsk'                   => 'Рыбинск',
        'rubtsovsk'                 => 'Рубцовск',
        'orekhovo-zuevo'            => 'Орехово-Зуево',
        'nizhniy-vartovsk'          => 'Нижневартовск',
    ];
}

function gigsbot_city_to_slug($city) {
    $flipped = array_flip(gigsbot_city_slugs());
    return isset($flipped[$city]) ? $flipped[$city] : null;
}

function gigsbot_slug_to_city($slug) {
    $slugs = gigsbot_city_slugs();
    return isset($slugs[$slug]) ? $slugs[$slug] : null;
}

function gigsbot_city_prepositional($city) {
    $map = [
        'Москва' => 'Москве', 'Санкт-Петербург' => 'Санкт-Петербурге',
        'Екатеринбург' => 'Екатеринбурге', 'Казань' => 'Казани',
        'Краснодар' => 'Краснодаре', 'Нижний Новгород' => 'Нижнем Новгороде',
        'Новосибирск' => 'Новосибирске', 'Ростов-на-Дону' => 'Ростове-на-Дону',
        'Самара' => 'Самаре', 'Уфа' => 'Уфе', 'Воронеж' => 'Воронеже',
        'Пермь' => 'Перми', 'Тюмень' => 'Тюмени', 'Красноярск' => 'Красноярске',
        'Владивосток' => 'Владивостоке', 'Ярославль' => 'Ярославле',
        'Ижевск' => 'Ижевске', 'Барнаул' => 'Барнауле', 'Иркутск' => 'Иркутске',
        'Хабаровск' => 'Хабаровске', 'Оренбург' => 'Оренбурге',
        'Челябинск' => 'Челябинске', 'Томск' => 'Томске', 'Кемерово' => 'Кемерово',
        'Волгоград' => 'Волгограде', 'Рязань' => 'Рязани', 'Саратов' => 'Саратове',
        'Тула' => 'Туле', 'Омск' => 'Омске', 'Пенза' => 'Пензе',
        'Астрахань' => 'Астрахани', 'Липецк' => 'Липецке', 'Киров' => 'Кирове',
        'Калининград' => 'Калининграде', 'Ульяновск' => 'Ульяновске',
        'Ставрополь' => 'Ставрополе', 'Сочи' => 'Сочи', 'Сургут' => 'Сургуте',
        'Смоленск' => 'Смоленске', 'Тверь' => 'Твери', 'Брянск' => 'Брянске',
        'Мурманск' => 'Мурманске', 'Курск' => 'Курске', 'Белгород' => 'Белгороде',
        'Владимир' => 'Владимире', 'Иваново' => 'Иваново', 'Псков' => 'Пскове',
        'Тольятти' => 'Тольятти', 'Магнитогорск' => 'Магнитогорске',
        'Нижний Тагил' => 'Нижнем Тагиле', 'Пятигорск' => 'Пятигорске',
        'Анапа' => 'Анапе', 'Геленджик' => 'Геленджике',
        'Симферополь' => 'Симферополе', 'Севастополь' => 'Севастополе',
        'Ялта' => 'Ялте', 'Керчь' => 'Керчи', 'Феодосия' => 'Феодосии',
        'Новороссийск' => 'Новороссийске', 'Махачкала' => 'Махачкале',
        'Владикавказ' => 'Владикавказе', 'Нальчик' => 'Нальчике',
        'Кисловодск' => 'Кисловодске', 'Якутск' => 'Якутске',
        'Абакан' => 'Абакане', 'Улан-Удэ' => 'Улан-Удэ',
        'Благовещенск' => 'Благовещенске', 'Петропавловск-Камчатский' => 'Петропавловске-Камчатском',
        'Южно-Сахалинск' => 'Южно-Сахалинске', 'Новокузнецк' => 'Новокузнецке',
        'Братск' => 'Братске', 'Чита' => 'Чите', 'Элиста' => 'Элисте',
        'Тамбов' => 'Тамбове', 'Орёл' => 'Орле', 'Орск' => 'Орске',
        'Саранск' => 'Саранске', 'Йошкар-Ола' => 'Йошкар-Оле',
        'Чебоксары' => 'Чебоксарах', 'Набережные Челны' => 'Набережных Челнах',
        'Великий Новгород' => 'Великом Новгороде', 'Архангельск' => 'Архангельске',
        'Северодвинск' => 'Северодвинске', 'Петрозаводск' => 'Петрозаводске',
        'Сыктывкар' => 'Сыктывкаре', 'Вологда' => 'Вологде',
        'Череповец' => 'Череповце', 'Выборг' => 'Выборге',
        'Кострома' => 'Костроме', 'Рыбинск' => 'Рыбинске',
        'Коломна' => 'Коломне', 'Серпухов' => 'Серпухове',
        'Дмитров' => 'Дмитрове', 'Обнинск' => 'Обнинске', 'Чехов' => 'Чехове',
        'Майкоп' => 'Майкопе', 'Таганрог' => 'Таганроге',
        'Волгодонск' => 'Волгодонске', 'Сызрань' => 'Сызрани',
        'Нижнекамск' => 'Нижнекамске', 'Стерлитамак' => 'Стерлитамаке',
        'Курган' => 'Кургане', 'Ханты-Мансийск' => 'Ханты-Мансийске',
        'Нижневартовск' => 'Нижневартовске', 'Рубцовск' => 'Рубцовске',
        'Горно-Алтайск' => 'Горно-Алтайске', 'Находка' => 'Находке',
        'Уссурийск' => 'Уссурийске', 'Мичуринск' => 'Мичуринске',
        'Балаково' => 'Балаково', 'Золотоуст' => 'Златоусте',
        'Златоуст' => 'Златоусте', 'Ступино' => 'Ступино',
        'Орехово-Зуево' => 'Орехово-Зуево', 'Лазаревское' => 'Лазаревском',
        'Апатиты' => 'Апатитах', 'Крым' => 'Крыму', 'Суздаль' => 'Суздале',
    ];
    return isset($map[$city]) ? $map[$city] : $city;
}


function gigsbot_get_seo_text($city, $city_prep, $total) {
    $texts = [
        'Москва' => 'Москва — концертная столица России, где каждый день проходят выступления мировых и отечественных звёзд. На modernrock.ru собрана полная афиша концертов в Москве с актуальными ценами на билеты от ведущих операторов. Выбирайте события по душе и покупайте билеты без наценок.',
        'Санкт-Петербург' => 'Санкт-Петербург — культурная столица России с богатейшей концертной жизнью. Легендарные площадки города принимают лучших исполнителей страны и мира. На modernrock.ru вы найдёте полную афишу концертов в Петербурге и сможете купить билеты по официальным ценам.',
        'Екатеринбург' => 'Екатеринбург — один из главных музыкальных городов России, родина легендарных рок-групп. Концертная жизнь здесь бьёт ключом круглый год. На modernrock.ru собраны все актуальные концерты в Екатеринбурге с возможностью купить билеты онлайн.',
        'Казань' => 'Казань входит в топ концертных городов России — сюда приезжают все крупные артисты страны. Современные площадки города вмещают тысячи зрителей. На modernrock.ru вы найдёте полную афишу концертов в Казани и купите билеты по официальным ценам.',
        'Краснодар' => 'Краснодар — один из самых активных концертных городов юга России. Тёплый климат и отличная инфраструктура привлекают сюда лучших артистов страны. На modernrock.ru собрана актуальная афиша концертов в Краснодаре с билетами от проверенных операторов.',
        'Нижний Новгород' => 'Нижний Новгород — крупный концертный центр Поволжья с развитой сетью площадок. Сюда регулярно приезжают популярные российские и зарубежные исполнители. На modernrock.ru вы найдёте все концерты в Нижнем Новгороде и сможете купить билеты онлайн.',
        'Новосибирск' => 'Новосибирск — крупнейший концертный город Сибири и неофициальная культурная столица востока страны. Местные площадки принимают самых известных артистов России. На modernrock.ru собрана полная афиша концертов в Новосибирске с актуальными ценами на билеты.',
        'Ростов-на-Дону' => 'Ростов-на-Дону — музыкальная столица юга России с активной концертной жизнью. Сюда приезжают все крупные российские исполнители и зарубежные звёзды. На modernrock.ru вы найдёте актуальную афишу концертов в Ростове-на-Дону и купите билеты по официальным ценам.',
        'Самара' => 'Самара — один из ведущих концертных городов Поволжья с отличными площадками. Крупные туры российских и зарубежных артистов обязательно включают Самару в маршрут. На modernrock.ru собрана полная афиша концертов в Самаре с билетами от проверенных операторов.',
        'Уфа' => 'Уфа — активный концертный город Урала и Поволжья, куда приезжают топовые российские артисты. Современные площадки города принимают крупные туры и фестивали. На modernrock.ru вы найдёте актуальную афишу концертов в Уфе и купите билеты онлайн.',
        'Воронеж' => 'Воронеж — крупный концертный центр Черноземья с богатой музыкальной жизнью. Сюда регулярно приезжают популярные российские исполнители. На modernrock.ru собрана полная афиша концертов в Воронеже с возможностью купить билеты по официальным ценам.',
        'Пермь' => 'Пермь — один из ведущих культурных центров Урала с активной концертной жизнью. Крупные артисты регулярно включают Пермь в свои туры по России. На modernrock.ru вы найдёте актуальную афишу концертов в Перми и купите билеты без лишних наценок.',
        'Красноярск' => 'Красноярск — главный концертный город Восточной Сибири, куда приезжают лучшие артисты страны. Современные площадки города принимают крупные туры и фестивали. На modernrock.ru собрана полная афиша концертов в Красноярске с актуальными ценами на билеты.',
        'Владивосток' => 'Владивосток — крупнейший концертный город Дальнего Востока России. Несмотря на удалённость, сюда регулярно приезжают топовые российские артисты. На modernrock.ru вы найдёте актуальную афишу концертов во Владивостоке и купите билеты онлайн.',
        'Иркутск' => 'Иркутск — важный концертный центр Сибири, куда приезжают ведущие российские исполнители. Город с богатой культурной жизнью и отличными концертными площадками. На modernrock.ru собрана полная афиша концертов в Иркутске с билетами от проверенных операторов.',
        'Хабаровск' => 'Хабаровск — один из главных концертных городов Дальнего Востока с развитой культурной инфраструктурой. Крупные туры российских артистов регулярно включают Хабаровск в маршрут. На modernrock.ru вы найдёте актуальную афишу концертов в Хабаровске.',
        'Челябинск' => 'Челябинск — крупный концертный город Урала с активной музыкальной жизнью. Сюда приезжают все известные российские исполнители и зарубежные звёзды. На modernrock.ru собрана полная афиша концертов в Челябинске с актуальными ценами на билеты.',
        'Тюмень' => 'Тюмень — быстро развивающийся концертный город Западной Сибири. Современные площадки принимают топовых российских артистов и крупные музыкальные туры. На modernrock.ru вы найдёте актуальную афишу концертов в Тюмени и купите билеты по официальным ценам.',
        'Волгоград' => 'Волгоград — крупный концертный центр юга России с богатой культурной жизнью. Сюда регулярно приезжают популярные российские исполнители. На modernrock.ru собрана полная афиша концертов в Волгограде с возможностью купить билеты онлайн.',
        'Омск' => 'Омск — один из ведущих концертных городов Западной Сибири с активной музыкальной жизнью. Крупные артисты регулярно включают Омск в свои туры по России. На modernrock.ru вы найдёте актуальную афишу концертов в Омске и купите билеты без лишних наценок.',
    ];

    if (isset($texts[$city])) return $texts[$city];
    return "На странице собраны все актуальные концерты в $city_prep — $total событий с возможностью купить билеты по официальным ценам от ведущих операторов России. Следите за обновлениями афиши на modernrock.ru.";
}


// Sitemap для страниц городов
function gigsbot_sitemap() {
    if (!isset($_GET['gigsbot_sitemap'])) return;

    $slugs = gigsbot_city_slugs();
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($slugs as $slug => $city) {
        echo '<url>';
        echo '<loc>https://modernrock.ru/afisha/' . $slug . '/</loc>';
        echo '<changefreq>daily</changefreq>';
        echo '<priority>0.8</priority>';
        echo '</url>';
    }
    echo '</urlset>';
    exit;
}
add_action('init', 'gigsbot_sitemap');

function gigsbot_add_rewrite_rules() {
    add_rewrite_rule(
        '^afisha/([a-z0-9\-]+)/page/([0-9]+)/?$',
        'index.php?gigsbot_city=$matches[1]&gigsbot_page=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        '^afisha/([a-z0-9\-]+)/?$',
        'index.php?gigsbot_city=$matches[1]',
        'top'
    );
}
add_action('init', 'gigsbot_add_rewrite_rules');

function gigsbot_add_query_vars($vars) {
    $vars[] = 'gigsbot_city';
    $vars[] = 'gigsbot_page';
    return $vars;
}
add_filter('query_vars', 'gigsbot_add_query_vars');

/** Match typographic spelling variants without fuzzy artist-name guesses. */
function gigsbot_artist_name_key($name) {
    $name = html_entity_decode((string) $name, ENT_QUOTES, 'UTF-8');
    $name = preg_replace('/\s+/u', ' ', $name);
    $name = preg_replace('/^[\s"\'«»“”„]+|[\s"\'«»“”„]+$/u', '', $name);
    return str_replace('ё', 'е', mb_strtolower(trim($name), 'UTF-8'));
}

/** Prefer the editor's artist genre, then the site's existing concert genres. */
function gigsbot_artist_genres() {
    $cached = get_transient('gigsbot_artist_genres_v2');
    if (is_array($cached)) return $cached;
    global $wpdb;
    $rows = $wpdb->get_results("SELECT DISTINCT p.post_title, m.meta_value FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} m ON m.post_id=p.ID AND m.meta_key='genre_group'
        JOIN {$wpdb->term_relationships} r ON r.object_id=p.ID
        JOIN {$wpdb->term_taxonomy} t ON t.term_taxonomy_id=r.term_taxonomy_id
        WHERE p.post_status='publish' AND p.post_type='post' AND t.taxonomy='category'
        AND t.term_id=12 AND m.meta_value<>'' AND m.meta_value<>'0'", ARRAY_A);
    $manual = [];
    foreach ($rows as $row) {
        $key = gigsbot_artist_name_key($row['post_title']);
        $manual[$key][] = trim($row['meta_value']);
    }
    $history = $wpdb->get_results("SELECT DISTINCT p.post_title, m.meta_value artist, term.name genre
        FROM {$wpdb->posts} p
        JOIN {$wpdb->term_relationships} r ON r.object_id=p.ID
        JOIN {$wpdb->term_taxonomy} t ON t.term_taxonomy_id=r.term_taxonomy_id
        JOIN {$wpdb->terms} term ON term.term_id=t.term_id
        LEFT JOIN {$wpdb->postmeta} m ON m.post_id=p.ID AND m.meta_key='group_afisha'
        WHERE p.post_status='publish' AND p.post_type='post' AND t.taxonomy='category' AND t.parent=2872", ARRAY_A);
    $map = []; $sources = [];
    // These describe a particular event, not a transferable artist genre.
    $formats = ['Фестивали', 'Open Air', 'SALE', 'Детям', 'Шоу', 'Балет'];
    foreach ($history as $row) {
        if (in_array($row['genre'], $formats, true)) continue;
        $artist = trim((string) $row['artist']);
        $key = gigsbot_artist_name_key($artist !== '' ? $artist : $row['post_title']);
        if ($key === '') continue;
        $map[$key][] = $row['genre'];
        $sources[$key] = 'concert_categories';
    }
    foreach ($manual as $key => $values) {
        $values = array_values(array_unique($values));
        // Conflicting profiles with the same name need editorial review.
        $map[$key] = count($values) === 1 ? $values : [];
        $sources[$key] = count($values) === 1 ? 'artist_profile' : 'ambiguous';
    }
    $genres = [];
    foreach ($map as $key => $values) {
        $map[$key] = array_values(array_unique($values));
        sort($map[$key]);
        foreach ($map[$key] as $genre) $genres[$genre] = $genre;
    }
    asort($genres);
    $result = ['artists' => $map, 'genres' => $genres, 'sources' => $sources];
    set_transient('gigsbot_artist_genres_v2', $result, HOUR_IN_SECONDS);
    return $result;
}

function gigsbot_event_genres($event, $data = null) {
    if ($data === null) $data = gigsbot_artist_genres();
    $key = gigsbot_artist_name_key($event['artist'] ?? '');
    return $data['artists'][$key] ?? [];
}

function gigsbot_filter_artist_genre($concerts, $genre, $artists) {
    return array_values(array_filter($concerts, function ($event) use ($genre, $artists) {
        $name = gigsbot_artist_name_key($event['artist'] ?? '');
        return isset($artists[$name]) && in_array($genre, $artists[$name], true);
    }));
}

function gigsbot_clear_artist_genres() {
    delete_transient('gigsbot_artist_genres_v2');
}
add_action('save_post', 'gigsbot_clear_artist_genres');
add_action('deleted_post', 'gigsbot_clear_artist_genres');
add_action('set_object_terms', function ($object_id, $terms, $tt_ids, $taxonomy) {
    if ($taxonomy === 'category') gigsbot_clear_artist_genres();
}, 10, 4);
foreach (['added_post_meta', 'updated_post_meta', 'deleted_post_meta'] as $hook) {
    add_action($hook, function ($meta_id, $post_id, $meta_key) {
        if (in_array($meta_key, ['genre_group', 'group_afisha'], true)) gigsbot_clear_artist_genres();
    }, 10, 3);
}
add_action('edited_category', 'gigsbot_clear_artist_genres');
add_action('delete_category', 'gigsbot_clear_artist_genres');

function gigsbot_template_redirect() {
    // The afisha root has no WordPress category route; open the default city.
    $request_path = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    if (rtrim($request_path, '/') === '/afisha') {
        $destination = home_url('/afisha/moskva/');
        if (isset($_GET['genre']) && is_string($_GET['genre'])) {
            $destination = add_query_arg('genre', sanitize_text_field(wp_unslash($_GET['genre'])), $destination);
        }
        wp_safe_redirect($destination, 302);
        exit;
    }
    $city_slug = get_query_var('gigsbot_city');
    if (!$city_slug) return;
    $city = gigsbot_slug_to_city($city_slug);
    if (!$city) return;

    $GIGSBOT_API   = 'https://api.tcket.ru';
    $GIGSBOT_TOKEN = 'gigsbot2026';
    $PER_PAGE      = 20;
    $PLACEHOLDER   = 'https://modernrock.ru/wp-content/uploads/2023/07/like-fest.jpg';
    $page          = max(1, (int) get_query_var('gigsbot_page', 1));

    $genre_data = gigsbot_artist_genres();
    $genre = isset($_GET['genre']) && is_string($_GET['genre']) ? sanitize_text_field(wp_unslash($_GET['genre'])) : '';
    $genre_landing = $GLOBALS['modernrock_afisha_landing'] ?? [];
    if ($genre_landing) $genre = $genre_landing['genre'];
    if (!isset($genre_data['genres'][$genre])) $genre = '';
    $filter_unavailable = false;
    $gigsbot_has_page_cities = ['Москва', 'Санкт-Петербург'];
    $gigsbot_has_page_param = in_array($city, $gigsbot_has_page_cities, true) ? '&has_page=1' : '';
    $cache_key = 'gigsbot_city_web_' . md5($city . '_' . $page . $gigsbot_has_page_param);
    $cached = get_transient($cache_key);
    $concerts = []; $total = 0; $total_pages = 1;
    if ($cached !== false) {
        $concerts    = $cached['concerts'];
        $total       = $cached['total'];
        $total_pages = $cached['pages'];
    } else {
        $resp = wp_remote_get($GIGSBOT_API . '/api/city_web?token=' . $GIGSBOT_TOKEN
            . '&city=' . urlencode($city) . '&page=' . $page . '&per_page=' . $PER_PAGE . $gigsbot_has_page_param, ['timeout' => 5]);
        if (!is_wp_error($resp)) {
            $data = json_decode(wp_remote_retrieve_body($resp), true);
            if (!empty($data['concerts'])) {
                $concerts    = $data['concerts'];
                $total       = $data['total'];
                $total_pages = $data['pages'];
                set_transient($cache_key, ['concerts' => $concerts, 'total' => $total, 'pages' => $total_pages], DAY_IN_SECONDS);
            }
        }
    }

    {
        // One complete city snapshot supplies both genre counts and pagination.
        $snapshot_key = 'gigsbot_city_snapshot_v1_' . md5($city . $gigsbot_has_page_param);
        $snapshot = get_transient($snapshot_key);
        if ($snapshot === false) {
            $snapshot = []; $api_page = 1; $api_pages = 1;
            do {
                $response = wp_remote_get($GIGSBOT_API . '/api/city_web?' . http_build_query([
                    'token' => $GIGSBOT_TOKEN, 'city' => $city, 'page' => $api_page, 'per_page' => 1000,
                ]) . $gigsbot_has_page_param, ['timeout' => 8]);
                $batch = !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200
                    ? json_decode(wp_remote_retrieve_body($response), true) : null;
                if (!is_array($batch) || !isset($batch['concerts'], $batch['pages']) || !is_array($batch['concerts'])) {
                    $snapshot = false; break;
                }
                $api_pages = max(1, (int) $batch['pages']);
                if ($api_pages > 20) { $snapshot = false; break; }
                $snapshot = array_merge($snapshot, $batch['concerts']);
                ++$api_page;
            } while ($api_page <= $api_pages);
            if (is_array($snapshot)) set_transient($snapshot_key, $snapshot, 15 * MINUTE_IN_SECONDS);
        }
        $filter_unavailable = !is_array($snapshot);
        $genre_counts = [];
        if (is_array($snapshot)) {
            foreach ($snapshot as $event) {
                foreach (gigsbot_event_genres($event, $genre_data) as $event_genre) {
                    $genre_counts[$event_genre] = isset($genre_counts[$event_genre]) ? $genre_counts[$event_genre] + 1 : 1;
                }
            }
            ksort($genre_counts);
            $filtered = $genre === '' ? $snapshot : gigsbot_filter_artist_genre($snapshot, $genre, $genre_data['artists']);
            $total = count($filtered);
            $total_pages = max(1, (int) ceil($total / $PER_PAGE));
            $concerts = array_slice($filtered, ($page - 1) * $PER_PAGE, $PER_PAGE);
        } elseif ($genre !== '') {
            $concerts = []; $total = 0; $total_pages = 1;
        }
    }
    // Only a complete API snapshot can prove that a requested page does not exist.
    if (!$filter_unavailable && $page > $total_pages) {
        global $wp_query;
        $wp_query->set_404();
        set_query_var('gigsbot_city', '');
        set_query_var('gigsbot_page', 0);
        unset($GLOBALS['modernrock_afisha_landing']);
        status_header(404);
        nocache_headers();
        include get_404_template();
        exit;
    }
    $pagination_url = function ($number) use ($city_slug, $genre, $genre_landing) {
        if ($genre_landing) return rtrim($genre_landing['base'], '/') . ($number > 1 ? '/page/' . $number : '');
        $url = home_url('/afisha/' . $city_slug . '/' . ($number > 1 ? 'page/' . $number . '/' : ''));
        return $genre !== '' ? add_query_arg('genre', $genre, $url) : $url;
    };

    // WordPress post counts differ from the filtered concert count.
    add_filter('aioseo_prev_link', function ($url) use ($page, $pagination_url) {
        return $page > 1 ? $pagination_url($page - 1) : '';
    }, 1000);
    add_filter('aioseo_next_link', function ($url) use ($page, $total_pages, $pagination_url) {
        return $page < $total_pages ? $pagination_url($page + 1) : '';
    }, 1000);

    $all_cities = get_transient('gigsbot_all_cities');
    if ($all_cities === false) {
        $cities_resp = wp_remote_get($GIGSBOT_API . '/api/cities?token=' . $GIGSBOT_TOKEN, ['timeout' => 5]);
        $all_cities = [];
        if (!is_wp_error($cities_resp)) {
            $cd = json_decode(wp_remote_retrieve_body($cities_resp), true);
            if (!empty($cd['cities'])) $all_cities = $cd['cities'];
        }
        set_transient('gigsbot_all_cities', $all_cities, DAY_IN_SECONDS);
    }

    $city_prep = gigsbot_city_prepositional($city);
    $seo_title = "Концерты в $city_prep " . date('Y') . " — афиша и билеты | ModernRock";
    $seo_desc  = "Афиша концертов в $city_prep на " . date('Y') . " год. Билеты по официальным ценам.";
    $canonical = $genre_landing ? $genre_landing['base'] : home_url('/afisha/' . $city_slug . '/');

    add_filter('pre_get_document_title', function() use ($seo_title) { return $seo_title; }, 99);
    add_filter('aioseo_title', function() use ($seo_title) { return $seo_title; }, 99);
    add_filter('aioseo_description', function() use ($seo_desc) { return $seo_desc; }, 99);

    $format_date = function($date_str) {
        $date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $date_str);
        $ts = strtotime($date_str);
        if (!$ts) return $date_str;
        $months = [1=>'января',2=>'февраля',3=>'марта',4=>'апреля',5=>'мая',6=>'июня',
                   7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'];
        $time = date('H:i', $ts);
        return date('j', $ts) . ' ' . $months[(int)date('n', $ts)] . ' ' . date('Y', $ts)
               . ($time !== '00:00' ? ', ' . $time : '');
    };

    $get_photo = function($artist, $placeholder) {
        global $wpdb;
        $post = $wpdb->get_row($wpdb->prepare(
            "SELECT ID FROM wp_posts WHERE post_title = %s AND post_status = 'publish' LIMIT 1", $artist));
        if ($post) {
            $tid = get_post_thumbnail_id($post->ID);
            if ($tid) { $img = wp_get_attachment_image_src($tid, 'full'); if (!empty($img[0])) return $img[0]; }
        }
        return $placeholder;
    };

    get_header();
    ?>
    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[
        {"@type":"ListItem","position":1,"name":"Главная","item":"https://modernrock.ru/"},
        {"@type":"ListItem","position":2,"name":"Афиша","item":"https://modernrock.ru/afisha/moskva/"},
        {"@type":"ListItem","position":3,"name":"Концерты в <?php echo esc_js($city_prep); ?>","item":"<?php echo esc_url($canonical); ?>"}
    ]}
    </script>
    <link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
    <div class="tickets">
        <div class="afisha-filter-panel">
            <div class="afisha-filter-label">Город</div>
            <nav class="afisha-genre-tabs afisha-main-cities" aria-label="Основные города">
                <?php
                $main_city_map = gigsbot_city_slugs();
                $main_city_slugs = ['moskva', 'spb', 'ekaterinburg', 'novosibirsk', 'kazan', 'nizhniy-novgorod', 'krasnodar', 'rostov-na-donu', 'samara'];
                foreach ($main_city_slugs as $slug):
                    if (!isset($main_city_map[$slug])) continue;
                ?>
                <a class="afisha-filter-tab<?php echo $slug === $city_slug ? ' is-active' : ''; ?>" href="<?php echo esc_url(home_url('/afisha/' . $slug . '/')); ?>"<?php if ($slug === $city_slug) echo ' aria-current="page"'; ?>><?php echo esc_html($main_city_map[$slug]); ?></a>
                <?php endforeach; ?>
            </nav>
            <div class="afisha-filter-label">Жанры</div>
            <nav class="afisha-genre-tabs" aria-label="Фильтр по типу и жанру">
                <a class="afisha-filter-tab<?php echo $genre === '' ? ' is-active' : ''; ?>" href="<?php echo esc_url(home_url('/afisha/' . $city_slug . '/')); ?>"<?php if ($genre === '') echo ' aria-current="page"'; ?>>Все события</a>
                <?php foreach ($genre_counts as $name => $count): ?>
                <a class="afisha-filter-tab<?php echo $genre === $name ? ' is-active' : ''; ?>" href="<?php echo esc_url(function_exists('modernrock_afisha_genre_url') ? modernrock_afisha_genre_url($name, $city_slug) : add_query_arg('genre', $name, home_url('/afisha/' . $city_slug . '/'))); ?>"<?php if ($genre === $name) echo ' aria-current="page"'; ?>><?php echo esc_html($name); ?> <span class="afisha-filter-count"><?php echo (int) $count; ?></span></a>
                <?php endforeach; ?>
            </nav>
            <?php if ($filter_unavailable): ?><p class="afisha-filter-help">Фильтры временно недоступны — не удалось загрузить полную афишу.</p><?php endif; ?>
        </div>
        <div class="ticket_list">
            <style>
.gigsbot-city-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;}
.ticket_list .gigsbot-city-grid .gigsbot-card{display:flex;gap:15px;align-items:flex-start;width:100%;min-width:0;box-sizing:border-box;float:none;margin:0;padding:0 0 20px;border-bottom:1px solid #eee;}
.gigsbot-city-grid .gigsbot-card-body{overflow-wrap:anywhere;}
.gigsbot-card-media{flex:0 0 38%;max-width:165px;min-width:0;display:block;}
.gigsbot-card-media img{width:100%;height:auto;border-radius:6px;display:block;}
.gigsbot-card-body{flex:1 1 auto;min-width:0;}
.gigsbot-card-title{font-size:16px;font-weight:600;margin:0 0 6px;line-height:1.3;}
.gigsbot-card-title a{color:#000;text-decoration:none;}
.gigsbot-card-meta{font-size:13px;color:#555;margin:0 0 4px;}
.gigsbot-card-price{font-size:13px;color:#000;margin:0 0 10px;font-weight:500;}
.gigsbot-card-buy{display:inline-block;background:#0e920e;color:#fff;text-align:center;border-radius:6px;padding:8px 18px;font-size:14px;font-weight:600;text-decoration:none;}
@media screen and (max-width:600px){
.gigsbot-city-grid{grid-template-columns:minmax(0,1fr);}
}
@media screen and (max-width:480px){
.ticket_list .gigsbot-city-grid .gigsbot-card{flex-direction:column;}
.gigsbot-city-grid .gigsbot-card-media{width:100%;max-width:none;flex-basis:auto;}
.gigsbot-city-grid .gigsbot-card-body{width:100%;}
.gigsbot-card-media img{aspect-ratio:16/9;object-fit:cover;}
.gigsbot-card-buy{display:block;width:100%;box-sizing:border-box;text-align:center;}
}
.gigsbot-card-nofee{font-size:12px;color:#2e7d32;font-weight:600;margin-top:6px;}
</style>
<h1 class="h3"><?php echo $genre_landing ? esc_html($genre) . ' — концерты' : 'Концерты'; ?> в <?php echo esc_html($city_prep); ?></h1>
            <p style="color:#888;font-size:13px;margin-bottom:16px;">Найдено: <?php echo $total; ?> концертов</p>
            <?php if (empty($concerts)): ?>
                <div class="ticket_no"><?php echo $filter_unavailable ? 'Не удалось загрузить афишу для фильтра. Попробуйте позже.' : ($genre !== '' ? 'По выбранному жанру событий не найдено.' : 'В ближайшее время событий не запланировано.'); ?></div>
            <?php else: ?>
            <div class="gigsbot-city-grid">
            <?php $gigsbot_afisha_internal_url = function($item, $city_name) {
    $item['city'] = $city_name;
    return function_exists('modernrock_event_link')
        ? modernrock_event_link($item)
        : ['url' => $item['url'], 'internal' => false];
};
            foreach ($concerts as $c):
                $date_fmt  = $format_date($c['date']);
                $event_genres = gigsbot_event_genres($c, $genre_data);
                $date_iso  = substr(preg_replace('/\+\d{2}:\d{2}$/', '', $c['date']), 0, 19);
                $photo     = $get_photo($c['artist'], $PLACEHOLDER);
                $gigsbot_afisha_link = $gigsbot_afisha_internal_url($c, $city);
                $gigsbot_afisha_url = $gigsbot_afisha_link['url'];
                $gigsbot_afisha_rel = $gigsbot_afisha_link['internal'] ? '' : ' rel="nofollow" target="_blank"';
                $is_yandex = ($c['source'] === 'yandex');
                $is_ticketland = ($c['source'] === 'ticketland');
            ?>
            <div class="item gigsbot-card" itemscope itemtype="https://schema.org/Event">
                <meta itemprop="name" content="<?php echo esc_attr($c['artist']); ?>">
                <meta itemprop="startDate" content="<?php echo esc_attr($date_iso); ?>">
                <div itemprop="location" itemscope itemtype="https://schema.org/Place" style="display:none">
                    <meta itemprop="name" content="<?php echo esc_attr(modernrock_event_place($c)); ?>">
                    <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                        <meta itemprop="addressLocality" content="<?php echo esc_attr($city); ?>">
                        <meta itemprop="addressCountry" content="RU">
                    </div>
                </div>
                <?php if ($c['price']): ?>
                <div itemprop="offers" itemscope itemtype="https://schema.org/Offer" style="display:none">
                    <meta itemprop="price" content="<?php echo esc_attr($c['price']); ?>">
                    <meta itemprop="priceCurrency" content="RUB">
                    <meta itemprop="url" content="<?php echo esc_attr($c['url']); ?>">
                    <meta itemprop="availability" content="https://schema.org/InStock">
                </div>
                <?php endif; ?>
                <a class="gigsbot-card-media" href="<?php echo esc_url($gigsbot_afisha_url); ?>"<?php echo $gigsbot_afisha_rel; ?>>
                    <img src="<?php echo esc_url($photo); ?>"
                         alt="<?php echo esc_attr($c['artist']); ?>" itemprop="image" loading="lazy" />
                </a>
                <div class="gigsbot-card-body">
                    <div class="gigsbot-card-title">
                        <a href="<?php echo esc_url($gigsbot_afisha_url); ?>"<?php echo $gigsbot_afisha_rel; ?>>
                            <?php echo esc_html($c['artist']); ?>
                        </a>
                    </div>
                    <div class="gigsbot-card-meta">📍 <?php echo esc_html(modernrock_event_place($c)); ?>, <?php echo esc_html($city); ?></div>
                    <div class="gigsbot-card-meta">🕐 <?php echo esc_html($date_fmt); ?></div>
                    <?php if ($event_genres): ?><div class="gigsbot-card-meta gigsbot-card-genres"><?php echo esc_html(implode(' · ', $event_genres)); ?></div><?php endif; ?>
                    <?php if ($c['price']): ?>
                    <div class="gigsbot-card-price">билеты от <?php echo number_format($c["price"], 0, "", " "); ?> руб.</div>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($c['url']); ?>" rel="nofollow noopener" target="_blank" class="gigsbot-card-buy">Купить билет</a>
                    <?php if ($is_ticketland): ?>
                    <div class="gigsbot-card-nofee">✓ Билеты без сервисного сбора</div>
                    <?php endif; ?>
                </div>

            </div>
            <?php endforeach; ?>
            </div>
            <?php
            $base = "https://modernrock.ru/afisha/$city_slug/";
            if ($total_pages > 1):
            ?>
            <div class="gigsbot-pagination" style="width:100% !important; max-width:100% !important; margin:30px 0 !important; text-align:center !important; font-size:14px !important; display:flex !important; flex-wrap:wrap !important; flex-direction:row !important; justify-content:center !important; align-items:center !important; gap:8px 12px !important; padding:0 10px !important; box-sizing:border-box !important; white-space:normal !important; clear:both !important; position:static !important; float:none !important;">
                <?php if ($page > 1): ?>
                    <a href="<?php echo esc_url($pagination_url($page - 1)); ?>" style="display:inline-block !important; position:static !important; color:#333 !important; white-space:nowrap !important; text-decoration:none !important; float:none !important; margin:0 !important; padding:0 !important;">← Назад</a>
                <?php endif; ?>
                <?php for ($p = 1; $p <= $total_pages; $p++):
                    $href = $pagination_url($p);
                    if ($p == $page): ?>
                        <strong style="display:inline-block !important; position:static !important; color:#0e920e !important; float:none !important; margin:0 !important; padding:0 !important;"><?php echo $p; ?></strong>
                    <?php elseif ($p <= 3 || $p >= $total_pages - 2 || abs($p - $page) <= 2): ?>
                        <a href="<?php echo esc_url($href); ?>" style="display:inline-block !important; position:static !important; color:#333 !important; text-decoration:none !important; float:none !important; margin:0 !important; padding:0 !important;"><?php echo $p; ?></a>
                    <?php elseif (abs($p - $page) == 3): ?>
                        <span style="display:inline-block !important; position:static !important; color:#999 !important; float:none !important; margin:0 !important; padding:0 !important;">...</span>
                    <?php endif;
                endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="<?php echo esc_url($pagination_url($page + 1)); ?>" style="display:inline-block !important; position:static !important; color:#333 !important; white-space:nowrap !important; text-decoration:none !important; float:none !important; margin:0 !important; padding:0 !important;">Вперёд →</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
    $seo_text = gigsbot_get_seo_text($city, $city_prep, $total);
    if ($seo_text):
    ?>
    <div style="background:#f9f9f9; border-radius:8px; padding:16px 20px; margin:20px 0; font-size:13px; color:#555; line-height:1.7;">
        <?php echo esc_html($seo_text); ?>
    </div>
    <?php endif; ?>
    <?php
    // Внутренние ссылки — все города (Москва, Питер, потом алфавит)
    $all_slugs = gigsbot_city_slugs();
    $priority_cities = ['moskva' => 'Москва', 'spb' => 'Санкт-Петербург'];
    $other_cities = array_diff_key($all_slugs, $priority_cities);
    asort($other_cities);
    $sorted_slugs = $priority_cities + $other_cities;
    ?>
    <div style="margin:24px 0 20px;">
        <div style="font-size:13px;font-weight:bold;color:#555;margin-bottom:10px;">Афиша концертов в других городах:</div>
        <div style="line-height:2;">
        <?php foreach ($sorted_slugs as $s => $c): ?>
            <?php if ($c === $city): ?>
                <span style="color:#0086c5; font-size:13px; margin-right:8px; font-weight:bold;"><?php echo esc_html($c); ?></span>
            <?php else: ?>
                <a href="/afisha/<?php echo esc_attr($s); ?>/" style="font-size:13px; color:#333; margin-right:8px; text-decoration:none;"><?php echo esc_html($c); ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
    <?php get_footer();
    exit;
}
add_action('template_redirect', 'gigsbot_template_redirect');

function gigsbot_activation() {
    gigsbot_add_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'gigsbot_activation');
