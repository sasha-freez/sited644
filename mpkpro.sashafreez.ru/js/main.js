
$(function(){
	/* меню hover */
	$('.tmenu ul li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);
	
	$(".show_feedback").click(function(){
		$(this).parent().parent().hide();
	});
	/* tabs */
	$('.tab-nav a').click(function(e){
		e.preventDefault();
		var ts = $(this), tc = ts.attr('href');
		ts.closest('.tab-nav').find('.active').removeClass('active');
		ts.closest('.tabs').find('.tab-content').removeClass('active');
		if(tc == '#tt2'){
			$('#form_calc').addClass('calc_details');
		}else{
			$('#form_calc').removeClass('calc_details');
		}
		ts.parent().addClass('active');
		$(tc).addClass('active');
	});
	
	$('.land_switch').click(function(){
		$(this).find('ul').show();
	});
	
	/* для всплывашек */
	$(".btn_pop").click(function(){							
		$(".overlay").fadeIn();
		var form = $(this).attr('rel'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
	});
	$(".overlay, .form_popup .close").click(function(){					 
		$('.overlay, .form_popup, .tip').fadeOut();
	});	
	
$(".sasha_validate").submit(function() {
	var fphone = $(this).find('input[name=phone]'),
	fname = $(this).find('input[name=name]'),
	fmess =$(this).find('textarea[name=mess]'), 
	fmail = $(this).find('input[name=mail]'),
	a=0,b=0,c=0;
	
	if(!fname.val()){
		fname.parent().addClass('error');a=1;
	}else{
		fname.parent().removeClass('error');a=0;
	}
	
	if(!fphone.val()){
		fphone.parent().addClass('error');b=1;
	}else{
		fphone.parent().removeClass('error');b=0;
	}
	
	if(!isValidEmailAddress(fmail.val())){
		fmail.parent().addClass('error');c=1;
		fmail.next('.er').show();
	}else{
		fmail.parent().removeClass('error');c=0;
		fmail.next('.er').hide();
	}
		
	if(b==1 || a==1 || c==1){
		fname.focus();
		return false;
	}
	else{return true;}
});
	
});

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}
$(function(){
	/* carousel */
	$(".carousel .prev").click('click',function(){ 
		var carusel = $(this).closest('.carousel');
		left_carusel(carusel, 220);
	});
	
	$(".carousel .next").click('click',function(){ 
		var carusel = $(this).closest('.carousel');
		right_carusel(carusel, 220);
	});
	
	/* jCarouselLite */
	if($('#reviews ').length){
		$("#reviews .carousel").jCarouselLite({
			btnNext: "#reviews .next",
			btnPrev: "#reviews .prev",
			circular: true,
			visible: 1 
		});
		
		$('.reviews .txt').jScrollPane(
			{
				verticalDragMinHeight: 22,
				verticalDragMaxHeight: 22
			}
		
		);
	}
});


/*
HW Slider - простой слайдер на jQuery. 
*/
(function ($) {
var hwSlideSpeed = 800;
var hwTimeOut = 3500;
var hwNeedLinks = true;
var SliLinks = true;

$(document).ready(function(e) {
	$('.slide').css({"position" : "absolute", "top":'0', "left": '0'}).hide().eq(0).show();
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
var $linkArrow = $('<div class="container"><a id="prewbutton" href="#">&lt;</a><a id="nextbutton" href="#">&gt;</a></div>')
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

/* Карусель */
function left_carusel(carusel, itemWidth){
   var block_width = $(carusel).find('li').width() + -itemWidth;
   $(carusel).find("ul li").eq(-1).clone().prependTo($(carusel).find("ul")); 
   $(carusel).find("ul").css({"left":"-"+block_width+"px"}); 
   $(carusel).find("ul").animate({left: "0px"}, itemWidth); 
   $(carusel).find("ul li").eq(-1).remove(); 
}
function right_carusel(carusel, itemWidth){
   var block_width = $(carusel).find('li').width() + -itemWidth;
   $(carusel).find("ul").animate({left: "-"+ block_width +"px"}, itemWidth); 
   setTimeout(function () { 
	  $(carusel).find("ul li").eq(0).clone().appendTo($(carusel).find("ul")); 
	  $(carusel).find("ul li").eq(0).remove(); 
	  $(carusel).find("ul").css({"left":"0px"});
   }, 100);
}
