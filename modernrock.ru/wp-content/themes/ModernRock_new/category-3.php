<?php get_header(); ?>
<div class="block_left">
    <h1 class="h1">Новости музыки</h1>

	<div class="section_list section_news">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				// The main query already contains the 15 paginated news posts.
				$i=-1;
				$j=0;
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				if ($j==0){
					$limit=180;
				}
				else{
					$limit=180;
				}

			?>

			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" alt="<?php the_title();?>" width="275" height="160" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
					<div class="intro"><?php the_content_limit($limit, ""); ?></div>
				</div>
			</li>

			<?php $i++;$j++; endwhile; ?>
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