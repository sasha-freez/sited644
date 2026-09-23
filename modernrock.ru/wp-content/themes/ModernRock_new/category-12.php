<?php get_header(); ?>
<div class="block_left">
	<div class="h1">Поиск групп</div>
	<div class="csearch">
		<form action="/groups" method="get">
			<input type="text" class="inp" name="q" value="<?php if (isset($_GET['q']) && $_GET['q']<>''){echo esc_attr(modernrock_search_term('q'));}else{echo 'Поиск';}?>" onfocus="this.value='';" onblur="if (this.value == ''){this.value='Поиск'};"/>
			<input type="image" src="/images/i_search.png" class="submit" name="submit"/>
		</form>
	</div>
	<?php if (!isset($_GET['q'])):?>
	<div class="h3">Группы по алфавиту</div>
	<div class="group-alfa">
		<div class="row">
			<a href="/groups">#</a>
			<a href="/groups/?gr=А">А</a>
			<a href="/groups/?gr=Б">Б</a>
			<a href="/groups/?gr=В">В</a>
			<a href="/groups/?gr=Г">Г</a>
			<a href="/groups/?gr=Д">Д</a>
			<a href="/groups/?gr=E">E</a>
			<a href="/groups/?gr=Ё">Ё</a>
			<a href="/groups/?gr=Ж">Ж</a>
			<a href="/groups/?gr=З">З</a>
			<a href="/groups/?gr=И">И</a>
			<a href="/groups/?gr=К">К</a>
			<a href="/groups/?gr=Л">Л</a>
			<a href="/groups/?gr=М">М</a>
			<a href="/groups/?gr=Н">Н</a>
			<a href="/groups/?gr=О">О</a>
			<a href="/groups/?gr=П">П</a>
			<a href="/groups/?gr=Р">Р</a>
			<a href="/groups/?gr=С">С</a>
			<a href="/groups/?gr=Т">Т</a>
			<a href="/groups/?gr=У">У</a>
			<a href="/groups/?gr=Ф">Ф</a>
			<a href="/groups/?gr=Х">Х</a>
			<a href="/groups/?gr=Ц">Ц</a>
			<a href="/groups/?gr=Ч">Ч</a>
			<a href="/groups/?gr=Ш">Ш</a>
			<a href="/groups/?gr=Щ">Щ</a>
			<a href="/groups/?gr=Э">Э</a>
			<a href="/groups/?gr=Ю">Ю</a>
			<a href="/groups/?gr=Я">Я</a>
		</div>
		<div class="row">
			<a href="/groups">#</a>
			<a href="/groups/?gr=A">A</a>
			<a href="/groups/?gr=B">B</a>
			<a href="/groups/?gr=C">C</a>
			<a href="/groups/?gr=D">D</a>
			<a href="/groups/?gr=E">E</a>
			<a href="/groups/?gr=F">F</a>
			<a href="/groups/?gr=G">G</a>
			<a href="/groups/?gr=H">H</a>
			<a href="/groups/?gr=I">I</a>
			<a href="/groups/?gr=J">J</a>
			<a href="/groups/?gr=K">K</a>
			<a href="/groups/?gr=L">L</a>
			<a href="/groups/?gr=M">M</a>
			<a href="/groups/?gr=N">N</a>
			<a href="/groups/?gr=O">O</a>
			<a href="/groups/?gr=P">P</a>
			<a href="/groups/?gr=Q">Q</a>
			<a href="/groups/?gr=R">R</a>
			<a href="/groups/?gr=S">S</a>
			<a href="/groups/?gr=T">T</a>
			<a href="/groups/?gr=U">U</a>
			<a href="/groups/?gr=V">V</a>
			<a href="/groups/?gr=W">W</a>
			<a href="/groups/?gr=X">X</a>
			<a href="/groups/?gr=Y">Y</a>
			<a href="/groups/?gr=Z">Z</a>				
		</div>
	</div>
	
	<script>select_alfavit(<?php echo wp_json_encode(modernrock_search_term('gr'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>);</script>
	
	<div class="group-list">
		<div class="left">
			<div class="gr-first">
				<?php wp_reset_query(); ?>
				<?php
					$arh=array(
						'showposts'=>'1',
						'cat'=>'12',
						'meta_key'=>'new_name_group',
						'meta_value'=>'true'
					);
					query_posts($arh);
				?>
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<?php 
					$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
				?>
				
				<div class="name"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></div>
				<div class="img"><a href="<?php the_permalink(); ?>"><img src="<?php echo kama_thumb_src('w=115&h=67',$large[0]);?>" width="115" height="67" alt="<?php the_title();?>"/></a></div>
				<div class="desc">Новые имена</div>
				<?php endwhile; ?>
				<?php endif; ?>
			</div>
			<!--<div class="gr-search">
				<form action="/groups" method="get">
					<div class="input"><input type="text" name="q" value="<?php if (isset($_GET['q']) && $_GET['q']<>''){echo esc_attr(modernrock_search_term('q'));}else{echo 'Поиск';}?>"/></div>
					<div class="submit">
						<input type="submit" value=""/>
					</div>
				</form>
			</div>-->
		</div>

		<div class="right">
			<ul>
				<?php wp_reset_query(); ?>
				<?php
					$arh=array(
						'showposts'=>'50',
						'cat'=>'12',
						'order'=>'ASC',
						'orderby'=>'title'
					);
					query_posts($arh);
				?>
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
				<?php endwhile; ?>
				<?php endif; ?>
			</ul>
			<?php
				$tmp_cat=get_the_category();
			?>
			<div class="pagelist">
				<a href="#" class="prev_gr"></a>
				<span><strong>1</strong> / <?php echo round($tmp_cat[0]->category_count/48);?></span>
				<a href="#" class="next_gr"></a>
				<input type="hidden" id="group_pagelist_count" value="<?php echo round($tmp_cat[0]->category_count/48);?>">
				<input type="hidden" id="page_num" value="1">
			</div>							
		</div>
	</div>
	<?php endif;?>
	
	<div class="h2">Последние добавленные</div>
	
	<div class="section_list section_groups">
		<ul class="tiles">
			<?php wp_reset_query(); ?>
			<?php
				function filter_where($where = '') {
					global $wpdb;
                    $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", $wpdb->esc_like(modernrock_search_term('gr')) . '%');
					return $where;
				}
				
				function filter_where_find($where = '') {
					global $wpdb;
                    $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . $wpdb->esc_like(modernrock_search_term('q')) . '%');
					return $where;
				}
				
				if (isset($_GET['gr']) && $_GET['gr']<>'') add_filter('posts_where', 'filter_where');
				
				if (isset($_GET['q']) && $_GET['q']<>'') add_filter('posts_where', 'filter_where_find');
				
				$arh=array(
					'showposts'=>15,
					'cat'=>'12,-97',
					'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
				);
				query_posts($arh);
                    remove_filter('posts_where', 'filter_where_find');
                    remove_filter('posts_where', 'filter_where');
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
			<li>
				<div class="row">
					<div class="img"><a href="<?php the_permalink(); ?>"><b></b><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" alt="<?php the_title();?>" /></a></div>
					<div class="date"><?php the_time('d.m.Y') ?></div>
					<div class="name"><a href="<?php the_permalink(); ?>" title=" <?php the_title_attribute(); ?>"><?php the_title();?></a></div>
				</div>
			</li>
			<?php endwhile; ?>
			<?php endif; ?>		
		</ul>
	</div>	
	<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_recommend.php'); ?>
</aside>
<?php get_footer(); ?>