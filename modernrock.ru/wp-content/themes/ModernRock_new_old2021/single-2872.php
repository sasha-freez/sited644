<?php get_header(); ?>
<?php $date = new DateTime(); // текущая дата ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	<div class="bdetails d_tickets">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="one_ticket">
			<div class="img">
				<?php
					if (class_exists('MultiPostThumbnails')) :
						$custom = MultiPostThumbnails::get_post_thumbnail_id('post', 'afisha-img', $post->ID); 
						$custom = wp_get_attachment_image_src($custom,'post-afisha-img-thumbnail');
					endif;
				?>
				<a href="<?php echo $custom[0]; ?>" data-lightbox="afisha">
					<img src="<?php echo kama_thumb_src('w=250',$custom[0]);?>" width="250" alt="<?php include('sn_tickets_title.php'); ?>"/>
				</a>
			</div>
			<div class="desc">
				<?php 
				$title = get_the_title();
				$gr = get_post_meta(get_the_ID(), 'group_afisha', true);
				if(!$gr) $gr='dddddd';

				$args = array(
					'showposts'=> 100,
					'cat'=>12,
					's' => $gr
				);
				$q = new WP_Query($args); //создаем новый объект
				if($q->have_posts()) { //проверяем, существуют ли посты по заданным параметрам(необязательно)
					while($q->have_posts()){ $q->the_post();
						if($gr == get_the_title()){
							echo '<div class="h1"><a href="' .get_permalink(). '">' . get_the_title() . '</a></div>';
						}
					}
				}else{
					wp_reset_postdata();
					echo '<h1>'.get_the_title().'</h1>';
				}
				wp_reset_postdata();
				?>
				
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
						$cs=get_post_meta(get_the_ID(), 'city', true);
					?>
				</div>
				<div class="club">
					<?php 
					$cl = get_post_meta(get_the_ID(), 'club', true);
					$cit = get_post_meta(get_the_ID(), 'city', true);
					$args = array(
						'showposts'=> 1,
						'cat'=>13,
						's' => $cl
					);
					$q = new WP_Query($args); //создаем новый объект
					if($q->have_posts()) { //проверяем, существуют ли посты по заданным параметрам(необязательно)
						while($q->have_posts()){ $q->the_post();
							echo '<a href="' .get_permalink(). '">' . get_the_title() . ', '.get_post_meta(get_the_ID(), "city", true).'</a>';
						}
					}else{
						echo ''.$cl.', '.$cit.'';
					}
					wp_reset_postdata();
					?>
				</div>
				<div class="date">
					<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> г, <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?>
				</div>
				<div class="price"><?php echo get_post_meta(get_the_ID(), 'ticket_ot', true); ?></div>
				<?php 
					$buyticket=get_post_meta(get_the_ID(), 'buyticket', true); // Ссылка или пономиналу
					$buyticket_1=get_post_meta(get_the_ID(), 'buyticket_1', true);  // Кассир СПБ
					$buyticket_1_radio=get_post_meta(get_the_ID(), 'buyticket_1_radio', true); // событие или мероприятие
					$buyticket_2=get_post_meta(get_the_ID(), 'buyticket_2', true);  // Кассир МСК
					$buyticket_3=get_post_meta(get_the_ID(), 'buyticket_3', true);  // ConcertRU
					$buyticket_4=get_post_meta(get_the_ID(), 'buyticket_4', true);  // RedKassa
					$buyticket_5=get_post_meta(get_the_ID(), 'buyticket_5', true);  // test
				?>
				
				<?php if ($buyticket_1):?>
					<script src="https://spb.kassir.ru/start-frame.js"></script>
					<div class="buy">
						<?php $spbType = $buyticket_1_radio == 'event'? 'E': 'A'; ?>
						<a href="https://spb.kassir.ru/frame/entry/index/<?php echo $buyticket_1; ?>?type=<?php echo $spbType; ?>&key=cbd41884-b8b7-bab9-86f6-74b60e584ce2" onclick="return kassirWidget.summon();" rel="nofollow"  target="_blank">Купить билет</a>
					</div>
				<?php endif;?>
				
				<?php if ($buyticket_2):?>
					<script src="https://msk.kassir.ru/start-frame.js"></script>
					<div class="buy <? if ($buyticket || $buyticket_4) echo 'kassir'; ?>">
						<a href="https://msk.kassir.ru/frame/event/<?php echo $buyticket_2; ?>?key=47fff075-4762-d3b1-95e6-95c7fe20d2b8" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a> 
						<?php if ($buyticket || $buyticket_4): // если концерт и редкасса ?>
							<span class="service_type">на KASSIR.RU</span>
						<?php endif;?>
					</div>
				<?php endif;?>
				
				<?php if ($buyticket_3):?>
					<div class="buy">
						<button onclick="window.open('http://concert.ru/widget/index.htm?actionId=<?php echo $buyticket_3; ?>&companyid=3576', '_blank');">Купить билет</button>
						<?php if ($buyticket || $buyticket_2 || $buyticket_4): // если концерт и редкасса ?>
							<span class="service_type">на CONCERTRU</span>
						<?php endif;?>
						
					</div>
				<?php endif;?>
				
				<?php if ($buyticket):?>
					<div class="buy">
						<button onclick="window.open('<?php echo $buyticket; ?>', '_blank');">Купить билет</button> 
						<?php if ($buyticket_2 || $buyticket_4): // если кассир и редкасса ?>
							<span class="service_type">на PONOMINALU.RU</span>
						<?php endif;?>
					</div>
				<?php endif;?>
				
				<?php if ($buyticket_4):?>
					<div class="buy redkassa">
						<button onclick="window.open('<?php echo $buyticket_4; ?>?utm_source=modernrock.ru&utm_medium=partner&utm_campaign=sale', '_blank');">Купить билет</button>
						<?php if ($buyticket || $buyticket_2):?>
							<span class="service_type">на RedKassa.ru</span>
						<?php endif;?>
					</div>
				<?php endif;?>
				<?php // промокод
					$ticket_promo=get_post_meta(get_the_ID(), 'ticket_promo', true);
					$ticket_pr_sale=get_post_meta(get_the_ID(), 'ticket_pr_sale', true);
					
					if($ticket_promo){
						echo '
							<div class="ticket_promo_sale">Cкидка '.$ticket_pr_sale.' по промокоду <strong>'.$ticket_promo.'</strong></div>
						';
					}
				?>
			</div>
		</div>
		<div class="post_content">
			<?php if(get_post_time() > 1416839400): // &gt; 21.11.2014 ?>
				<?php the_content('',true); ?>
			<?php else:?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>
		
		<?php endwhile; ?>
		<?php endif; ?>
	</div>

	<?php
	$args2 = array(
		'showposts'=> 100,
		'cat'=>12,
		's' => $gr
	);
	$q2 = new WP_Query($args2); //создаем новый объект
	if($q2->have_posts()) { //проверяем, существуют ли посты по заданным параметрам(необязательно)
		while($q2->have_posts()){ $q2->the_post();
			if($gr == get_the_title()){
				echo '<div class="h6 r_hh"><a href="' .get_permalink(). '">Все концерты ' . get_the_title() . '</a></div>';
			}
		}
	}
	wp_reset_postdata();
	?>
	
	
	<?php if (have_posts()) : ?>
	<div class="ticket_list r_ticket">
		<div class="h3">МЫ РЕКОМЕНДУЕМ</div>
		<?php while (have_posts()) : the_post(); ?>
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
								$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
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
	</div>
	<?php endif; ?>	
	
	<?php 
		if($cs=='Москва'){
			$city_seo='Москве';
		}else if($cs=='Санкт-Петербург'){
			$city_seo='Санкт-Петербурге';
		}else if($cs=='Екатеринбург'){
			$city_seo='Екатеринбурге';
		}else{
			$city_seo=$cs;
		}
	?>
	<?php wp_reset_query(); if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<div class="others_txt">
			<p>Ближайший концерт <?php include('sn_tickets_title.php'); ?> в <?php echo $city_seo; ?> пройдет 
			<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> г.
			на сцене <?php echo get_post_meta(get_the_ID(), 'club', true); ?>. Так как мы сотрудничаем исключительно с проверенными билетными агентствами, на modernrock.ru вы всегда можете купить билеты на концерт <?php include('sn_tickets_title.php'); ?> в <?php echo $city_seo; ?> без наценки, то есть по самым выгодным ценам. А при желании ознакомиться с официальными пресс-релизом и музыкой 
			<?php include('sn_tickets_title.php'); ?>.</p>
		</div>
	<?php endwhile; ?>
	<?php endif; ?>
</div>
<aside class="block_right">
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<div class="block_popup" id="block_popup"><span class="close"></span>
	<div class="wrapper_popup" id="wrapper_popup"></div>
</div>
<?php get_footer(); ?>