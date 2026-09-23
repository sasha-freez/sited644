<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>

	<div class="bdetails d_video">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="date"><?php the_time('d.m.Y') ?></div>
		<h1><?php the_title();?></h1>
		<?php include('sn_social.php'); ?>
		
		<div class="post_content">
			<?php if(get_post_time() > 1416839400): // &gt; 21.11.2014 ?>
				<?php the_content('',true); ?>
			<?php else:?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>
		
		<?php endwhile;  ?>
		<?php endif; ?>
	</div>
	<?php include('sn_tags.php'); ?>
	<?php include('sn_comments.php'); ?>
</div>

<aside class="block_right aligned-sidebar">
	<?php include('sn_recommend.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>