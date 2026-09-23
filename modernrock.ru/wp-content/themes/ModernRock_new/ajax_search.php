<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-config.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');
define('WP_DEBUG', true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
			<?php wp_reset_query(); ?>
			<?php
				function filter_where($where = '') {
					$where .= " AND post_title like '".$_GET['gr']."%'";  
					return $where;
				}
				
				function filter_where_find($where = '') {
					$where .= " AND post_title like '%".$_GET['q']."%'";  
					return $where;
				}
				
				if (isset($_GET['gr']) && $_GET['gr']<>'') add_filter('posts_where', 'filter_where');
				
				if (isset($_GET['q']) && $_GET['q']<>'') add_filter('posts_where', 'filter_where_find');
				
				$arh=array(
					'showposts'=>4,
					'cat'=>'12,-97',
					'paged' =>  get_query_var('paged') ? get_query_var('paged') : 1
				);
				query_posts($arh);
			?>
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
				$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if (!isset($large[0])) $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
			?>
				<a href="<?php the_permalink(); ?>">
					<div class="hint_item">
						<div class="hint_image"><img src="<?php if(preg_match('!\.(gif)$!i', $large[0])){echo $large[0];}else{echo kama_thumb_src('w=275&h=160',$large[0]);} ?>" alt="<?php the_title();?>" /></div>
						<div class="hint_title"><?php the_title();?></div>
					</div>
				</a>
			<?php endwhile; ?>
			<?php endif; ?>		