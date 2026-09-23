<?php get_header(); ?>
<div class="block_left">
	<?php include('sn_breadcrumbs.php'); ?>
	<h1 class="h1">Все концерты - ЕКБ</h1>

	<div class="pagination"><?php if(function_exists('wp_pagenavi')){ wp_pagenavi();}?></div>
</div>

<aside class="block_right aligned-sidebar">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_subscribe.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_recommend.php'); ?>
</aside>
<?php get_footer(); ?>