$(function(){
	/* menu slidebar */
	var imenu = $('#menu_toggle');
	var active_class = 'slidebar-act';

	imenu.click(function(){
		if ($('body').hasClass(active_class)) {
			$('html, body').css({
				overflow: 'auto',
				height: 'auto'
			});
			$('body').removeClass(active_class);
		} else {
			$('html, body').css({
				overflow: 'hidden',
				height: $(window).height()
			});
			$('body').addClass(active_class);
		}
	});
	$('#hide_sidebar').click(function(){
		imenu.trigger('click');
	});

	var sidebar = document.querySelector('body');
	var started = false, x, y, newX, newY;

	sidebar.addEventListener('touchstart', function(event) {
		if ($(sidebar).hasClass(active_class) && event.changedTouches.length == 1) {
			x = event.changedTouches[0].pageX;
			y = event.changedTouches[0].pageY;
			
			sidebar.addEventListener('touchmove', function(event) {
				newX = event.changedTouches[0].pageX;
				newY = event.changedTouches[0].pageY;
				if ((Math.abs(x - newX) >= Math.abs(y - newY)) && (x - newX) > 0 && event.changedTouches.length == 1){
					started = true;
				}
			}, false);

			sidebar.addEventListener('touchend', function(event) {
				if (started && event.changedTouches.length == 1) {
					$('html, body').css({
						overflow: 'auto',
						height: 'auto'
					});
					$('body').removeClass(active_class);
					started = false;
				}
			}, false);
		}
	}, false);
	
	if ($('body').hasClass(active_class)) {
		$(window).resize(function() {
			$('html, body').css({
				overflow: 'hidden',
				height: $(window).height()
			});
		});
	}
	
	/* Скрипт всплывающего окна */
	$(".form_pop").click(function(){							
		$(".overlay").fadeIn();
		var $form = $(this).attr('data-popup'), fh = ($(form).height() + 30) / -2;
		$($form).css({'margin-top':fh+'px'}).fadeIn();
	});
	
	/* Закрыть всплывающее окно */
	$(".overlay, .close_popup").on('click', function(){						 
		$('.overlay, .form_popup, .tip').fadeOut();
	});
	
	/* обрабатываем отправку формы */ 
	$(".validate").on('submit',function() {
		var fname = $(this).find('input[name=name]'),
			fphone = $(this).find('input[name=phone]'),
			fmail = $(this).find('input[name=mail]'),
			fmess = $(this).find('textarea[name=mess]'), k = 0;
		
		if(!fname.val()){
			fname.addClass('error'), k+=1;
		}else{
			fname.removeClass('error');	
		}
		
		if(!fphone.val()){
			fphone.addClass('error'), k+=1;
		}else{
			fphone.removeClass('error');
		}
		
		if(fmail.length){
			if(!isValidEmailAddress(fmail.val())){
				fmail.addClass('error'), k+=1;	
			}else{
				fmail.removeClass('error');
			}
		}
		
		if(fmess.length){
			if(!fmess.val()){
				fmess.addClass('error'), k+=1;
			}else{
				fmess.removeClass('error');
			}
		}
		if (k > 0){
			return false;
		}
	});
});

/* Функция валидации e-mail: */
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}