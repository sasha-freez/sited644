<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	<h1 class="h1">Группы - Тексты песен</h1>

	<?php wp_reset_query(); ?>
			<?php
				$arh=array(
					'post_name'=>'gven-stefani'

				);
				query_posts($arh);
				$i=-1;
				$j=0;
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>


			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php echo $post_name;?></a></div>
					<div class="intro"><?php the_content_limit($limit, ""); ?></div>
				</div>
			</li>

			<?php $i++;$j++; endwhile; ?>
			<?php endif; ?>	
	
	
	
	
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