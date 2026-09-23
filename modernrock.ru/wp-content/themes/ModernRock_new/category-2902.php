<?php get_header(); ?>
<div class="block_left">
	<h1 class="h1">Поиск по сайту</h1>
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
            <?php
            $term = modernrock_search_term('q');
            $search_page = modernrock_search_page();
            $results = modernrock_cached_public_query([
                's' => $term, 'post_type' => ['post', 'page'], 'post_status' => 'publish',
                'posts_per_page' => 33, 'paged' => $search_page,
                'ignore_sticky_posts' => true, 'post__in' => $term === '' ? [0] : [],
            ], 'site:' . $term);
            $i = 0;
            while ($results->have_posts()) : $results->the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if (empty($large[0])) $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" width="275" height="160" alt="<?php the_title_attribute();?>" /></a></div>
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
			<?php wp_reset_postdata(); ?>
		</ul>
	</div>	
	<?php if ($i==0): ?>
		<p><?php echo $term === '' ? 'Введите запрос для поиска.' : 'Ничего не найдено. Попробуйте другой запрос.'; ?></p>
	<?php endif; ?>
<?php modernrock_search_pagination('/search/', $term, $search_page, $results->max_num_pages); ?>
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
</aside>
<?php get_footer(); ?>