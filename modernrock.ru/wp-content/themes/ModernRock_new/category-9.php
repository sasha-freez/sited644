<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<?php include('sn_breadcrumbs.php'); ?>

<div class="section_list section_notices">
	<ul class="tiles3">
		<?php wp_reset_query(); ?>
		<?php
			$arh=array(
				'showposts'=>16,
				'cat'=>'9',
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
			);
			query_posts($arh);
			$i=-1;
			$j=0;
		?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		
		<li>
			<div class="row<?php if ($j==0){echo ' main';}?>" <?php if ($i>=2){echo 'style="margin-right:0px;"'; $i=-1;}?>>
				<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=200&h=200',$large[0]);?>" width="200" height="200" alt="<?php the_title();?>" /></a></div>
				<div class="date"><?php the_time('d.m.Y') ?></div>
				<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php echo get_post_meta(get_the_ID(), 'notices_group', true);?></a></div>
				<div class="intro album"><?php echo get_post_meta(get_the_ID(), 'album', true);?></div>
				<?php include('sn_stars.php'); ?>
			</div>
		</li>
		
		<?php $i++;$j++; endwhile; ?>
		<?php endif; ?>							
	</ul>
</div>
<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
<?php get_footer(); ?>