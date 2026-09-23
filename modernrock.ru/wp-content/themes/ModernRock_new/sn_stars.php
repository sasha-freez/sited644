<?php 
$stars='';
$star = get_post_meta(get_the_ID(), 'rating', true) / 2;

for($i=1; $i<=5; $i++){
	$k=$star-$i;
	if($k >= 0){
		$class='v_act';
	}else if($k == -0.5){
		$class='v_half';
	}else{
		$class='';
	}
	$stars .='<span class="vote '.$class.'"><span></span></span>';
}
?>
<div class="stars"><?php echo $stars;?></div>