<?php
get_header();
$term = get_queried_object();
$legacy_tickets = $term instanceof WP_Term && (int) $term->parent === 2872;
?>
<div class="block_left">
    <?php modernrock_archive_heading(); ?>
    <?php if ($legacy_tickets): ?>
        <p>Архив публикаций этого раздела. <a href="<?php echo esc_url(home_url('/afisha/')); ?>">Актуальная афиша концертов →</a></p>
    <?php endif; ?>
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <article class="bdetails">
                <div class="date"><?php echo esc_html(get_the_date('d.m.Y')); ?></div>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>
        <div class="pagination"><?php the_posts_pagination(); ?></div>
    <?php else: ?>
        <p>В этом разделе пока нет публикаций.</p>
    <?php endif; ?>
</div>
<aside class="block_right aligned-sidebar">
    <?php include __DIR__ . '/sn_recommend.php'; ?>
</aside>
<?php get_footer(); ?>
