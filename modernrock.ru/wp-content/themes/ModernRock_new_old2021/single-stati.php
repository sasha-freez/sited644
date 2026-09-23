<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails d_cms">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="date"><?php the_time('d.m.Y') ?></div>
		<div class="h1"><?php the_title();?></div>
		<?php include('sn_social.php'); ?>
		<div class="post_content"><?php the_content();?></div>
		
		<?php endwhile;  ?>
		<?php endif; ?>
	</div>
	<?php include('sn_tags.php'); ?>
	<?php include('sn_comments.php'); ?>
</div>


<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>
<?php get_footer(); ?>