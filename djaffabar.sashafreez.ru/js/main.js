$(function(){
	/* меню hover */
	$('#tmenu li').hover(
		function () {$('ul', this).show();},
		function () {$('ul', this).hide();}
	);	

	/* меню блюд, табы */
	$('#tm_nav li a').click(function(e){
		e.preventDefault();
		t = $(this), href = $(this).attr('href');
		if(href=='#all'){
			$('.tab_content').stop().fadeIn().addClass('tactive');
		}else{
			$('.tab_content').removeClass('tactive').hide();
			$(href).stop().fadeIn().addClass('tactive');
		}
		
		$('#tm_nav .active').removeClass('active');
		t.parent().addClass('active');
		
	});
	
	/* валидация */
	$(".sform").submit(function() {// обрабатываем отправку формы				  
		var fphone = $(this).find('input[name=phone]'),
		fname = $(this).find('input[name=name]'),
		fmess =$(this).find('textarea[name=mess]'), a=0,b=0;
		
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
			
		if(b==1 || a==1){
			fname.focus();
			return false;
		}
		else{return true;}
	});
	
	/* для всплывашек */
	$(".btn_pop").click(function(e){	
		e.preventDefault();
		$(".overlay").fadeIn();
		var form = $(this).attr('href'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
	});
	$(".overlay, .form_popup .close").click(function(){					 
		$('.overlay, .form_popup, .tip').fadeOut();
	});	
	
	/* Главные карусели */
	var ev_carousel = $("#ev_carousel"), ev_sliders = $("#ev_sliders");
	
	/* события */
	if(ev_carousel.length){
		ev_carousel.owlCarousel({
			navigation : true,
			loop:true,
			items : 3, 
			navigationText : ["назад", "вперед"],
			responsive:{
				0:{
					items:1
				},
				700:{
					items:2
				},
				1000:{
					items:3
				}
			}
			
		});
	}
	/* Главый слайдер */
	if(ev_sliders.length){
		ev_sliders.owlCarousel({
			navigation : true,
			loop:true,
			autoplay:true,
			autoplayTimeout:2700,
			autoplayHoverPause:true,
			//animateOut: 'fadeOut',
			animateOut: 'slideOutDown',
			animateIn: 'flipInX',
			items : 1, 
			itemsDesktop : false,
			itemsDesktopSmall : false,
			itemsTablet: false,
			itemsMobile : false,
			navigationText : ["назад", "вперед"],
		});
	}
	
	if($('#datetimepicker_mask').length){
		$.datetimepicker.setLocale('ru');
		$('#datetimepicker_mask').datetimepicker({
			formatTime:'H:i',
			formatDate:'d.m.Y',
			mask:'9999.19.39 29:59'
		});
	}
});

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}