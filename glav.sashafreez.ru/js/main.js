


$(function(){
	$('.section_txt img').each(function () {
		$(this).wrap('<a href="' + this.src + '" data-lightbox="popup"></a>');
	});
	
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
	
	/* Слайдер */
	var сarousel1 = $("#carusel_goods");
	
	if(сarousel1.length){
	  сarousel1.owlCarousel({
		items : 4,
		slideSpeed : 500,
		navigation: true,
		pagination: false,
		autoHeight : true,
		responsiveRefreshRate: 200
	  });
	}
	
	$('#m_icon').on('click',function(e){
		var t = $(this), m = $('#bl_menu nav');
		if(t.hasClass('act')){
			t.removeClass('act');
			m.slideUp();	
		}else{
			t.addClass('act');
			m.slideDown();
		}
		
	});
	
	$('#m_cat').on('click',function(e){
		var t = $(this), m = $('#bl_mcat'), k = $('#bl_menu');
		//k.hide();
		if(t.hasClass('act2')){
			t.removeClass('act2');
			m.slideUp();
		}else{
			t.addClass('act2');
			m.slideDown();	
		}
		
		if(k.css('display') == 'block'){
			$('#m_icon').trigger('click');
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