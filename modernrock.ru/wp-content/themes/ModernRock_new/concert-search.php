<?php
get_header();
$term = modernrock_search_term('q');
$page = modernrock_search_page();
$results = modernrock_concert_search($term, $page);
$cities = modernrock_concert_search_cities($term);
?>
<div class="block_left concert-search-page">
    <h1 class="h1">Поиск по концертам</h1>
    <div class="csearch">
        <form action="/groups/" method="get">
            <input type="text" class="inp" name="q" value="<?php echo esc_attr($term); ?>" placeholder="Артист, площадка или город" />
            <input type="image" src="/images/i_search.png" class="submit" alt="Найти" />
        </form>
    </div>
    <?php if ($term !== ''): ?>
        <h2 class="h2">Афиша по запросу: <?php echo esc_html($term); ?></h2>
        <p>Выберите артиста, площадку или город, чтобы посмотреть ближайшие концерты.</p>
    <?php endif; ?>
    <?php if ($page === 1 && $cities): ?>
        <h2 class="h3">Города</h2>
        <ul class="concert-city-tabs" aria-label="Афиша по городам"><?php foreach ($cities as $city): ?>
            <li><a href="<?php echo esc_url($city['url']); ?>"><?php echo esc_html($city['title']); ?></a></li>
        <?php endforeach; ?></ul>
    <?php endif; ?>
    <div class="concert-results"><ul class="concert-results-grid">
    <?php while ($results->have_posts()): $results->the_post();
        $image = wp_get_attachment_image_url(get_post_thumbnail_id(), 'medium');
    ?>
        <li class="concert-result"><div class="concert-result-card">
            <?php if ($image): ?><div class="concert-result-image"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" width="275" height="160" loading="lazy" /></a></div><?php endif; ?>
            <div class="concert-result-kind"><?php echo has_category(13) ? 'Площадка' : 'Артист'; ?></div>
            <div class="concert-result-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
        </div></li>
    <?php endwhile; wp_reset_postdata(); ?>
    </ul></div>
    <?php if (!$results->post_count && !($page === 1 && $cities)): ?>
        <p><?php echo $term === '' ? 'Введите имя артиста, название площадки или город.' : 'Ничего не найдено. Попробуйте другое название.'; ?></p>
    <?php endif; ?>
    <?php modernrock_search_pagination('/groups/', $term, $page, $results->max_num_pages); ?>
</div>
<aside class="block_right">
    <?php include __DIR__ . '/sn_banners_r1.php'; ?>
    <?php include __DIR__ . '/sn_subscribe.php'; ?>
</aside>
<?php get_footer(); ?>
