<?php get_header(); ?>
<div class="block_left">
	<h1 class="h1">Ошибка 404</h1>
	<p>Страница не найдена. Перейти <a href="<?php echo esc_url(home_url('/')); ?>">на главную</a></p>
</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>	

<?php get_footer(); ?>