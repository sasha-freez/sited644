<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails d_contest">
		 <?php wp_reset_query(); if (have_posts()) : ?>
		 <?php while (have_posts()) : the_post(); ?>
		<div class="date"><?php the_time('d.m.Y') ?></div>
		<h1><?php the_title();?></h1>
		<?php include('sn_stars.php'); ?>
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
	
	<div class="n-item reviews_mini relative_news">
		<div class="h3">Смотрите также</div>
		<?php
			wp_reset_query();
			$arh=array(
				'showposts'=>'4',
				'cat'=>'9',
				'post__not_in'=>array(get_the_ID())
			);
			query_posts($arh);
			$i=-1;
		?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		<div class="row">
			<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo $large[0]; ?>" alt="<?php the_title();?>"/></a></div>
			<div class="desc">
				<p class="name"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'notices_group', true);?></a></p>
				<p class="intro"><?php echo get_post_meta(get_the_ID(), 'album', true);?></p>
				<?php include('sn_stars.php'); ?>
			</div> 
		</div>
		
		<?php $i++;endwhile; ?>
		<?php endif; ?>	
	</div>
	<?php include('sn_comments.php'); ?>
</div>

<aside class="block_right">
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_recommend.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>