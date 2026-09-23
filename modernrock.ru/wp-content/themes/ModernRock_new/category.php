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
include __DIR__ . '/archive-list.php';
}
