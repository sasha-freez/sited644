<?php get_header(); ?>
<div class="block_left">
    <?php modernrock_archive_heading(); ?>
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="section_list section_adv">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				$arh=array(
					'showposts'=>15,
					'cat'=>'1323',
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
				if ($j==0){
					$limit=366;
				}
				else{
					$limit=350;
				}
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=275&h=160',$large[0]);?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
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

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>
<?php get_footer(); ?>