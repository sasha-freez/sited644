<?php
require_once dirname(__DIR__, 3) . '/wp-load.php';
header('Content-Type: text/html; charset=UTF-8');
$term = modernrock_search_term('q');
if (mb_strlen($term, 'UTF-8') < 3) exit;
$results = modernrock_concert_search($term, 1, 6, false);
$cities = array_slice(modernrock_concert_search_cities($term), 0, 3);
foreach ($cities as $city): ?>
<a href="<?php echo esc_url($city['url']); ?>"><div class="hint_item"><div class="hint_title"><?php echo esc_html($city['title']); ?><span class="hint_kind">Афиша города</span></div></div></a>
<?php endforeach;
while ($results->have_posts()): $results->the_post();
$image = wp_get_attachment_image_url(get_post_thumbnail_id(), 'thumbnail'); ?>
<a href="<?php the_permalink(); ?>"><div class="hint_item">
    <?php if ($image): ?><div class="hint_image"><img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" /></div><?php endif; ?>
    <div class="hint_title"><?php the_title(); ?><span class="hint_kind"><?php echo has_category(13) ? 'Площадка' : 'Артист'; ?></span></div>
</div></a>
<?php endwhile; wp_reset_postdata();
if (!$results->post_count && !$cities): ?>
<div class="hint_item">Ничего не найдено. Попробуйте другое название.</div>
<?php else: ?>
<a href="<?php echo esc_url(add_query_arg('q', $term, home_url('/groups/'))); ?>"><div class="hint_item hint_all">Все результаты →</div></a>
<?php endif; ?>
