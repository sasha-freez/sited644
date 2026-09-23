<?php
echo '<!-- TEMPLATE: z_single-12 -->';
get_header(); 
?>
<?php $date = new DateTime(); // текущая дата ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails d_groups">	
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			$tmp_tag=get_the_tag_list('<div class="h3">Теги:</div>', '<span class="qt">&nbsp;</span>', '');
			$tmp_title=get_the_title();
			$tmp_count=get_post_meta(get_the_ID(), 'country', true);
			$sql_title=get_the_title(get_the_ID());
		$gigsbot_artist_name = $sql_title;
			/* Баннеры справа */
			$gr_banner1_link = get_post_meta(get_the_ID(), 'gr_banner1', true);
			$gr_banner2_link = get_post_meta(get_the_ID(), 'gr_banner2', true);
			
			// Подключим базу
			global $wpdb;
			// Выберу все билеты связанные с артистом
			$rowID = $wpdb->get_results( "SELECT * FROM `wp_postmeta` WHERE `meta_key` = 'group_afisha' AND `meta_value` = '$sql_title' LIMIT 100" );
			
			// Соберу ID полученных постов
			$g=0; $groupID='';
			foreach($rowID as $resID) {
				if($g != 0){
					$groupID.=',';
				}
				$groupID.=$resID->post_id;
				$g++;
			}
			// Выберу город и даты афиши для распределения по городам
			$rowTickets = $wpdb->get_results( "SELECT * FROM `wp_posts` JOIN `wp_postmeta` WHERE `post_status`='publish' AND `ID`=`post_id` AND `ID` IN ($groupID) and (`meta_key`= 'data_afisha' OR `meta_key`= 'city') LIMIT 198;");
			$arr = []; $now = time();
			foreach($rowTickets as $resTickets) {
				$arr[$resTickets->post_id]['id'] = $resTickets->post_id;
				if($resTickets->meta_key == "city" && $resTickets->meta_value == "Москва"){
					$arr[$resTickets->post_id]['msk'] = 1;
				}
				if($resTickets->meta_key == "city" && $resTickets->meta_value == "Санкт-Петербург"){
					$arr[$resTickets->post_id]['spb'] = 1;
				}
				if($resTickets->meta_key == "data_afisha"){
					$arr[$resTickets->post_id]['date'] = strtotime($resTickets->meta_value);
					$arr[$resTickets->post_id]['date_bd'] = $resTickets->meta_value;
				}
			}
			function array_multisort_value(){
				$args = func_get_args();
				$data = array_shift($args);
				foreach ($args as $n => $field) {
					if (is_string($field)) {
						$tmp = array();
						foreach ($data as $key => $row) {
							$tmp[$key] = $row[$field];
						}
						$args[$n] = $tmp;
					}
				}
				$args[] = &$data;
				call_user_func_array('array_multisort', $args);
				return array_pop($args);
			}
			
			$arrCity = array_multisort_value($arr, 'date', SORT_ASC);
			$arrPrev = array_multisort_value($arr, 'date', SORT_DESC);

			$ticketCityID = [];
			$ticketCityID['msk'] = ['0'];
			$ticketCityID['spb'] = ['0'];
			foreach($arrCity as $arrCityID) {
				if($arrCityID['date'] > $now){
					if(isset($arrCityID['msk']) == 1){
						$ticketCityID['msk'][] = $arrCityID['id'];
					}
					if(isset($arrCityID['spb']) == 1){
						$ticketCityID['spb'][] = $arrCityID['id'];
					}
				}
			}

			$ticketPrevID = ['0'];
			foreach($arrPrev as $arrPrevID) {
				if($arrPrevID['date'] < $now){
					$ticketPrevID[] = $arrPrevID['id'];
				}
			}
		?>
		<h1><?php the_title();?> <?php if ($tmp_count<>''):?>(<?php echo $tmp_count; ?>)<?php endif;?> — афиша концертов в Москве и СПБ</h1>
		<?php include('sn_social.php'); ?>

		<div class="img"><img src="<?php echo $large[0]; ?>" alt="<?php the_title();?>" /></div>
		<div class="seo_txt">
			На modernrock.ru вы можете купить билеты на <?php the_title();?> по официальным ценам.
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<h2 class="h2bl">Концерты <?php echo $sql_title;?> в Москве:</h2>
		
		<div class="ticket_list ticket_list_cont">	
			<?php 
				wp_reset_query();
				$arh_tmp=array(
					'showposts' => 10,
					'post__in' => $ticketCityID['msk']
					
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
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=140&h=80',$large[0]);?>" width="140" height="80" alt="<?php the_title();?>" /></a></div>
					<div class="desc">
						<div class="date">
							<a href="<?php the_permalink(); ?>"><?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>, <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></a>
						</div>
						<div class="club"><?php echo get_post_meta(get_the_ID(), 'club', true); ?></div>
						<div class="price"><?php echo get_post_meta(get_the_ID(), 'ticket_ot', true); ?></div>
					</div>
					<div class="buytickets">
						<?php 
							$buyticket=get_post_meta(get_the_ID(), 'buyticket', true);
							$buyticket_1=get_post_meta(get_the_ID(), 'buyticket_1', true);
							$buyticket_1_radio=get_post_meta(get_the_ID(), 'buyticket_1_radio', true);
							$buyticket_2=get_post_meta(get_the_ID(), 'buyticket_2', true);
							$buyticket_3=get_post_meta(get_the_ID(), 'buyticket_3', true);
							$buyticket_4=get_post_meta(get_the_ID(), 'buyticket_4', true);
							$buyticket_5=get_post_meta(get_the_ID(), 'buyticket_5', true);
						?>
						<?php if ($buyticket_1):?>
							<script src="https://spb.kassir.ru/start-frame.js"></script>
							<div class="buy">
								<?php $spbType = $buyticket_1_radio == 'event'? 'E': 'A'; ?>
								<a href="https://spb.kassir.ru/frame/entry/index/<?php echo $buyticket_1; ?>?type=<?php echo $spbType; ?>&key=cbd41884-b8b7-bab9-86f6-74b60e584ce2" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a>
							</div>
						<?php endif;?>
						<?php if ($buyticket_2):?>
							<script src="https://msk.kassir.ru/start-frame.js"></script>
							<div class="buy <? if ($buyticket || $buyticket_4) echo 'kassir'; ?>">
								<a href="https://msk.kassir.ru/frame/event/<?php echo $buyticket_2; ?>?key=47fff075-4762-d3b1-95e6-95c7fe20d2b8" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a> 
								<?php if ($buyticket || $buyticket_4): ?>
									<span class="service_type">на KASSIR.RU</span>
								<?php endif;?>
							</div>
						<?php endif;?>
						<?php if ($buyticket_3):?>
							<div class="buy">
								<button onclick="window.open('http://concert.ru/widget/index.htm?actionId=<?php echo $buyticket_3; ?>&companyid=3576', '_blank');">Купить билет</button>
								<?php if ($buyticket || $buyticket_2 || $buyticket_4): ?>
									<span class="service_type">на CONCERTRU</span>
								<?php endif;?>
							</div>
						<?php endif;?>
						<?php if ($buyticket):?>
							<div class="buy">
								<button onclick="window.open('<?php echo $buyticket; ?>', '_blank');">Купить билет</button> 
								<?php if ($buyticket_2 || $buyticket_4): ?>
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
					</div>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div class="ticket_no">В ближайшее время событий не запланировано.</div>
			<?php endif; ?>
		</div>
		<br/>
		<h2 class="h2bl">Концерты <?php echo $sql_title;?> в Санкт-Петербурге:</h2>
		<div class="ticket_list ticket_list_cont">	
			<?php 
				wp_reset_query();
				$arh_tmp=array(
					'showposts' => 10,
					'post__in' => $ticketCityID['spb']
					
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
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php echo kama_thumb_src('w=140&h=80',$large[0]);?>" width="140" height="80" alt="<?php the_title();?>" /></a></div>
					<div class="desc">
						<div class="date">
							<a href="<?php the_permalink(); ?>"><?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?>, <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></a>
						</div>
						<div class="club"><?php echo get_post_meta(get_the_ID(), 'club', true); ?></div>
						<div class="price"><?php echo get_post_meta(get_the_ID(), 'ticket_ot', true); ?></div>
					</div>
					<div class="buytickets">
						<?php 
							$buyticket=get_post_meta(get_the_ID(), 'buyticket', true);
							$buyticket_1=get_post_meta(get_the_ID(), 'buyticket_1', true);
							$buyticket_1_radio=get_post_meta(get_the_ID(), 'buyticket_1_radio', true);
							$buyticket_2=get_post_meta(get_the_ID(), 'buyticket_2', true);
							$buyticket_3=get_post_meta(get_the_ID(), 'buyticket_3', true);
							$buyticket_4=get_post_meta(get_the_ID(), 'buyticket_4', true);
							$buyticket_5=get_post_meta(get_the_ID(), 'buyticket_5', true);
						?>
						<?php if ($buyticket_1):?>
							<script src="https://spb.kassir.ru/start-frame.js"></script>
							<div class="buy">
								<?php $spbType = $buyticket_1_radio == 'event'? 'E': 'A'; ?>
								<a href="https://spb.kassir.ru/frame/entry/index/<?php echo $buyticket_1; ?>?type=<?php echo $spbType; ?>&key=cbd41884-b8b7-bab9-86f6-74b60e584ce2" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a>
							</div>
						<?php endif;?>
						<?php if ($buyticket_2):?>
							<script src="https://msk.kassir.ru/start-frame.js"></script>
							<div class="buy <? if ($buyticket || $buyticket_4) echo 'kassir'; ?>">
								<a href="https://msk.kassir.ru/frame/event/<?php echo $buyticket_2; ?>?key=47fff075-4762-d3b1-95e6-95c7fe20d2b8" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a> 
								<?php if ($buyticket || $buyticket_4): ?>
									<span class="service_type">на KASSIR.RU</span>
								<?php endif;?>
							</div>
						<?php endif;?>
						<?php if ($buyticket_3):?>
							<div class="buy">
								<button onclick="window.open('http://concert.ru/widget/index.htm?actionId=<?php echo $buyticket_3; ?>&companyid=3576', '_blank');">Купить билет</button>
								<?php if ($buyticket || $buyticket_2 || $buyticket_4): ?>
									<span class="service_type">на CONCERTRU</span>
								<?php endif;?>
							</div>
						<?php endif;?>
						<?php if ($buyticket):?>
							<div class="buy">
								<button onclick="window.open('<?php echo $buyticket; ?>', '_blank');">Купить билет</button> 
								<?php if ($buyticket_2 || $buyticket_4): ?>
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
					</div>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div class="ticket_no">В ближайшее время событий не запланировано.</div>
			<?php endif; ?>
		</div>
		
		<?php wp_reset_query(); ?>
        <?php echo '<!-- debug: sql=[' . $sql_title . '] tmp=[' . $tmp_title . '] gigsbot=[' . $gigsbot_artist_name . '] -->'; ?>

<?php
// === GigsBot: концерты в других городах ===
if (!empty($gigsbot_artist_name)) {
    $gigsbot_url = 'http://127.0.0.1:99999/api/concerts?artist=' . urlencode($gigsbot_artist_name) . '&token=gigsbot2026';
    $gigsbot_response = wp_remote_get_disabled($gigsbot_url, ['timeout' => 1]);
    $gigsbot_concerts = [];
    if (!is_wp_error($gigsbot_response)) {
        $gigsbot_data = json_decode(wp_remote_retrieve_body($gigsbot_response), true);
        if (!empty($gigsbot_data['concerts'])) $gigsbot_concerts = $gigsbot_data['concerts'];
    }
    $gigsbot_other = array_filter($gigsbot_concerts, function($c) {
        return $c['city'] !== 'Москва' && $c['city'] !== 'Санкт-Петербург';
    });
    $gigsbot_by_city = [];
    foreach ($gigsbot_other as $c) $gigsbot_by_city[$c['city']][] = $c;
    foreach ($gigsbot_by_city as $gigsbot_city => $gigsbot_events) {
        echo '<br/><h2 class="h2bl">Концерты ' . esc_html($gigsbot_artist_name) . ' в ' . esc_html($gigsbot_city) . ':</h2>';
        echo '<div class="ticket_list ticket_list_cont">';
        foreach ($gigsbot_events as $ge) {
            $ge_date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $ge['date']);
            $ge_ts = strtotime($ge_date_str);
            $months = [1=>'января',2=>'февраля',3=>'марта',4=>'апреля',5=>'мая',6=>'июня',7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'];
            $ge_day = date('j', $ge_ts);
            $ge_month = $months[(int)date('n', $ge_ts)];
            $ge_year = date('Y', $ge_ts);
            $ge_time = date('H:i', $ge_ts);
            $ge_date_fmt = ($ge_time !== '00:00') ? "$ge_day $ge_month $ge_year, $ge_time" : "$ge_day $ge_month $ge_year";
            echo '<div class="item">';
            echo '<div class="desc">';
            echo '<div class="date"><a href="' . esc_url($ge['url']) . '">' . esc_html($ge_date_fmt) . '</a></div>';
            echo '<div class="club">' . esc_html($ge['place']) . '</div>';
            if ($ge['price']) echo '<div class="price">билеты от ' . number_format($ge['price'], 0, '', ' ') . ' руб.</div>';
            echo '</div>';
            echo '<div class="buytickets"><div class="buy"><a href="' . esc_url($ge['url']) . '" rel="nofollow" target="_blank">Купить билет</a></div></div>';
            echo '</div>';
        }
        echo '</div>';
    }
}
// === конец GigsBot ===
?>
		
		<?php 
			wp_reset_query();
			$arh_tmp=array(
				'showposts' => 20,
				'cat' => 2872,
				'post__in' => $ticketPrevID
			);
			query_posts($arh_tmp);
			
			if (have_posts()) :?>
			<br/>
			<h3>Прошедшие концерты:</h3>
			
			<div class="ticket_list ticket_list_cont2">	
			<?php while (have_posts()) : the_post();?>

			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<div class="row">
				<a href="<?php the_permalink(); ?>"><?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> - <?php echo get_post_meta(get_the_ID(), 'club', true); ?>, <?php echo get_post_meta(get_the_ID(), 'city', true); ?>
				</a>
			</div>
			<?php endwhile; ?>
			</div>
			<?php endif; ?>
		
		<h1>Концерты <?php echo $sql_title;?> в России</h1>
		<div class="buytickets">
			<div class="buy"> 
					<a href="#" title="купить билет на концерт">Найти концерты</a>
			</div>
		</div>
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post_content" id="cat_more">
			<?php if(get_post_time() > 1416839400): ?>
				<?php the_content('',true); ?>
			<?php else:?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile;  ?>
		<?php endif; ?>
		<div class="seo_txt2">
			<p>
				Наы концерты <?php echo $sql_title;?> в России мы рекомендуем покупать билеты заранее. Мы не продаем билеты, а показываем где их можно купить по официальным ценам и, по возможности, без комиссии. Проще всего купить электронный билет (e-ticket) - его нужно будет только распечатать на принтере. Если вы не нашли в афише нужного события - пишите нам и мы добавим концерт <?php echo $sql_title;?> в <?php echo date("Y").' и '.date("Y", strtotime("+1 year"));?> году в нашу базу.
			</p>
		</div>
	</div>
	
	<div class="tags"><?php echo $tmp_tag;?></div>
	
	<?php
		wp_reset_query();
		$arh=array(
			'showposts'=>'6',
			'cat'=>'3',
			'meta_key'=>'news_group',
			'meta_value'=>$tmp_title
		);
		query_posts($arh);
		$i=0;
	?>
	<?php if (have_posts()) : ?>
	<div class="n-item bnews relative_news">
		<div class="h3">Новости об этом исполнителе</div>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		<div class="row">
			<a href="<?php the_permalink(); ?>">
				<span class="img"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title_attribute(); ?>" /></span>
				<span class="desc">
					<span class="name"><?php the_title();?></span>
				</span>
			</a>
		</div>
		<?php $i++;endwhile; ?>
	</div>	
	<?php endif; ?>	
	
	<?php
		wp_reset_query();
		$arh=array(
			'showposts'=>'6',
			'cat'=>'7',
			'meta_key'=>'video_group',
			'meta_value'=>$tmp_title
		);
		query_posts($arh);
		$i=0;
	?>
	<?php if (have_posts()) : ?>
	<div class="n-item bnews relative_news">
		<div class="h3">Видео с этим исполнителем</div>
		<?php while (have_posts()) : the_post(); ?>
		<?php 
			$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
		?>
		<div class="row">
			<a href="<?php the_permalink(); ?>">
				<span class="img"><img src="<?php echo kama_thumb_src('w=47&h=47',$large[0]);?>" width="47" height="47" alt="<?php the_title_attribute(); ?>" /></span>
				<span class="desc">
					<span class="name"><?php the_title();?></span>
				</span>
			</a>
		</div>
		<?php $i++;endwhile; ?>
	</div>
	<?php endif; ?>	
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>
<div class="block_popup" id="block_popup"><span class="close"></span>
	<div class="wrapper_popup" id="wrapper_popup"></div>
</div>
<?php get_footer(); ?>