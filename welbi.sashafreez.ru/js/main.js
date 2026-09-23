$(function(){
	/* всплывающая форма */
	$(".vpopup").click(function(){
		$(".overlay").fadeIn();
		var t = $(this), form = t.attr('data-popup'), fh = ($(form).height() + 30) / -2, ft = t.offset().top - 392;
		$(form).fadeIn();
		$("body").addClass('noscroll');
		
	});
	
	/* закрытие формы по клику */
	$(".overlay, .b_popup .close, #pop_menu li a").click(function(){
		$('.overlay, .b_popup').fadeOut();
		$("body").removeClass('noscroll');
	});	
	
	$('#question_tabs li').eq(0).addClass('active');
	$('.tab-answer').eq(0).addClass('active');
	
	$('#question_tabs span').on('click',function(){
		var t = $(this), tab = t.attr('data-quest');
		t.parent().parent().find('.active').removeClass('active');
		$('.tab-answer.active').removeClass('active');
		t.parent().addClass('active');
		$('[data-tab="'+tab+'"]').addClass('active');
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
			scrollTop: $(id).offset().top - 47
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
	var сarousel1 = $("#cl_carousel"), сarousel2 = $("#gal_carousel");
	if(сarousel1.length){
		сarousel1.owlCarousel({
			singleItem : true,
			slideSpeed : 500,
			navigation: false,
			pagination: true,
			autoHeight : true,
			responsiveRefreshRate: 200
		});
	}
	if(сarousel2.length){
		сarousel2.owlCarousel({
			singleItem : true,
			slideSpeed : 500,
			navigation: false,
			pagination: true,
			autoHeight : true,
			responsiveRefreshRate: 200
		});
	}
	
	/* клик на логотип внутренняя страница */
	
	$('#b_clients .row').on('click',function(){
		var t = $(this), tab = t.attr('data-client'), img = t.find('img');

		if(t.hasClass('active')){
			t.removeClass('active');
			img.attr('src',img.attr('data-src'));
		}else{
			t.addClass('active');
			img.attr('src',img.attr('data-active'));
		}
		var row_act = t.parent().find('.active');
		
		if(row_act.length){
			$('.section_details .item').hide();
			$(row_act).each(function(){
				tab = $(this).attr('data-client');
				$('[data-good='+tab+']').show();
			});
		}

	});	
	
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


