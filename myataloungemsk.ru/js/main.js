$(function(){
	/* menu hover */
	$('#menu li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);
	
	/* всплывающее окно */
	$(".btn-pop").on('click', function(e){
		e.preventDefault();
		$(".overlay").fadeIn();
		var t = $(this), form = t.attr('data-popup'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
		if(t.attr('data-good')){
			$(form).find('.goods_d').html('<span class="gname">'+t.attr('data-good')+'</span> за <span class="gprice">'+t.attr('data-price')+'</span>');
			$(form).find('input[name=gname]').val(t.attr('data-good'));
			$(form).find('input[name=gprice]').val(t.attr('data-price'));
		}
	});
	
	/* Скроллится до нужного меню */
	$('a[data-href]').click(function(e){
		e.preventDefault();
		var t = $(this), id = t.attr('data-href');
		$('html,body').animate({
			scrollTop: $(id).offset().top -20
		}, 800);
	});
	
	
	$(".overlay, .form_popup .close").on('click',function(){				 
		$('.overlay, .form_popup, .tip').fadeOut();
	});
	
	/* repeat form */
	$('#feedback_form_show').on('click',function(e){
		e.preventDefault();
		$(this).parent().parent().hide();
		$(this).parent().parent().parent().find('form').show();
	});
	
	$('.overlay').on('click',function(){
		$(this).fadeOut();
		$('.form_popup').fadeOut();
	});
	
	
	
	/* menu slidebar */
	var imenu = $('#b_menu');
	var menu_act = 'menu_m_act';

	function ToggleMenu(){
		if ($('body').hasClass(menu_act)) {
			$('html, body').css({
				overflow: 'auto',
				height: 'auto'
			});
			$('body').removeClass(menu_act);
		} else {
			$('html, body').css({
				overflow: 'hidden',
				height: $(window).height()
			});
			$('body').addClass(menu_act);
		}
	}
	
	
	imenu.click(function(e){
		e.preventDefault();
		ToggleMenu();
	});
	$('#m_hide').click(function(){
		ToggleMenu();
	});
	
	$('.m_menu a').on('click',function(){
		ToggleMenu();
	});

	var sidebar = document.querySelector('body');
	var started = false, x, y, newX, newY;

	sidebar.addEventListener('touchstart', function(event) {
		if ($(sidebar).hasClass(menu_act) && event.changedTouches.length == 1) {
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
					$('body').removeClass(menu_act);
					started = false;
				}
			}, false);
		}
	}, false);

	$(window).resize(function() {
		if ($('body').hasClass(menu_act)) {
			$('html, body').css({
				overflow: 'hidden',
				height: $(window).height()
			});
		}
	});
	
});

$(function(){
	$(".form").submit(function() {// обрабатываем отправку формы				  
		var fphone = $(this).find('input[name=phone]'),
		fname = $(this).find('input[name=name]'),
		fmess = $(this).find('textarea[name=mess]'), a=0,b=0;
		
		if(!fname.val()){
			fname.parent().addClass('error');a=1;
		}else{
			fname.parent().removeClass('error');a=0;
		}
		
		if(!fphone.val()){
			fphone.parent().addClass('error'); b=1;
		}else{
			fphone.parent().removeClass('error');b=0;
		}
		
			
		if(b==1 || a==1){
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
