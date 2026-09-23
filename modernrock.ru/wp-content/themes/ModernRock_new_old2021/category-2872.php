<?php get_header(); ?>
<?php 
	$date = new DateTime(); // текущая дата 
	// Подключим базу
	global $wpdb;
	// Текущая дата для сортировки
	$start_date = date("Y-m-d", time()-0*86400);
	// Текущая страница
	$currentPageURL = explode('/page/',$_SERVER["REQUEST_URI"]);
	$currentPage = isset($currentPageURL[1]) ? $currentPageURL[1] : 1;

	// Количество записей на странице
	$pageOnePage = 16;
	// Выбрать категорию
	$this_category = get_category($cat);
	$category_parent = get_category_children($this_category->cat_ID);
	
	
?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />

<div class="tickets">
	<div class="tk-land">
		<div class="tk-calendar">
			<?php 
				if($_SESSION['geocity']=='Санкт-Петербург'){
					echo '<a href="http://modernrock.ru/afisha-koncertov">Календарь событий</a>'; 
				}else{
					echo '<a href="http://modernrock.ru/afisha-koncertov">Календарь событий</a>'; 
				}
			?>
		</div>
		<form method="post">
		  <select name="set_city" id="set_city" onChange="this.form.submit();">
			<option value="Москва">Москва</option>
			<option value="Санкт-Петербург" <?php if($_SESSION['geocity']=='Санкт-Петербург') echo 'selected="selected"'; ?>>Санкт-Петербург</option>
		  </select>
		</form>
	</div>
	
	<?php if ($category_parent != ""):?>
	
	<div class="tk-top">
		<div class="tk-recommended">
			<div class="h3">МЫ РЕКОМЕНДУЕМ</div>
			<?php
				// Выберу с помощью подзапроса данные о концертах, которые имеют слайдер))
				$rowID = $wpdb->get_results("
					SELECT * FROM wp_postmeta v WHERE v.meta_key = 'data_afisha'
					AND v.post_id IN (SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'post_slider-img_thumbnail_id' AND t.post_id = v.post_id)
					AND v.post_id IN (SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'city' AND t.meta_value = '".GeoCity()."')
					AND (`meta_value` >= '".$start_date."')
					ORDER BY v.meta_value DESC LIMIT 10;
				");

				$groupSliderID = [0];
				foreach($rowID as $resID) {
					$groupSliderID[] = $resID->post_id;
				}
			
				wp_reset_query();	
				$arh=array(
					'showposts'=>20,
					'cat'=>$cat,
					'post__in' => $groupSliderID
				);
				query_posts($arh);
			?>
			<?php if (have_posts()) : ?>
			<?php $i=1; while (have_posts()) : the_post(); ?>
			<?php 
				/* Если заполнен слайдер, то выбираем все рекомендуемые концерты */
				if (class_exists('MultiPostThumbnails')) :
				$custom = MultiPostThumbnails::get_post_thumbnail_id('post', 'slider-img', get_the_ID()); 
				$custom = wp_get_attachment_image_src($custom,'post-slider-img-thumbnail');
				
				if($custom[0]){
					$slimg.='<img src="'.kama_thumb_src('w=560&h=200',$custom[0]).'" width="560" height="200" alt="" title="#s'.$i.'" />';
				}
			?>
			<div id="s<?php echo $i; ?>" class="sl_txt">
				<span class="line">
					<span class="group"><a href="<?php the_permalink(); ?>"><?php include('sn_tickets_title.php'); ?></a></span>
					<span class="club"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'club', true); ?></a></span>
					<span class="date">
						<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>.<?php echo date('m',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>.<?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>
					</span>
					<span class="time"><?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></span>
				</span>
				<span class="buy"><a href="<?php echo get_post_meta(get_the_ID(), 'buyticket', true); ?>" rel="nofollow" target="_blank">Купить билет</a></span>
			</div>
			<?php endif; ?>
			<?php $i++; endwhile; ?>
			<?php endif; ?>
			
			<div id="slider">
				<?php echo $slimg; ?>
			</div>
		</div>
		<div class="last-tickets">
			<div class="h3">ПОСЛЕДНИЕ ДОБАВЛЕННЫЕ СОБЫТИЯ</div>

			<?php
				// Выберу с помощью подзапроса данные о последних добавленных концертах))
				$rowID = $wpdb->get_results("
					SELECT * FROM wp_postmeta v WHERE v.meta_key = 'data_afisha' AND v.post_id IN
					(SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'city' AND t.meta_value = '".GeoCity()."')
					ORDER BY v.meta_value DESC LIMIT 4;
				");

				$groupLastID = [0];
				foreach($rowID as $resID) {
					$groupLastID[] = $resID->post_id;
				}

				wp_reset_query();
				$arh=array(
					'showposts'=>4,
					'cat'=>$cat,
					'post__in' => $groupLastID
				);
				query_posts($arh);
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			
			<div class="row">
				<div class="group"><a href="<?php the_permalink(); ?>"><?php include('sn_tickets_title.php'); ?></a></div>
				<div class="club"><a href="<?php the_permalink(); ?>"><?php echo get_post_meta(get_the_ID(), 'club', true); ?></a></div>
				<div class="date">
					<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>.<?php echo date('m',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>.<?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>
				</div>
				<div class="time"><?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></div>   
			</div>
			
			<?php endwhile; ?>
			<?php endif; ?>	
		</div>
	</div>
	<?php else:?>
		<?php include('sn_breadcrumbs.php'); ?>
	<?php endif;?>
	<div class="cat_type">
		<div class="h3">ЖАНРЫ</div>
		<?php if ($category_parent != ""):?>
		<ul>
			<li class="cat-item-1 current-cat"><a href="/tickets">Все</a></li>
			<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of='.$this_category->cat_ID); ?>
		</ul>
		<?php else:?>
		<ul>
			<li class="cat-item-1"><a href="/tickets">Все</a></li>
			<?php wp_list_categories('orderby=id&show_count=0&depth=1&hide_empty=0&title_li=&use_desc_for_title=1&child_of=2872'); ?>
		</ul>
		<?php endif;?>
	</div>
	
	
	<div class="ticket_list">	
		<?php if ($category_parent != ""):?>
		<div class="h3">УЖЕ СКОРО</div>
		<?php else:?>
		<div class="h3"><?php echo single_cat_title('', false); ?></div>
		<?php endif;?>
		
		<?php 
			if($category_parent != ""){
				$cat_par ='';
			}else{
				$rowCountID = $wpdb->get_col("
					SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '".$cat."' ORDER BY `term_id` DESC LIMIT 1
				");
				$cat_par = "AND v.post_id IN (SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id = '".$rowCountID[0]."')";
			}

			// Количество в выборке
			$rowCountID = $wpdb->get_col("
				SELECT count(*) FROM wp_postmeta v WHERE v.meta_key = 'data_afisha' AND v.post_id 
				IN (SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'city' AND t.meta_value = '".GeoCity()."')
				".$cat_par."
				AND (`meta_value` >= '".$start_date."') ORDER BY v.meta_value
			");
			// Пагинация для выборки
			$offsetID = $currentPage == 1 ? 0 : ($currentPage-1)*$pageOnePage;
			
			// Мутим вывод более простым запросом
			$rowID = $wpdb->get_results("
				SELECT * FROM wp_postmeta v WHERE v.meta_key = 'data_afisha' AND v.post_id 
				IN (SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'city' AND t.meta_value = '".GeoCity()."')
				".$cat_par."
				AND (`meta_value` >= '".$start_date."') ORDER BY v.meta_value
				ASC LIMIT ".$offsetID.",".$pageOnePage."
			");

			$groupID = [0];
			foreach($rowID as $resID) {
				$groupID[] = $resID->post_id;
			}

			wp_reset_query();
			$arh_tmp=array(
				'showposts' => $pageOnePage,
				'cat' => $cat,
				'post__in' => $groupID,
				'orderby'     => 'meta_value',
				'meta_key'    => 'data_afisha',
				'order'       => 'ASC'
				/*
				'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1,
				'orderby'     => 'meta_value',
				'order'       => 'ASC',
				'meta_key'    => 'data_afisha',
				'meta_query' => array(
					array(
						'key' => 'data_afisha',
						'value' => date("Y-m-d"), // сегодняшняя дата
						'compare' => '>=',
						'type' => 'DATE',
					),
					array(
						'key' => 'city',
						'value' => GeoCity()
					)
				)
				*/
				
			);
			query_posts($arh_tmp);
			
			if (have_posts()) :
			while (have_posts()) : the_post();
		?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
			<div class="item">
				<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=165&h=96',$large[0]);?>" width="165" height="96" alt="<?php the_title();?>" /></a></div>
				<div class="desc">
					<div class="name"><a href="<?php the_permalink(); ?>"><?php include('sn_tickets_title.php'); ?></a></div>
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
					<div class="club"><?php echo get_post_meta(get_the_ID(), 'club', true); ?>, <?php echo get_post_meta(get_the_ID(), 'city', true); ?></div>
					<div class="date">
						<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>, <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>

	<?php
	
	
		/*
		echo "SELECT * FROM wp_postmeta v WHERE v.meta_key = 'data_afisha' AND v.post_id 
				IN (SELECT post_id t FROM wp_postmeta t WHERE t.meta_key = 'city' AND t.meta_value = '".GeoCity()."')
				".$cat_par."
				AND (`meta_value` >= '".$start_date."') ORDER BY v.meta_value
				ASC LIMIT ".$offsetID.",".$pageOnePage."";
		echo '<br/>';
		print_r($rowCountID[0]);
		echo '<br/>';
		<div class="pagination"></div> wp_pagenavi();
		//print_r($GLOBALS['wp_query']);
		echo $cat;
		echo '<br/>';
		echo $currentPage.'-'.$pageOnePage.'-'.$rowCountID[0], $url = $currentPageURL[0], $url_page = $currentPageURL[0].'/page/';
		*/
		// крутая пагинация
		b_pager($currentPage,$pageOnePage,$rowCountID[0], $url = $currentPageURL[0], $url_page = $currentPageURL[0].'/page/');
	?>
	
</div>
<?php get_footer(); ?>