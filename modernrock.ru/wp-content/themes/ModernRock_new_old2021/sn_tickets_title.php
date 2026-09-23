<? 
$check_title = get_post_meta(get_the_ID(), 'check_title', true);
if($check_title=='1'){
	the_title();
}else{
	echo get_post_meta(get_the_ID(), 'group_afisha', true);
}

 ?>
