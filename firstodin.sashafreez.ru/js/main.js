$(function(){


	$('.b_contact .btn_pop').hover(function(){
		var cl=$(this).attr('rel');
		$('.'+cl[1]+cl[2]).addClass('active');
	}, function(){
		var cl=$(this).attr('rel');
		$('.'+cl[1]+cl[2]).removeClass('active');
		
	});
	
	if($(".pikame2").length){
		$(".pikame2").PikaChoose({carousel:true,carouselOptions:{wrap:'circular'}});
	}

    addthis.layers({
	'theme' : 'transparent',
	'share' : {
	  'position' : 'left',
	  'numPreferredServices' : 5
	},
	});
	
	/*

	 addthis.layers({
	'theme' : 'transparent',
	'share' : {
	  'position' : 'left',
	  'numPreferredServices' : 5
	},  
	'whatsnext' : {},  
	'recommended' : {} 
	});
	*/
	


	$('.menu li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);	

	$('.nav_slider li a').click(function(){
		var t=$(this), attr = t.attr('rel');
		$('.slider_show .item').hide();
		$('.nav_slider li').removeClass('active');
		t.parent().addClass('active');
		$(attr).fadeIn();
	});
	
	$(".btn_pop").click(function(){						
		$(".overlay").fadeIn();
		var form = $(this).attr('rel'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
	});
	$(".overlay, .form_popup .close").click(function(){					 
		$('.overlay, .form_popup, .tip').fadeOut();
	});	
	
	
	$('.shahmatka .kub').hover(
		function(e){
			e.preventDefault();
			$(this).find('.info_pop').fadeIn();
		},
		function(e){
			e.preventDefault();
			$(this).find('.info_pop').stop().fadeOut();
		}
	);
	
});		
	
$(function(){
		   
		$(".form").submit(function() {// обрабатываем отправку формы	s				  
			var fname = $(this).find('input[name=name]'),
			fphone = $(this).find('input[name=phone]'),
			fmail = $(this).find('input[name=mail]'),
			fmess=$(this).find('textarea[name=mess]'), a=0,b=0,c=0,d=0;
			
			if($(this).find('textarea[name=mess]').length){}
				if(fname.val()=='Введите имя: *' || !fname.val()){
					fname.parent().addClass('error');a=1;
				}else{
					fname.parent().removeClass('error');a=0;	
				}
				
				if(fphone.val()=='Введите телефон: *' || !fphone.val()){
					fphone.parent().addClass('error');b=1;
				}else{
					fphone.parent().removeClass('error');b=0;
				}
				
				if(fmail.length){
					if(!isValidEmailAddress(fmail.val())){
						fmail.parent().addClass('error');c=1;	
					}else{
						fmail.parent().removeClass('error');c=0;
					}
				}
				
				if(fmess.length){
					if(fmess.val()=='Введите вопрос: *' || !fmess.val()){
						fmess.parent().addClass('error');d=1;
					}else{
						fmess.parent().removeClass('error');d=0;
					}
				}
			if(a==1 || b==1 || c==1 || d==1){
				fname.focus();
				return false;
			}
			else{return true;}
		})
		
	});

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
    }
	
function validate_form ()
{
	valid = true;
	alert_text = "";

		if ( document.reserveform.name.value == "" )
		{
				alert_text = "Пожалуйста, введите данные в поле ФИО." ;
				valid = false;
		}
		
		if ( document.reserveform.phone.value == ""  )
		{
				alert_text = alert_text + "\n\rПожалуйста, введите данные в поле Телефон." ;
				valid = false;
		}

		if (alert_text != "") { alert(alert_text); }
		return valid;
}	
	