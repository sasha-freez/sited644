<?php while (have_posts()) : the_post(); ?>
	<h1><?php the_title();?></h1>
	<?php the_content();?>
<?php endwhile; ?>

<?php
	wp_reset_query();
	$_monthsList = array(
	"1"=>"январь","2"=>"февраль","3"=>"март",
	"4"=>"апрель","5"=>"май", "6"=>"июнь",
	"7"=>"июль","8"=>"август","9"=>"сентябрь",
	"10"=>"октябрь","11"=>"ноябрь","12"=>"декабрь", "13"=>"Январь");
	$month = $_monthsList[date("n")];
	// Подключим базу
	global $wpdb;
?>
<div class="events-list el_bt">
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
			// Даты 2020-04-19 and 2020-04-20
			$start_date = date("Y-m-d", time()+$ii*86400);
			$end_date = date("Y-m-d", time()+($ii+1)*86400);

			// Выберу все билеты за сутки
			$rowID = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `meta_key` = 'data_afisha' AND (`meta_value` >= '".$start_date."' AND `meta_value` < '".$end_date."') ORDER BY `meta_value` DESC LIMIT 100");

			$groupID = [0];
			foreach($rowID as $resID) {
				$groupID[] = $resID->post_id;
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
		$arh_tmp=array(
			'cat'=>'2872',
			'post__in' => $groupID
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