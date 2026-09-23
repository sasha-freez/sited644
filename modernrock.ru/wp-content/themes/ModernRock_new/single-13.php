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
			$venue_page = isset($_GET['concert_page']) && is_scalar($_GET['concert_page']) ? max(1, min(1000, absint($_GET['concert_page']))) : 1;
            $venue_cache_key = 'gigsbot_venue_web_v3_' . md5($sql_title . ':' . $venue_page);
			$venue_data = get_transient($venue_cache_key);
			if ($venue_data === false) {
				$vresp = wp_remote_get('https://api.tcket.ru/api/venue_web?token=gigsbot2026&venue=' . urlencode($sql_title) . '&page=' . $venue_page . '&per_page=50', ['timeout' => 8]);
				$venue_data = modernrock_concerts_response($venue_cache_key, $vresp, HOUR_IN_SECONDS * 3, ['concerts' => [], 'total' => 0]);
			}
			$venue_concerts = $venue_data['concerts'];
            $venue_pages = isset($venue_data['pages']) ? max(1, (int)$venue_data['pages']) : 1;



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
		?>

        <?php if (!empty($venue_data['_modernrock_api_unavailable']) && !empty($venue_concerts)): ?>
            <p class="ticket_no">Не удалось обновить афишу. Показаны последние доступные события.</p>
        <?php endif; ?>
		<?php if (!empty($venue_concerts)): ?>
		<div class="venue-list">
			<?php foreach ($venue_concerts as $vc):
                $vc_date = modernrock_event_date($vc['date']);
                $vc_date_fmt = $vc_date ? $vc_date['label'] : 'Дата уточняется';
                $vc_link = modernrock_event_link($vc);
                $vc_url = $vc_link['url'];
                $vc_rel = $vc_link['internal'] ? '' : ' rel="nofollow noopener" target="_blank"';
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
					<a href="<?php echo esc_url($vc['url']); ?>" rel="nofollow noopener" target="_blank" class="venue-card-buy">Купить билет</a>
					<?php if ($vc['source'] === 'ticketland'): ?>
					<div class="venue-card-nofee">✓ Билеты без сервисного сбора</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php else: ?>
			<div class="ticket_no"><?php
                echo !empty($venue_data['_modernrock_api_unavailable'])
                    ? 'Афиша временно недоступна. Попробуйте немного позже.'
                    : ($venue_page > 1 ? 'На этой странице событий нет.' : 'В ближайшее время событий не запланировано.');
            ?></div>
		<?php endif; ?>


        <?php if ($venue_pages > 1 || $venue_page > 1): ?>
            <nav class="venue-pagination" aria-label="Страницы афиши">
                <?php if ($venue_page > $venue_pages): ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>">К началу афиши</a>
                <?php endif; ?>
                <?php echo paginate_links([
                    'base' => str_replace('999999999', '%#%', esc_url(add_query_arg('concert_page', 999999999, get_permalink()))),
                    'format' => '', 'current' => min($venue_page, $venue_pages), 'total' => $venue_pages,
                    'prev_text' => '← Назад', 'next_text' => 'Далее →',
                ]); ?>
            </nav>
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