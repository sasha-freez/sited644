<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	<div class="bdetails d_news">
		 <?php wp_reset_query(); if (have_posts()) : ?>
		 <?php while (have_posts()) : the_post(); ?>
		 <?php
			$tmp_title=get_post_meta(get_the_ID(), 'news_group', true);
		 ?>
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
	
	<?php
		wp_reset_query();
		$arh=array(
			'showposts'=>'4',
			'cat'=>'3',
			'post__not_in'=>array(get_the_ID()),
			'meta_key'=>'news_group',
			'meta_value'=>$tmp_title
		);
		query_posts($arh);
		$i=0;
	?>
	<?php if (have_posts()) : ?>
	<div class="n-item bnews relative_news">
		<div class="h3">Похожие новости</div>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		
		<div class="row">
			<a href="<?php the_permalink(); ?>">
				<span class="img"><img src="<?php echo $large[0]; ?>" alt="<?php the_title_attribute(); ?>" /></span>
				<span class="desc">
					<span class="name"><?php the_title();?></span>
				</span>
			</a>
		</div>
		
		<?php $i++;endwhile; ?>
	</div>
	<?php endif; ?>	
	
	
	<?php include('sn_comments.php'); ?>
</div>
<aside class="block_right">
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>