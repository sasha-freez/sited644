<?php
wp_reset_query();
$arh=array(
	'showposts'=>'6',
	'cat'=>'3',
	'post__not_in'=>array(get_the_ID())
);
query_posts($arh);
$i=0;
?>
<?php if (have_posts()) : ?>
<div class="n-item bnews others_news">
	<div class="h3">Другие новости</div>
	<?php while (have_posts()) : the_post(); ?>
	<?php 
		$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
	?>
	
	<div class="row">
		<a href="<?php the_permalink(); ?>">
			<span class="img"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title_attribute(); ?>" /></span>
			<span class="desc">
				<span class="name"><?php the_title();?></span>
			</span>
		</a>
	</div>
	<?php $i++;endwhile; ?>
</div>
<?php endif; ?>