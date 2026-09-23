<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="section_list section_club">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				$arh=array(
					'showposts'=>15,
					'cat'=>$cat,
					'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1,
					'order'=>'ASC',
					'orderby'=>'title'
				);
				query_posts($arh);
				$i=1;
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row<?php if ($j==0){echo ' main';}?>" <?php if ($i>=1){echo 'style=""'; $i=-1;}?>>
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
				</div>
			</li>
			<?php $i++; endwhile; ?>
			<?php endif; ?>							
		</ul>
	</div>
	<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_recommend.php'); ?>
</aside>
<?php get_footer(); ?>