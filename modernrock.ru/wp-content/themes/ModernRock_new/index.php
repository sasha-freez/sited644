<?php get_header();  // редактирование главной страницы ?>
<!-- 195118a6593aeec1 -->
<div class="block_left">
	<div class="section_list">
		<?php wp_reset_query(); ?>
		<?php 
			$tmp_buy='';
			$arh=array(
				'showposts'=>21,
				'cat'=>'3,5,6,16,8,10,23,16,17,141',
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
			);
			query_posts($arh);
			$i=1;$k=1;
		?>
		<ul class="tiles">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				$small=get_post_meta(get_the_ID(), 'ratings_average', true); echo $tmp_buy;
			?>
			<?php if($small==1) :  $i++; $k++;?> 
			<li class="small">
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" alt="<?php the_title();?>" width="47" height="47" /></a></div>
					<div class="desc">
						<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
					</div>
					<?php if($i==6) : ?>
						<div class="link" style="margin:5px 0 0 0; position:absolute; font-size:10px;"><a href="https://bookbee.ru/" style="color:#fff;" target="_blank">Читать книги на сайте bookbee.ru онлайн бесплатно</a></div>
					<?php endif; ?>
				</div>
			</li>
			<?php else:?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" alt="<?php the_title();?>" width="275" height="160" /></a></div>
					<div class="rubric"><?php the_category(' ');?></div>
					<div class="name"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></div>
					<div class="intro"><?php the_content_limit(180, ""); ?></div>
					<?php if($k==6) : ?>
						<div class="link" style="margin:5px 0 0 0; position:absolute; font-size:10px;"><a href="https://bookbee.ru/" style="color:#fff;" target="_blank">Лучшие книги на сайте bookbee.ru</a></div>
					<?php endif; ?>
				</div>
			</li>
			<?php endif; ?>

			<?php endwhile; ?>
			<?php endif; ?>
		</ul>
	</div>
	<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>

<aside class="block_right">
	
	<!-- Концерты сегодня -->
	<div class="n-item concert_last">
		<div class="h3">КОНЦЕРТЫ СЕГОДНЯ</div>					
		<?php // Даты 2020-04-19 and 2020-04-20					
			$start_date = date("Y-m-d", time()-0*86400);
			$end_date = date("Y-m-d", time()+1*86400);
		?>
		<div class="item">
		<?php 
			// Подключим базу
			global $wpdb;
			// Выберу все билеты связанные с артистом
			$rowID = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key` = 'data_afisha' AND (`meta_value` >= '".$start_date."' AND `meta_value` < '".$end_date."') ORDER BY `meta_value` DESC LIMIT 50");

			$groupID = [];
			foreach($rowID as $resID) {
				$groupID[] = $resID->post_id;
			}

			wp_reset_query();
			$arh_tmp=array(
				'cat'=>2872,
				'post__in' => $groupID
			);

			query_posts($arh_tmp);
			
			if (have_posts()) :
			while (have_posts()) : the_post();
			$tmp_buy=get_post_meta(get_the_ID(), 'buyticket', true);
		?>
			<div class="item">
				<?php if ($tmp_buy<>''):?>
					<a href="<?php echo $tmp_buy;?>" class="buy" rel="nofollow" target="_blank">Купить билет</a>
				<?php endif;?>
				<p class="name"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></p>
				<p>
					<span class="time"><?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></span>
					<span class="club"><?php echo get_post_meta(get_the_ID(), 'club', true);?></span>
				</p>
			</div>
		<?php
			endwhile; endif;							
		?>
		</div>					
	</div>
	
	<!-- Конкурсы -->
	<?php
		wp_reset_query();
		$arh=array(
			'showposts'=>10,
			'cat'=>'8',
			'meta_key'=>'active_contest',
			'meta_value'=>'true'
		);
		query_posts($arh);
	?>
	<?php if (have_posts()) : ?>
	<div class="n-item concurs_last">
		<div class="h3">КОНКУРСЫ</div>
		<?php while (have_posts()) : the_post(); ?>
		<div class="item"><a href="<?php the_permalink(); ?>" class="type<?php echo get_post_meta(get_the_ID(), 'type_contest', true);?>"><?php the_title();?></a></div>
		<?php endwhile; ?>
	</div>
	<?php endif; ?>
	
	<!-- #Leaks -->
	<div class="n-item leaks_mini">
		<div class="h3"><a href="/leaks">Послушать</a></div>
		<?php rewind_posts(); ?>
		<?php query_posts('showposts=4&cat=3030'); ?>
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php 
					$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				?>
				<?php 
					$gr ='';
					$ngroup = get_post_meta(get_the_ID(), 'data_ngroup', true);
					$group = get_post_meta(get_the_ID(), 'group_afisha', true);
					if($ngroup){ $gr = $ngroup;}else{$gr = $group;}
				?>
				<div class="item">
					<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title();?>"/></a></div>
					<div class="desc">
						<a href="<?php the_permalink(); ?>">
							<span class="group"><?php echo $gr;?></span>
							<span class="album"><?php echo get_post_meta(get_the_ID(), 'album', true);?></span>
						</a>
					</div> 
				</div>
			<?php endwhile; ?>
		<?php endif; ?>	
	</div>
	
	<?php include('sn_banners_r.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	
	<!-- Рецензии -->
	<div class="n-item reviews_mini">
		<div class="h3"><a href="/notices">РЕЦЕНЗИИ</a></div>
		<?php rewind_posts(); ?>
		<?php query_posts('showposts=2&cat=9'); ?>
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php 
					$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				?>
				<div class="item">
					<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title();?>"/></a></div>
					<div class="desc">
						<p class="name"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'notices_group', true);?></a></p>
						<p class="intro"><?php echo get_post_meta(get_the_ID(), 'album', true);?></p>
						<?php include('sn_stars.php'); ?>
					</div> 
				</div>
			<?php endwhile; ?>
		<?php endif; ?>	
	</div>
</aside>
<?php get_footer(); ?>