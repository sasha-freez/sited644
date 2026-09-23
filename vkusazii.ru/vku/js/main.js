$(function(){
	$('#menu li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);	
});

$(function(){
	$('#menu_sub li').hover(
		function () {$('ul', this).show();}, 
		function () {$('ul', this).hide();}
	);	
});