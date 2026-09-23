<?php get_header(); ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	
	<div class="bdetails d_interview">
		<?php wp_reset_query(); if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		<?php
			$city=get_post_meta(get_the_ID(), 'city', true);
			$address=get_post_meta(get_the_ID(), 'address', true);
			$phone=get_post_meta(get_the_ID(), 'phone', true);

			$text = !empty($city) ? '<p class="city"><strong>Город:</strong>  '.$city.'</p>' : '';
			$text .= !empty($address) ? '<p class="address"><strong>Адрес:</strong>  '.$address.'</p>' : '';
			$text .= !empty($phone) ? '<p class="phone"><strong>Телефон:</strong>  '.$phone.'</p>' : '';
		?>
		<h1><?php the_title();?></h1>
		<?php include('sn_social.php'); ?>
		<div class="club_param">
			<?php echo $text ?>
		</div>

		<div class="post_content">
			<?php if(get_post_time() > 1416839400): // &gt; 21.11.2014 ?>
				<?php the_content('',true); ?>
			<?php else:?>
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