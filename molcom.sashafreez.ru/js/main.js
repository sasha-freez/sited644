$(function(){
	/* всплывающая форма */
	$(".vpopup").click(function(){
		$(".overlay").fadeIn();
		var self = $(this), form = self.attr('data-popup'), fh = ($(form).height() + 30) / -2, ft = self.offset().top - 392, fmt = $('#fast_menu').offset().top;
		$(form).fadeIn();
		$("body").addClass('noscroll');
		
	});
	
	/* закрытие формы по клику */
	$(".overlay, .b_popup .close, #pop_menu li a").click(function(){
		$('.overlay, .b_popup').fadeOut();
		$("body").removeClass('noscroll');
	});	
	
	/* микро шапка */
	$(window).scroll(function() {
		var top = $(document).scrollTop(), head = $("#fast_menu");
		if (top < 900) {
			head.removeClass('fast_scroll');
		}
		else {
			head.addClass('fast_scroll');
		}
	});
	
	/* плавающая шапка скроллится до нужного меню */
	$('a[data-href]').click(function(){
		var t = $(this), id = t.attr('data-href');
		$('.fix_act').eq(0).removeClass('fix_act');
		$(t).parent().addClass('fix_act');
		$('html,body').animate({
			scrollTop: $(id).offset().top - 195
		}, 800);
	});
	
	/* Нестандартный checkbox */
	$('input[type=checkbox]:checked').parent().addClass('check_act');
	$('.check_js').on('click', function(){
		if($(this).find('input').is(':checked')){
			$(this).addClass('check_act');
		}else{
			$(this).removeClass('check_act');
		}
	});

	/* чтобы случайно после перезагрузки ajax функция не оставила нас на текущей странице page */
	if(parseGetParams().page){
		window.location.href='/';
	}

	/* фиксированная шапка */
	$(window).scroll(function() {
		var top = $(document).scrollTop(), head = $("#headfix");
		if (top < 50) {
			head.removeClass('headmini');
		}
		else {
			head.addClass('headmini');
		}
	});

	/* плавающая шапка скроллится до нужного меню */
	$('#menu a').click(function(){
		var t = $(this), id = t.attr('data-href');
		$('.menu ul .active').eq(0).removeClass('active');
		$(t).parent().addClass('active');
		$('html,body').animate({
			scrollTop: $(id).offset().top - 60
		}, 800);
	});
	
	/* Клик по overlay */
	$('.overlay').click(function(){
		$(this).fadeOut();
		$('.form_popup').fadeOut();
	});
	
	/* Слайдер */
	var сarousel1 = $("#cl_carousel"), сarousel2 = $("#awards_carousel");
	if(сarousel1.length){
	  сarousel1.owlCarousel({
		singleItem : true,
		slideSpeed : 500,
		navigation: false,
		pagination: true,
		autoHeight : true,
		responsiveRefreshRate: 200
	  });
	  
	  сarousel2.owlCarousel({
		singleItem : true,
		slideSpeed : 500,
		navigation: true,
		pagination: false,
		autoHeight : true,
		responsiveRefreshRate: 200
	  });
	}
});

/* Parallax Scrolling */
$(function(){
    $('*[data-type="background"]').each(function(){
        var $bgobj = $(this); // создаем объект
        $(window).scroll(function() {
            var yPos = -($(window).scrollTop() / $bgobj.data('speed')); // вычисляем коэффициент 
            // Присваиваем значение background-position
            var coords = 'center '+ yPos + 'px';
            // Создаем эффект Parallax Scrolling
            $bgobj.css({ backgroundPosition: coords });
        });
    });
});	

/* Обрабатываем отправку формы */
$(function(){
	$(".form").submit(function() {		  
		var fname = $(this).find('input[name=name]'),fmail = $(this).find('input[name=mail]'), fmess=$(this).find('textarea[name=mess]'), b=0, c=0;
			if(!fname.val()){
				fname.addClass('error'); b=1;
			}else{
				fname.removeClass('error');b=0;
			}
			
			if(fmail.length){
				if(!isValidEmailAddress(fmail.val())){
					fmail.addClass('error');c=1;	
				}else{
					fmail.removeClass('error');c=0;
				}
			}
		if(b==1 || c==1){
			fname.focus();
			return false;
		}
		else{
			return true;
		}
	});

});

function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}

/* работа с GET */
function parseGetParams() { 
   var $_GET = {}; 
   var __GET = window.location.search.substring(1).split("&"); 
   for(var i=0; i<__GET.length; i++) { 
      var getVar = __GET[i].split("="); 
      $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1]; 
   } 
   return $_GET; 
} 

/*
 $(function(){
	if (navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/)) {
	  $('#ios-notice').removeClass('hidden');
	  $('.parallax-container').height( $(window).height() * 0.5 | 0 );
	} else {
	  $(window).resize(function(){
		var parallaxHeight = Math.max($(window).height() * 0.7, 200) | 0;
		$('.parallax-container').height(parallaxHeight);
	  }).trigger('resize');
	}
});
*/