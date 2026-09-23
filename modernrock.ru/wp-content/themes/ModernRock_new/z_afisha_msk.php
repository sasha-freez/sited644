<?php
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
<h1>Календарь концертов в <?php echo $city_rp .' за '.$month.'-'.$month_plus;  ?> <?php echo date('Y'); ?> года</h1>
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
	<?php endwhile;
		else:
	?>
		<div class="event">Событий нет</div>
	<?php endif; ?>
	</div>
	<?php
		}
	?>
</div>