$(function(){
	var SelCol = $('#cucolor');
	/*
	if($('input[type="checkbox"]').eq(0).length){
		$('input[type="checkbox"]').styler();  
	}
	*/
	
	if($.cookie('popup') == 1){
		$('#ny_2016, #ny_2016s').hide();
	}
	
	if($('#ny_2016').css('display')=='block'){
		$.cookie('popup', '1', { expires: 1});	
	}
	
	/* вызов формы оверлей */
	$(".btn_pop").click(function(){							
		$(".overlay").fadeIn();
		var form = $(this).attr('rel'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
	});
	/* закрытие формы overlay */
	$(".overlay, .win_popup .close").click(function(){					 
		$('.overlay, .win_popup').fadeOut();
	});	
	
	
	
	
	/* select style */
	if($('#cusize').length){
		var cusize = {
			changedEl: "#cusize",
			visRows: 10,
			scrollArrows: false
		}
		cuSel(cusize);
		
		var cucolor = {
			changedEl: "#cucolor",
			visRows: 10,
			scrollArrows: false
		}
		cuSel(cucolor);
	}
	
	
	$('.amount-input em').click(function(){ // кнопки нестандартные в корзине
		var tclass = $(this).attr('class'), form = $(this).parent().find('form'), inp = form.find('.input-sm');
		if(tclass=='minus'){
			inp.val(inp.val()-1);
		}else{
			inp.val(inp.val()-1+2);
		}
		form.submit();
	});
	
	$('.spoiler .stitle').click(function(){
		var sel = $(this).parent();
		if(sel.find('.stxt').css('display')=='none'){
			sel.addClass('act');
		}else{
			sel.removeClass('act');
		}
	});
	
	/* проверка цветов и смена картинки */
	if(SelCol.length){
		ImgCart();
		var sel = $('#cuselFrame-cucolor');
		var cl = sel.find('.cuselActive').attr('class').split(' ');
		sel.find('.cuselText').attr('id','cu_'+cl[0]);
		//alert(cl);
		$('#cucolor').change(function(){ // мутим смену цветов
			ImgCart();
		});
	}
	
	
	/* мутим табы корзины */
	if($('#msCart').length){
		var step1 = $('.step1'), step2 = $('.step2'), step3 = $('.step3'), st1 = $('.st1'), st2 = $('.st2'), st3 = $('.st3'), radio=$('.radio_icon');
		$('.step-content').hide(); step1.show(); // чтобы без js можно было заказать
		
		radio.click(function(){
			DevInp();
		});
		
		DevInp(); // показать нужные поля для доставки
		
		
		$('#msOrder').submit(function(){ // хитрый пользователь должен быть возвращен назад ))
			//$('input[name=receiver]').val(a+' '+b +' '+c);
			setTimeout(function() {
				if($('.error').eq(0).length){
					st2.addClass('st-active');
					st3.removeClass('st-active');
					step2.fadeIn();
					step3.hide();
				}
			}, 500);
		});
		
		$('#car-step1').click(function(){ // переход на шаг 2
			st1.removeClass('st-active');
			st2.addClass('st-active');
			step1.hide();
			step2.fadeIn();
		});
		
		$('#car-step2').click(function(){ // переход на шаг 3
			$('#payments input').eq(0).parent().parent().show();
			$('#payments input:disabled').parent().parent().hide(); // если кнопка disabled то не показываем
			
			st2.removeClass('st-active');
			st3.addClass('st-active');
			step2.hide();
			step3.fadeIn();
		});
	}
	
});


function DevInp(){
	var inp = $('#deliveries input:checked'), mr = $('#mail_russ'), cm = $('#courier_moscow');
	if(inp.attr('id')=='delivery_1'){
		mr.hide();
		cm.hide();
	}else if(inp.attr('id')=='delivery_2'){
		mr.hide();
		cm.show();
	}else if(inp.attr('id')=='delivery_3'){
		mr.show();
		cm.show();
	}
}

function ImgCart(){
	var nnode = $('#big-img'), SelCol = $('#cucolor').val().toLowerCase().replace(/\s+/g, '');

	for (var i in ChangeImg) {
		var ColDesc = ChangeImg[i].description.toLowerCase().replace(/\s+/g, '');
		//alert(ColDesc+'=='+SelCol);
		if(ColDesc==SelCol){
			nnode.attr('href', ChangeImg[i].url);
			nnode.find('img').attr('src', ChangeImg[i].img);
		}
	}
}


/*

HW Slider - простой слайдер на jQuery. 

Настройки скрипта:

hwSlideSpeed - Скорость анимации перехода слайда.
hwTimeOut - время до автоматического перелистывания слайдов.
hwNeedLinks - включает или отключает показ ссылок "следующий - предыдущий". Значения true или false
SliLinks - включает или отключает показ ссылок "1 2". Значения true или false

Подробнее на http://heavenweb.ru/

*/
(function ($) {
var hwSlideSpeed = 400;
var hwTimeOut = 3000;
var hwNeedLinks = false;
var SliLinks = false;

$(document).ready(function(e) {
	$('.slide').css(
		{"position" : "absolute",
		 "top":'0', "left": '0'}).hide().eq(0).show();
	var slideNum = 0;
	var slideTime;
	slideCount = $("#slider .slide").size();
	var animSlide = function(arrow){
		clearTimeout(slideTime);
		$('.slide').eq(slideNum).fadeOut(hwSlideSpeed);
		if(arrow == "next"){
			if(slideNum == (slideCount-1)){slideNum=0;}
			else{slideNum++}
			}
		else if(arrow == "prew")
		{
			if(slideNum == 0){slideNum=slideCount-1;}
			else{slideNum-=1}
		}
		else{
			slideNum = arrow;
			}
		$('.slide').eq(slideNum).fadeIn(hwSlideSpeed, rotator);
		if(SliLinks){
			$(".control-slide.active").removeClass("active");
			$('.control-slide').eq(slideNum).addClass('active');
		}
		}
if(hwNeedLinks){
var $linkArrow = $('<a id="prewbutton" href="#">&lt;</a><a id="nextbutton" href="#">&gt;</a>')
	.prependTo('#slider');		
	$('#nextbutton').click(function(){
		animSlide("next");
		return false;
		})
	$('#prewbutton').click(function(){
		animSlide("prew");
		return false;
		})
}
	var $adderSpan = '';
	$('.slide').each(function(index) {
			$adderSpan += '<span class = "control-slide">' + index + '</span>';
		});
	if(SliLinks){
		$('<div class ="sli-links">' + $adderSpan +'</div>').appendTo('#slider-wrap');
		$(".control-slide:first").addClass("active");
		$('.control-slide').click(function(){
		
		var goToNum = parseFloat($(this).text());
		animSlide(goToNum);
		});
	}
	var pause = false;
	var rotator = function(){
			if(!pause){slideTime = setTimeout(function(){animSlide('next')}, hwTimeOut);}
			}
	$('#slider-wrap').hover(	
		function(){clearTimeout(slideTime); pause = true;},
		function(){pause = false; rotator();
		});
	rotator();
});
})(jQuery);

