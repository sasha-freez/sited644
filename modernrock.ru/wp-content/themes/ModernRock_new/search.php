<?php get_header(); ?>
<div class="block_left">
    <h1>Результаты поиска: <?php echo esc_html(get_search_query(false)); ?></h1>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="bdetails">
                <h2><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php endwhile; ?>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p>Ничего не найдено. Попробуйте изменить поисковый запрос.</p>
    <?php endif; ?>
</div>
<aside class="block_right">
    <?php get_template_part('sn_banners_r'); ?>
</aside>
<?php get_footer(); ?>
