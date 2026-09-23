<?php get_header(); ?>
<div class="block_left">
	<div class="h1">Поиск по сайту</div>
	<div class="csearch">
		<form action="/search/" method="get">
			<input type="text" class="inp" name="q" value="<?php if (isset($_GET['q']) && $_GET['q']<>''){echo esc_attr(modernrock_search_term('q'));}?>" placeholder="Поиск по сайту" />
			<input type="image" src="/images/i_search.png" class="submit" name="submit"/>
		</form>
	</div>
	
	<?php if (isset($_GET['q']) && $_GET['q']<>''):?>
		<div class="h2">Результаты поиска по запросу: <?php echo esc_html(modernrock_search_term('q')); ?></div>
	<?php endif; ?>
	
	<div class="section_list section_groups">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				function filter_where_find($where = '') {
					global $wpdb;
                    $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like(modernrock_search_term('q')) . '%');
					return $where;
				}
				
				if (isset($_GET['q']) && $_GET['q']<>'') add_filter('posts_where', 'filter_where_find');
				
				$arh=array(
					'showposts'=>33,
					'cat'=>'3,6,2872,9',
				);
				query_posts($arh);
                    remove_filter('posts_where', 'filter_where_find');
                    remove_filter('posts_where', 'filter_where');
			?>
			<?php $i=0; if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" width="275" height="160" alt="<?php the_title();?>" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
					<!--
					<div class="type">
						<?php 
							$categories = get_the_tags();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_tag_link( $category->term_id ).'">'.$category->name.'</a>'.$separator;
								}
							echo trim($output, $separator);
							}
						?>
					</div>	
					-->
				</div>
			</li>
			<?php $i++; endwhile; ?>
			<?php endif; ?>
		</ul>
	</div>	
	<?php if ($i==0): ?>
		<p>К сожалению ничего не найдено, попробуйте заново</p>
	<?php endif; ?>
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
</aside>
<?php get_footer(); ?>