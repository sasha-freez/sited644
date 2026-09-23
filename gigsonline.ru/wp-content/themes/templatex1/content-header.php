	
<header>
	<div class="h_info">
		<div class="container">
			<div class="row">
			
				
					
			
					<div class="col-xs-12 col-md-2 h_logan hitem" id="logo">
						<a href="/">
							<img src="<?=get_template_directory_uri()?>/img/logo.png">
						</a>
					</div>
					
				<div class="col-xs-12 col-md-3 h_slogan">
				Строительная<br> компания
				</div>
				
				
				<div class="col-xs-12 col-md-3 h_location h_citem">
					<div class="h_location_item">
					<span class="material-icons">location_on</span>
					<?php echo get_option('my_location'); ?>
					</div>
				</div>
				<div class="col-xs-12 col-md-2and5 h_phone h_citem">
				<div class="h_phone_item_wrap">
					<span class="material-icons">local_phone</span>
					<div class="h_phone_item">
					<?php echo get_option('my_phone'); ?>
					</div>
					<div class="h_time_item"><?php echo get_option('my_worktime'); ?></div>
				</div>
				</div>
				<div class="col-xs-12 col-md-1and5 h_citem">
					<div class="order datatextcopy" data-toggle="modal" data-target="#myzakaz2" rel="outline-inward" data-mydata="Попросить нас перезвонить">Заказать звонок</div>
				</div>
	
					
					<div class="clearfix"></div>
					</div>
					
				</div>
				
	</div>
	

	<div class="container">
	<div class="top_site_wrap">
		<div class="top_site">
			<?php wp_nav_menu( [ 'menu_class'  => 'topmenu',  'menu_id' => '', ] ); ?>
			<div class="search_btn"><? get_template_part( 'content', 'searchicon' ); ?></div>
		</div>
	</div>
	</div>
</header>