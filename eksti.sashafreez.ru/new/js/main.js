$(function(){
	/* Слайдер */
	var сarousel1 = $("#t_carousel");
	if(сarousel1.length){
	  сarousel1.owlCarousel({
		singleItem : true,
		autoPlay: 6000,
		slideSpeed : 500,
		navigation: false,
		pagination: true,
		autoHeight : true,
		responsiveRefreshRate: 200,
		transitionStyle : "fade"
	  });
	}
	
	
	/* Нестандартный checkbox */
	$('input[type=checkbox]:checked').parent().addClass('check_act');
	$('.check_js').on('click', function(){
		if($(this).find('input').is(':checked')){
			$(this).addClass('check_act');
		}else{
			$(this).removeClass('check_act');
		}
	});
	
	/* menu hover */
	$('#lhmenu li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);	
	
	/* textarea click */
	$('textarea[name=mess], .order_online textarea').click(function(){
		$(this).val('');								   								   
	});
	
	
	/* всплывающее окно */
	$(".btn-pop").click(function(e){	
		e.preventDefault();
		$(".overlay").fadeIn();
		var form = $(this).attr('rel'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();

	});
	
	$(".overlay, .form_popup .close").click(function(){				 
		$('.overlay, .form_popup, .tip').fadeOut();
		$('#js_tel').hide();
	});
	
	$('#feedback_form_show').click(function(e){
		e.preventDefault();
		$(this).parent().parent().hide();
		$(this).parent().parent().parent().find('form').show();
	});
	
	$('.overlay').click(function(){
		$(this).fadeOut();
		$('.form_popup').fadeOut();
	});
});



$(function(){
	$(".form").submit(function() {// обрабатываем отправку формы				  
		var fphone = $(this).find('input[name=phone]'),
		fname = $(this).find('input[name=name]'),
		fmess =$(this).find('textarea[name=mess]'), a=0,b=0;
		
		if(fname.val()=='имя' || !fname.val()){
			fname.parent().addClass('error');a=1;
		}else{
			fname.parent().removeClass('error');a=0;
		}
		
		if(fphone.val()=='телефон / e-mail' || !fphone.val()){
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
