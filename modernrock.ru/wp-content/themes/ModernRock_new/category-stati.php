<?php get_header(); ?>
<div class="block_left">
    <?php modernrock_archive_heading(); ?>
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="events-list">
		<?php wp_reset_query(); ?>
		<?php
			$arh=array(
				'showposts'=>15,
				'cat'=>'176',
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
			);
			query_posts($arh);
		?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="item-news" style="width:100%;height:auto;">
			<div class="title">
				<?php the_time('d.m.Y'); ?> - <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
			</div>
		</div>
		<?php endwhile; ?>

		<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
		<?php endif; ?>							
	</div>
</div>
<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>
<?php get_footer(); ?>