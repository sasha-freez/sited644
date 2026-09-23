<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	<?php modernrock_archive_heading(); ?>
	
	<?php
		wp_reset_query();
		$arh=array(
			'showposts'=>$posts_per_page,
			'cat'=>'8',
			'meta_key'=>'active_contest',
			'meta_value'=>'true',
			'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
		);
		query_posts($arh);
	?>
	<?php if (have_posts()) : ?>
	<div class="section_list section_contest_act">
		<ul>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
					<div class="intro"><?php the_content_limit(180, ""); ?></div>
				</div>
			</li>
			<?php $i++; endwhile; ?>
		</ul>
	</div>
	<?php endif; ?>
		

	<div class="h2">Прошедшие конкурсы</div>
	<div class="section_list section_contest">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				$arh=array(
					'showposts'=>9,
					'cat'=>'8',
					'meta_key'=>'active_contest',
					'meta_value'=>'false',
					'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
				);
				query_posts($arh);
				$i=0;
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
					<div class="intro"><?php the_content_limit(180, ""); ?></div>
				</div>
			</li>
			<?php $i++; endwhile; ?>
			<?php endif; ?>
		</ul>
	</div>
	<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>

<aside class="block_right aligned-sidebar">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_recommend.php'); ?>
</aside>
<?php get_footer(); ?>