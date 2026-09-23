<?php get_header(); $date = new DateTime(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />

<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<!-- доправить -->
	<div class="bdetails d_gigs">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="h1"><?php the_title(); ?></div>
		<div class="btn-buy">
			<?php if (get_post_meta(get_the_ID(), 'buyticket', true)<>''):?>
			<a href="<?php echo get_post_meta(get_the_ID(), 'buyticket', true);?>" title="купить билет" target="_blank"></a>
			<?php endif;?>
		</div>
		
	
		
		
		<div class="club"><p>Клуб: <a href="<?php echo get_permalink(find_id_title(get_post_meta(get_the_ID(), 'club', true),13)); ?>"><?php echo get_post_meta(get_the_ID(), 'club', true);?></a></p></div>
		<div class="group">
			Группа:
			<?php  /* ссылка на группу */
			$sql_title='';
			$tt ='';
			$gr = get_the_title();
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
						$sql_title=get_the_title();
						$tt = '<a href="' .get_permalink(). '">' . get_the_title() . '</a>';
						echo $tt;
					}
				}
			}else{
				echo '<span>'.get_the_title().'</span>';
			}
			wp_reset_postdata();
			?>
			</p>
		</div>
		
		<div class="date"><p>Дата концерта: <?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo get_post_meta(get_the_ID(), 'time_afisha', true); ?></p></div>
		<div class="desc">							
			<div class="img">
			<?php
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='' && get_post_meta(get_the_ID(), 'attached_img', true)<>'') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				if (isset($large[0])) :
			?>
			<img src="<?php echo $large[0]; ?>" width="600" alt=" " />
			<?php endif;?>
			</div>
		</div>
		<div class="post_content">
			<?php if(get_post_time() > 1416839400): // &gt; 21.11.2014 ?>
				<?php the_content('',true); ?>
			<?php else:?>
				<?php the_content(); ?>
			<?php endif; ?>
			
			<div class="seo_t">
				На нашем сайте представлена самая полная афиша концертов группы <?php echo $tt; ?> в Москве и Санкт-Петербурге. Ознакомиться с расписанием своих любимых артистов вы можете в разделе "Билеты".<br/><br/>
			</div>
		</div>
		
		<?php endwhile;  ?>
		<?php endif; ?>
		
		
		<?php if($sql_title != ''): ?>
			<h2 class="h2bl">Концерты <?php echo $sql_title;?> в Москве:</h2>
			
			<?php
				$link_club=array(
					'showposts'=>1,
					'cat'=>13,
					'name'=>$sql_title
				);
				query_posts($link_club);
				if (have_posts()) :
				while (have_posts()) : the_post();
				//$club_name='<a href="'.the_permalink().'"> '.get_the_title(get_the_ID()).'</a>';
				endwhile;
				endif;
			?>
			
			<div class="ticket_list ticket_list_cont">	
				<?php 
					wp_reset_query();
					$arh_tmp=array(
						'showposts' => 5,
						'cat' => 2872,
						'meta_key' => 'data_afisha',
						'orderby' => 'meta_value',
						'order' => 'ASC',
						'title' => $sql_title,
						'meta_query'=>array(
							array(
								'key' => 'data_afisha',
								'value' =>$date->format('Y-m-d 00:00:00'),
								'compare'=>'>=',
								'type' => 'DATETIME'
							),
							array(
								'key' => 'city',
								'value' => 'Москва'
							)
						)
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
								$buyticket=get_post_meta(get_the_ID(), 'buyticket', true); // Ссылка или пономиналу
								$buyticket_1=get_post_meta(get_the_ID(), 'buyticket_1', true);  // Кассир СПБ
								$buyticket_1_radio=get_post_meta(get_the_ID(), 'buyticket_1_radio', true); // событие или мероприятие
								$buyticket_2=get_post_meta(get_the_ID(), 'buyticket_2', true);  // Кассир МСК
								$buyticket_3=get_post_meta(get_the_ID(), 'buyticket_3', true);  // ConcertRU
							?>
							<?php if ($buyticket_1<>''):?>
								<script src="https://spb.kassir.ru/start-frame.js"></script>
								<div class="buy">
									<?php $spbType = $buyticket_1_radio == 'event'? 'E': 'A'; ?>
									<a href="https://spb.kassir.ru/frame/entry/index/<?php echo $buyticket_1; ?>?type=<?php echo $spbType; ?>&key=cbd41884-b8b7-bab9-86f6-74b60e584ce2" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a> 
								</div>
							<?php endif;?>
							
							<?php if ($buyticket_2<>''):?>
								<script src="https://msk.kassir.ru/start-frame.js"></script>
								<?php if ($buyticket): // если есть Ссылка на билет по номиналу, то купить билет кассир имеет вид ?>
									<div class="buy kassir">
										<a href="https://msk.kassir.ru/frame/event/<?php echo $buyticket_2; ?>?key=47fff075-4762-d3b1-95e6-95c7fe20d2b8" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a>
										<span class="service_type">на KASSIR.RU</span>
									</div>
								<?php else:?>
									<div class="buy">
									<a href="https://msk.kassir.ru/frame/event/<?php echo $buyticket_2; ?>?key=47fff075-4762-d3b1-95e6-95c7fe20d2b8" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a></div>
								<?php endif;?>
							<?php endif;?>
							
							<?php if ($buyticket_3<>''):?>
								<div class="buy"><a href="http://concert.ru/widget/index.htm?actionId=<?php echo $buyticket_3; ?>&companyid=3576" rel="nofollow" target="_blank">Купить билет</a></div>
							<?php endif;?>
							
							<?php if ($buyticket<>''):?>
								<?php if ($buyticket_2): // если есть Кассир МСК, то купить билет пономиналу имеет вид ?>
									<div class="buy"><a href="<?php echo $buyticket; ?>" rel="nofollow" target="_blank">Купить билет</a> <span class="service_type">на PONOMINALU.RU</span></div>
								<?php else:?>
									<div class="buy"><a href="<?php echo $buyticket; ?>" rel="nofollow" target="_blank">Купить билет</a></div>
								<?php endif;?>
								<!-- на KASSIR.RU -->
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
						'showposts' => 5,
						'cat' => 2872,
						'meta_key' => 'data_afisha',
						'orderby' => 'meta_value',
						'order' => 'ASC',
						'title' => $sql_title,
						'meta_query'=>array(
							array(
								'key' => 'data_afisha',
								'value' =>$date->format('Y-m-d 00:00:00'),
								'compare'=>'>=',
								'type' => 'DATETIME'
							),
							array(
								'key' => 'city',
								'value' => 'Санкт-Петербург'
							)
						)
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
									<a href="https://spb.kassir.ru/frame/entry/index/<?php echo $buyticket_1; ?>?type=<?php echo $spbType; ?>&key=cbd41884-b8b7-bab9-86f6-74b60e584ce2" onclick="return kassirWidget.summon();" rel="nofollow" target="_blank">Купить билет</a>
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
						</div>
					</div>
				<?php endwhile; ?>
				<?php else: ?>
					<div class="ticket_no">В ближайшее время событий не запланировано.</div>
				<?php endif; ?>
			</div>
		
		<?php endif; ?>

	</div>
	
	<?php include('sn_tags.php'); ?>

	<?php include('sn_comments.php'); ?>
</div>
<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>
<div class="block_popup" id="block_popup"><span class="close"></span>
	<div class="wrapper_popup" id="wrapper_popup"></div>
</div>
<?php get_footer(); ?>