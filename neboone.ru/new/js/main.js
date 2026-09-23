$(function(){
	$('input[type="checkbox"], select').styler();  
	
	$('.spoiler .stitle').click(function(){
		var sel = $(this).parent();
		if(sel.find('.stxt').css('display')=='none'){
			sel.addClass('act');
		}else{
			sel.removeClass('act');
		}
	});
	
	$('.radio_icon label').click(function(){
		var ts = $(this);
		if(ts.find('input').is(':checked')){
			ts.addClass('act');
		}else{
			$('.radio_icon label').removeClass('act');
		}
	});
	
});

