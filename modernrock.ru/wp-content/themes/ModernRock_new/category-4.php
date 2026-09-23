<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="events-list">						
		<?php	
			
			for($ii=0;$ii<15;$ii++){
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
				'showposts'=>'100',
				'cat'=>'4',
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
					<a href="<?php echo $tmp_buy;?>" class="buy" rel="nofollow" target="_blank"></a>
					<?php endif;?>
					<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
					
				</div>
				<div class="club">
					<span class="time"><?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></span>
					<span class="name"><?php echo get_post_meta(get_the_ID(), 'club', true);?></span>
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
</div>
		
<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_recommend.php'); ?>
</aside>
<?php get_footer(); ?>