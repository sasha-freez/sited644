<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<style>
.venue-list{display:grid;grid-template-columns:1fr 1fr;gap:0 20px;}
.venue-card{display:flex;gap:15px;align-items:flex-start;width:100%;box-sizing:border-box;padding:0 0 20px 0;margin:0 0 20px 0;border-bottom:1px solid #eee;}
.venue-card-media{flex:0 0 165px;display:block;}
.venue-card-media img{width:100%;height:auto;border-radius:6px;display:block;}
.venue-card-body{flex:1 1 auto;min-width:0;display:flex;flex-direction:column;align-self:stretch;}
.venue-card-title{font-size:16px;font-weight:600;margin:0 0 6px;line-height:1.3;}
.venue-card-title a{color:#000;text-decoration:none;}
.venue-card-meta{font-size:13px;color:#555;margin:0 0 4px;}
.venue-card-price{font-size:13px;color:#000;margin:0 0 10px;font-weight:500;}
.venue-card-buy{display:inline-block;background:#0e920e!important;color:#fff!important;text-align:center;border-radius:6px;padding:8px 18px;font-size:14px;font-weight:600;text-decoration:none!important;margin-top:auto;align-self:flex-start;}
@media screen and (max-width:480px){
.venue-list{grid-template-columns:1fr;}
.venue-card{flex-direction:column;}
.venue-card-media{width:100%;}
.venue-card-buy{display:block;width:100%;box-sizing:border-box;text-align:center;align-self:stretch;}
}
.venue-card-nofee{font-size:12px;color:#2e7d32;font-weight:600;margin-top:6px;}
</style>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>

	<div class="bdetails d_interview">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php $sql_title = get_the_title(get_the_ID()); ?>

		<h1><?php the_title(); ?> - афиша, концерты и билеты</h1>
		<?php include('sn_social.php'); ?>

		<h2 class="h2bl"><span class="bl">Ближайшие</span> <span class="wh">концерты</span> в <?php the_title(); ?>:</h2>

		<?php
			$venue_cache_key = 'gigsbot_venue_web_v2_' . md5($sql_title);
			$venue_data = get_transient($venue_cache_key);
			if ($venue_data === false) {
				$vresp = wp_remote_get('https://api.tcket.ru/api/venue_web?token=gigsbot2026&venue=' . urlencode($sql_title) . '&page=1&per_page=50', ['timeout' => 8]);
				$venue_data = modernrock_concerts_response($venue_cache_key, $vresp, HOUR_IN_SECONDS * 3, ['concerts' => [], 'total' => 0]);
			}
			$venue_concerts = $venue_data['concerts'];

			$venue_internal_url = function($item) {
				global $wpdb;
				$artist_slug = sanitize_title($item['artist']);
				$post_exists = $wpdb->get_var($wpdb->prepare(
					"SELECT ID FROM wp_posts WHERE post_name = %s AND post_status = 'publish' AND post_type = 'post' LIMIT 1",
					$artist_slug
				));
				if ($post_exists && function_exists('concert_city_to_slug')) {
					$city_slug = concert_city_to_slug($item['city']);
					$date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $item['date']);
					$ts = strtotime($date_str);
					if ($city_slug && $ts) {
						return home_url('/concert/' . $artist_slug . '-' . $city_slug . '-' . date('Y-m-d', $ts) . '/');
					}
				}
				return $item['url'];
			};

			$venue_get_photo = function($artist, $placeholder) {
				global $wpdb;
				$post = $wpdb->get_row($wpdb->prepare(
					"SELECT ID FROM wp_posts WHERE post_title = %s AND post_status = 'publish' LIMIT 1", $artist));
				if ($post) {
					$tid = get_post_thumbnail_id($post->ID);
					if ($tid) { $img = wp_get_attachment_image_src($tid, 'medium'); if (!empty($img[0])) return $img[0]; }
				}
				return $placeholder;
			};

			$venue_placeholder = 'https://modernrock.ru/wp-content/uploads/2023/07/like-fest.jpg';
			$venue_months = [1=>'января',2=>'февраля',3=>'марта',4=>'апреля',5=>'мая',6=>'июня',7=>'июля',8=>'августа',9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'];
		?>

		<?php if (!empty($venue_concerts)): ?>
		<div class="venue-list">
			<?php foreach ($venue_concerts as $vc):
				$vc_date_str = preg_replace('/\+\d{2}:\d{2}$/', '', $vc['date']);
				$vc_ts = strtotime($vc_date_str);
				$vc_date_fmt = date('j', $vc_ts) . ' ' . $venue_months[(int)date('n', $vc_ts)] . ' ' . date('Y', $vc_ts);
				$vc_url = $venue_internal_url($vc);
				$vc_internal = (strpos($vc_url, home_url()) === 0);
				$vc_rel = $vc_internal ? '' : ' rel="nofollow" target="_blank"';
				$vc_photo = $venue_get_photo($vc['artist'], $venue_placeholder);
			?>
			<div class="venue-card">
				<a class="venue-card-media" href="<?php echo esc_url($vc_url); ?>"<?php echo $vc_rel; ?>>
					<img src="<?php echo esc_url($vc_photo); ?>" alt="<?php echo esc_attr($vc['artist']); ?>" loading="lazy" />
				</a>
				<div class="venue-card-body">
					<div class="venue-card-title"><a href="<?php echo esc_url($vc_url); ?>"<?php echo $vc_rel; ?>><?php echo esc_html($vc['artist']); ?></a></div>
					<div class="venue-card-meta"><?php echo esc_html($vc_date_fmt); ?></div>
					<?php if (!empty($vc['city']) && mb_strtolower($vc['city']) !== mb_strtolower($sql_title)): ?>
					<div class="venue-card-meta"><?php echo esc_html($vc['city']); ?></div>
					<?php endif; ?>
					<?php if ($vc['price']): ?>
					<div class="venue-card-price">билеты от <?php echo number_format($vc['price'], 0, '', ' '); ?> руб.</div>
					<?php endif; ?>
					<a href="<?php echo esc_url($vc_url); ?>"<?php echo $vc_rel; ?> class="venue-card-buy">Купить билет</a>
					<?php if ($vc['source'] === 'ticketland'): ?>
					<div class="venue-card-nofee">✓ Билеты без сервисного сбора</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
			<div class="ticket_no">В ближайшее время событий не запланировано.</div>
		<?php endif; ?>

		<?php endwhile; ?>
		<?php endif; ?>

		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<div class="post_content">
			<br/>
			<?php if (get_post_time() > 1416839400): ?>
				<?php the_content('', true); ?>
			<?php else: ?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
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