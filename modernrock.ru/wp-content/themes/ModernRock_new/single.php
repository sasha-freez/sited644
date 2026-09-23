<?php
	$cat_parent = get_the_category();
	$cat_parent = $cat_parent[0]->category_parent;
	
	if(in_category(3)) {
		include 'single-3.php'; 
	}
	else
    if(in_category(4)) {
        include 'single-4.php'; 
	}
	else
    if(in_category(5)) {
        include 'single-5.php'; 
	}
	else
	if(in_category(23)) {
		include 'single-23.php'; 
	}
	else
	if ($cat_parent==6){
		include 'single-6.php';
	}
	else
	if(in_category(7) || $cat_parent==7) {
		include 'single-7.php'; 
	}
	else
	if(in_category(8)) {
		include 'single-8.php'; 
	}
	else
	if(in_category(9)) {
		include 'single-9.php'; 
	}
	else
	if(in_category(10)) {
		include 'single-10.php'; 
	}
	else
	if(in_category(12)) {
		include 'single-12.php'; 
	}
	else
	if(in_category(13)) {
		include 'single-13.php'; 
	}
	else
	if(in_category(97)) {
		include 'single-all.php';
	}
	else
	if(in_category(176)) {
		include 'single-stati.php';
	}
	else
	if(in_category(1323)) {
		include 'single-1323.php';
	}
	else
	if(in_category(2872) || $cat_parent==2872) {
		include 'single-2872.php'; 
	}else
	if(in_category(3029) || $cat_parent==3029) {
		include 'single-3029.php'; 
	}else
	if(in_category(3030) || $cat_parent==3030) {
		include 'single-3030.php'; 
	}
	else{
        include 'single-all.php';
    }
?>
