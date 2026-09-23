<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<?php include('sn_breadcrumbs.php'); ?>

<div class="section_list gr_sounds">
	<ul class="tiles3">
		<?php wp_reset_query(); ?>
		<?php
			$arh=array(
				'showposts'=>16,
				'cat'=>'3029',
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
			);
			query_posts($arh);
			$i=-1;
			$j=0;
		?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$grad=get_post_meta(get_the_ID(), 'grad', true);
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			if ($j==0) :
			
		?>
		<li class="gr_first" style="
			<?php echo '
				background: -webkit-linear-gradient('.$grad.');
				background: -moz-linear-gradient('.$grad.');
				background: -ms-linear-gradient('.$grad.');
				background: -o-linear-gradient('.$grad.');
				background: linear-gradient('.$grad.');
			';?>
		">
			<div class="row">
				<a href="<?php the_permalink(); ?>">
					<span class="img"><b></b><img src="<?php echo kama_thumb_src('w=285&h=285',$large[0]);?>" width="285" height="285" alt="<?php the_title();?>" /></span>
					<span class="desc">
						<span class="album"><?php echo get_post_meta(get_the_ID(), 'album', true);?></span>
						<span class="name"><?php echo get_post_meta(get_the_ID(), 'group_afisha', true);?></span>
						<span class="genre"><?php echo get_post_meta(get_the_ID(), 'genre', true);?></span>
						<span class="date"><?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?></span>
					</span>
				</a>
			</div>
		</li>
		<li class="gr_first" style="margin-top:-15px;">
			<div style="font-size:11px; text-align:center;">Для премьер альбомов/синглов/клипов на <a href="http://modernrock.ru">modernrock.ru</a><br/>
			обращайтесь на <a href="mailto:pr@modernrock.ru">pr@modernrock.ru</a> (с пометкой "sounds").</div>
		</li>
		<?php else:?>
		<li>
			<div class="row">
				<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=200&h=200',$large[0]);?>" width="200" height="200" alt="<?php the_title();?>" /></a></div>
				<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php echo get_post_meta(get_the_ID(), 'group_afisha', true);?></a></div>
				<div class="album"><?php echo get_post_meta(get_the_ID(), 'album', true);?></div>
			</div>
		</li>
		<?php endif; ?>	

		<?php $i++;$j++; endwhile; ?>
		<?php endif; ?>							
	</ul>
</div>
<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>


<?php get_footer(); ?>