<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails events-list">
		<?php wp_reset_query(); ?>
		<?php if (get_the_ID() == '43041' || get_the_ID() == '125982') : ?>
			<?php include('z_afisha_msk.php'); ?>
		<?php elseif(get_the_ID() == '152008'): ?>
			<?php include('z_afisha_all.php'); ?>
		<?php elseif(get_the_ID() == '152010'): ?>
			<?php include('z_all_genre.php'); ?>
		<?php else: ?>
			<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
			<?php while (have_posts()) : the_post(); ?>
			<?php if (!preg_match('/<h1(?:\s|>)/i', get_the_content())): ?><h1 class="h1"><?php the_title(); ?></h1><?php endif; ?>
            <?php the_content(); ?>
            <?php if (is_page('redkassa')): ?><p>Актуальные концерты и ссылки на билеты доступны в <a href="/afisha/">афише ModernRock</a>.</p><?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>

<aside class="block_right">
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>