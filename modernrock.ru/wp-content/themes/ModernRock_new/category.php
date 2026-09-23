<?php
	$cat_parent = get_category($cat);
	$cat_parent = $cat_parent->category_parent;
	
	if(in_category(176)) {
		include 'category-stati.php'; 
	}
	elseif ($cat_parent==7){
		include 'category-7.php';
	}
	elseif ($cat_parent==6){
		include 'category-6.php';
	}elseif ($cat_parent==2872){
		include 'category-2872.php';
	}elseif ($cat_parent==3030){
		include 'category-3030.php';
	}else{
?>

<?php get_header(); ?>
<div class="block_left">

</div>

<aside class="block_right">
	<?php include('sn_adv_google.php'); ?>
	<?php include('sn_banners_r.php'); ?>
</aside>

<?php get_footer(); ?>

<?php }?>