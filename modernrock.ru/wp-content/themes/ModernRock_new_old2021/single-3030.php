<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	
	
	<div class="bdetails d_leaks">
		 <?php wp_reset_query(); if (have_posts()) : ?>
		 <?php while (have_posts()) : the_post(); ?>
		 
		<?php 
			$tmp_title = get_post_meta(get_the_ID(), 'data_ngroup', true);
			if(!$tmp_title) {$tmp_title = get_post_meta(get_the_ID(), 'group_afisha', true);}
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
			'showposts'=>'1',
			'cat'=>'12',
			'name'=>$tmp_title
		);
		query_posts($arh);
		$i=0;
	?>
	<?php if (have_posts()) : ?>
	<div class="n-item bnews relative_news">
		<div class="h3">Исполнитель:</div>
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
	
	<?php
		wp_reset_query();
		
		$cr = get_the_category();$sep = ', ';$out = '';
		if($cr){
			foreach($cr as $cri) {
				$out.= $cri->term_id.$sep;
			}
			$category__in=trim($out, $sep);
		}else{
			$category__in=3030;
		}
		
		$arh=array(
			'showposts'=>'2',
			'post__not_in'=>array(get_the_ID()),
			'cat' => $category__in
		);
		query_posts($arh);
	?>
	<?php if (have_posts()) : ?>
	<div class="section_list leaks_list r_leaks">
		<div class="h3">МЫ РЕКОМЕНДУЕМ</div>
		<ul class="tiles3">
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		<?php 
			$gr = get_post_meta(get_the_ID(), 'data_ngroup', true);
			if(!$gr) $gr=get_post_meta(get_the_ID(), 'group_afisha', true);
		?>
		<li>
			<div class="row">
				<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=165&h=165',$large[0]);?>" width="165" height="165" alt="<?php the_title();?>" /></a></div>
				<div class="desc">
					<a href="<?php the_permalink();?>" class="link">
						<span class="album"><?php echo get_post_meta(get_the_ID(), 'album', true);?></span>
						<span class="group"><?php echo $gr;?></span>
						<span class="year"><?php echo get_post_meta(get_the_ID(), 'data_leaks', true);?></span>
					</a>
					<div class="type">
						<?php 
							/* выбрать все категории для поста */
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
								if($categories){
									foreach($categories as $category) {
										$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "%s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
									}
								echo trim($output, $separator);
							}
						?>
					</div>
				</div>
			</div>
		</li>
		<?php $i++;endwhile; ?>
		</ul>
	</div>
	<?php endif; ?>	
	
	
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
	<div class="n-item bnews relative_news leaks_news">
		<div class="h3">Похожие новости</div>
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
					
	<?php wp_reset_query(); if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
	
	<div class="others_txt txt_leaks">
		<p>
			Новый альбом <?php echo $tmp_title;?> "<?php echo get_post_meta(get_the_ID(), 'album', true);?>" (<?php echo get_post_meta(get_the_ID(), 'data_leaks', true);?>)
			взят из открытого источника и представлен исключительно для ознакомительных целей.</p>
		<p>Мы не несем ответственности за выложенный материал на сторонних ресурсах.</p>
		<p>Если вы являетесь правообладателям данного контента вам необходимо ознакомиться с соответствующим разделом.</p>
		<p>
			Здесь же вы сможете слушать онлайн альбом <?php echo $tmp_title;?> "<?php echo get_post_meta(get_the_ID(), 'album', true);?>" (<?php echo get_post_meta(get_the_ID(), 'data_leaks', true);?>) 
			и при желании приобрести его на iTunes. Все необходимые ссылки прикреплены к посту.
		</p>
	</div>
	
	<?php endwhile; ?>
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