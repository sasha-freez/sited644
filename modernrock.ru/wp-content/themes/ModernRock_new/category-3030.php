<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<?php include('sn_breadcrumbs.php'); ?>
<?php $this_category = get_category($cat); ?>
<div class="leaks">
<?php if (get_category_children($this_category->cat_ID) != ""):?>
<h1><?php echo 'Новинки музыки '.date('Y').''; ?></h1>
<?php else:?>
<h1><?php echo $this_category->cat_name; ?> – новинки</h1>
<?php endif;?>

<?php if (get_category_children($this_category->cat_ID) != ""):?>
<?php wp_reset_query(); ?>

<?php
	$arh=array(
		'showposts'=>3,
		'cat'=>$cat,
		'meta_key'=>'act_album',
		'meta_value'=>'1',
	);
	query_posts($arh);
?>
<?php if (have_posts()) : ?>
<div class="leaks_top">
<ul>
	<?php while (have_posts()) : the_post(); 
		$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
	?>
	
	<?php 
		$gr ='';
		$ngroup = get_post_meta(get_the_ID(), 'data_ngroup', true);
		$group = get_post_meta(get_the_ID(), 'group_afisha', true);
		if($ngroup){ $gr = $ngroup;}else{$gr = $group;}
	?>
	<li>
		<div class="row">
			<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=245&h=245',$large[0]);?>" width="245" height="245" alt="<?php the_title();?>" /></a></div>
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
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
							}
						echo trim($output, $separator);
					}
				?>
			</div>
		</div>
	</li>
	<?php endwhile; ?>
</ul>
</div>
<div class="leaks_bgr"></div>
<?php endif; ?>		
<?php endif;?>

<div class="cat_type">
	<div class="h3">ЖАНРЫ</div>
	<?php if (get_category_children($this_category->cat_ID) != ""):?>
	<ul>
		<li class="cat-item-1 current-cat"><a>Все</a></li>
		<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID); ?>
	</ul>
	<?php else:?>
	<ul>
		<li class="cat-item-1"><a href="/leaks">Все</a></li>
		<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of=3030'); ?>
	</ul>
	<?php endif;?>
</div>

<div class="section_list leaks_list">
	<ul class="tiles3">
		<?php wp_reset_query(); ?>
		<?php
			$arh=array(
				'showposts'=>16,
				'cat'=>$cat,
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
			);
			query_posts($arh);
			$i=-1;
			$j=0;
		?>
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		<?php 
			$gr ='';
			$ngroup = get_post_meta(get_the_ID(), 'data_ngroup', true);
			$group = get_post_meta(get_the_ID(), 'group_afisha', true);
			if($ngroup){ $gr = $ngroup;}else{$gr = $group;}
		?>
		<li>
			<div class="row">
				<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=200&h=200',$large[0]);?>" width="200" height="200" alt="<?php the_title();?>" /></a></div>
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
		<?php endwhile; ?>
		<?php endif; ?>							
	</ul>
</div>
<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>
<?php get_footer(); ?>