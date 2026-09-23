<?php get_header(); ?>
<?php $date = new DateTime(); // текущая дата ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails d_interview">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php
			$city=get_post_meta(get_the_ID(), 'city', true);
			$address=get_post_meta(get_the_ID(), 'address', true);
			$phone=get_post_meta(get_the_ID(), 'phone', true);
			$sql_title=get_the_title(get_the_ID());
			
			//$text = !empty($city) ? '<p class="city"><strong>Город:</strong>  '.$city.'</p>' : '';
			//$text .= !empty($address) ? '<p class="address"><strong>Адрес:</strong>  '.$address.'</p>' : '';
			//$text .= !empty($phone) ? '<p class="phone"><strong>Телефон:</strong>  '.$phone.'</p>' : '';
		?>
		
		<h1><?php the_title();?> - все концерты и билеты</h1>
		<?php include('sn_social.php'); ?>
		<div class="club_param">
			<?php echo $text ?>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
		
		<h2 class="h2bl"><span class="bl">Ближайшие</span> <span class="wh">концерты:</span></h2>
		<div class="ticket_list ticket_list_cont">	
			<?php 
				
				$arh_tmp=array(
					'showposts' => 50,
					'cat' => 2872,
					'numberposts' => 0,
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
							'key' => 'club',
							'value' => $sql_title
						)
					),
					'post_type'   => 'post',
					'suppress_filters' => true
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
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo $large[0]; ?>" alt="<?php the_title();?>" /></a></div>
					<div class="desc">
						<div class="name"><a href="<?php the_permalink(); ?>"><?php include('sn_tickets_title.php'); ?></a></div>
						<div class="date">
							<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>, <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div>В ближайшее время событий не запланировано.</div>
			<?php endif; ?>
		</div>
		
		
		
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post_content">
			<br/>
			<?php if(get_post_time() > 1416839400): // &gt; 21.11.2014 ?>
				<?php the_content('',true); ?>
			<?php else:?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile;  ?>
		<?php endif; ?>
		
		<div class="others_txt">
			На modernrock.ru представлена наиболее полная афиша и расписание концертов в <?php the_title();?>, а также билеты от крупнейших билетных операторов. Для удобства мы находим все самые выгодные цены, чтобы вы смогли сравнить и выбрать лучшее предложение. Для экономии времени, чтобы не ехать в кассу, рекомендуем купить электронный билет. Это действительно очень быстро и удобно.
		</div>
	</div>
	<?php include('sn_tags.php'); ?>
	<?php include('sn_comments.php'); ?>
</div>

<aside class="block_right">
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>