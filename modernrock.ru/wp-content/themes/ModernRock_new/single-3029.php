<?php get_header(); ?>
<?php $date = new DateTime(); // текущая дата ?>
<link rel="stylesheet" href="/css/media_inner.css" type="text/css" media="all" />
<script type="text/javascript" src="/lightbox/js/lightbox-2.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="/lightbox/css/lightbox.css"/>
<?php include('sn_breadcrumbs.php'); ?>
<?php 
	$grad=get_post_meta(get_the_ID(), 'grad', true);
	$large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	if ($large[0]=='') $large[0]='/wp-content/uploads/2012/11/small_'.get_post_meta(get_the_ID(), 'attached_img', true);
?>

<div class="sounds_album">
	<div class="wrap" style="
		<?php echo '
			background: -webkit-linear-gradient('.$grad.');
			background: -moz-linear-gradient('.$grad.');
			background: -ms-linear-gradient('.$grad.');
			background: -o-linear-gradient('.$grad.');
			background: linear-gradient('.$grad.');
		';?>
	">
	
		<div class="img">
			<img src="<?php echo kama_thumb_src('w=320&h=320',$large[0]);?>" width="320" height="320" alt="<?php the_title();?>" />
			<span class="mr_sounds"><img src="/images/mr_sounds.png" width="150" /></span>
		</div>
		<div class="desc">
			<div class="wr">
				<div class="kname"><?php echo get_post_meta(get_the_ID(), 'group_afisha', true);?> - <?php echo get_post_meta(get_the_ID(), 'album', true);?></div>
				<div class="kgenre"><?php echo get_post_meta(get_the_ID(), 'genre', true);?></div>
				<div class="kdate">Дата выхода:
					<?php echo date('d',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> <?php echo date_gigs(get_post_meta(get_the_ID(), 'data_afisha', true),0); ?> <?php echo date('Y',strtotime(get_post_meta(get_the_ID(), 'data_afisha', true))); ?> г.
				</div>
			</div>
			<div class="player">
				<?php echo get_post_meta(get_the_ID(), 'code_player', true);?>
			</div>
		</div>
	</div>
</div>
<div class="block_left">
	<div class="bdetails d_sounds">
		<?php the_content('',true); ?>
	</div>
	
	<?php include('sn_comments.php'); ?>
</div>
<aside class="block_right">
	<?php include('sn_banners_r1.php'); ?>
	<?php include('sn_banners_r2.php'); ?>
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_others_news.php'); ?>
	<?php include('sn_subscribe.php'); ?>
</aside>

<?php get_footer(); ?>