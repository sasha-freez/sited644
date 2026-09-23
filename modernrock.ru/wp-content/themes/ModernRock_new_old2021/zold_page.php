<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails events-list">
		<?php 
			wp_reset_query();
			/* Редкасса покупка на отдельной странице */
			if (have_posts() && get_the_ID() == '125969') :
		?>
		<?php
			$post = isset($_GET['event']) ? $_GET['event'] :'1';
			$arh=array('showposts'=>'1','p'=>$post);
			query_posts($arh);
			if (have_posts()) :
				while (have_posts()) : the_post();
					$buyticket_4=get_post_meta(get_the_ID(), 'buyticket_4', true);
					echo '<h1>Купить билеты на концерты группы '.get_the_title().'</h1>';
				endwhile;
			endif; ?>

		<div class="redkassa_buy">
			<script src="https://widgetapp.redkassa.ru/redkassa.js"></script>
			<div id="rk_events"></div>
			<script id="rk_settings" type="text/javascript">
				RK.Widget("rk_events", {
				widgetUrl: "https://widgetapp.redkassa.ru/Widget.html",
				serviceUrl: "https://modernrock-partner-api-live-ticketsystem.redkassa.ru/api/v1/",
				events: ["<?php echo $buyticket_4;?>"],//id Мероприятий
				isTrackingEnabled: true,
				isSeatGroupFirst: true,
				isSeatGroupsPriceAscending: true,
				isSectorSeatsPriceAscending: true,
				skipEventsStepAtSingleSeance: true
				});
			</script>
		</div>
		<?php else: ?>
			
			<?php 
				/* Календарь событий для Москвы и Питера */
				if (get_the_ID() == '43041' || get_the_ID() == '125982') : 
				$city = get_the_ID() == 43041 ? 'Москва' : 'Санкт-Петербург';
				$city_rp = get_the_ID() == 43041 ? 'Москве' : 'Санкт-Петербурге';
				
				$_monthsList = array(
				"1"=>"январь","2"=>"февраль","3"=>"март",
				"4"=>"апрель","5"=>"май", "6"=>"июнь",
				"7"=>"июль","8"=>"август","9"=>"сентябрь",
				"10"=>"октябрь","11"=>"ноябрь","12"=>"декабрь", "13"=>"Январь");
				$month = $_monthsList[date("n")];
				$month_plus = $_monthsList[date("n")+1];
			?>
			<h1>Календарь концертов в <?php echo $city_rp .' за '.$month.'-'.$month_plus;  ?> 2018 года</h1>
			<div class="events-list">
				<?php
					for($ii=0;$ii<30;$ii++){
						$date = new DateTime();
						$date->modify('+'.$ii.' day');
						if (date("w",strtotime($date->format('d.m.Y')))==0 || date("w",strtotime($date->format('d.m.Y')))==6){
							$weeks=" weeks";
						}
						else{
							$weeks="";
						}
				?>
				<div class="item">
					<div class="date<?php echo $weeks; ?>">
						<div class="number"><?php echo $date->format('d'); ?></div>
						<div class="md_wrap">
							<div class="month"><?php echo date_gigs($date->format('d.m.Y'),0); ?></div>
							<div class="days"><?php echo date_gigs($date->format('d.m.Y'),1); ?></div>
						</div>
					</div>
				<?php 
					wp_reset_query();
					$arh_tmp=array(
						'showposts'=>'150',
						'cat'=>'2872',
						'post_status'=>'publish',
						'order'=>'DESC',
						'meta_query'=>array(
							'0'=>array(
								'key' => 'data_afisha',
								'value' => array(
									'0'=>$date->format('Y-m-d 00:00:00'),
									'1'=>$date->format('Y-m-d 23:59:59')
								),
								'type' => 'DATETIME',
								'compare' => 'BETWEEN'
							),
							'1'=>array(
								'key' => 'city',
								'value' => $city
							)
						)
					);
					query_posts($arh_tmp);
					
					if (have_posts()) :
					while (have_posts()) : the_post();
				?>
				<?php 
					$tmp_buy=get_post_meta(get_the_ID(), 'buyticket', true);
				?>
					<div class="row">	
						<div class="event">
							<?php if ($tmp_buy<>''):?>
							<button onclick="window.open('<?php echo $tmp_buy;?>', '_blank');" class="buy"></button>
							<?php endif;?>
							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
							
						</div>
						<div class="club">
							<span class="time">
								<?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?>
							</span>
							<span class="name">
								<a href="<?php echo get_permalink(find_id_title(get_post_meta(get_the_ID(), 'club', true),13)); ?>">
									<?php echo get_post_meta(get_the_ID(), 'club', true);?>
								</a>
							</span>
						</div>
					</div>
				<?php
					endwhile;
					else :
				?>
				<div class="event">Событий нет</div>
				<?php
					endif;							
				?>
				</div>
				<?php
					}		
				?>
			</div>
			
			<?php else: ?>
				<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
				<?php while (have_posts()) : the_post(); ?>
				<?php the_content();?>
				<?php endwhile; ?>	
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>

<aside class="block_right">
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>
<?php get_footer(); ?>