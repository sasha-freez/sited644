$(function(){
	addthis.layers({
	'theme' : 'transparent',
	'share' : {
	  'position' : 'left',
	  'numPreferredServices' : 5
	}
	});

	$('.menu li').hover(
		function () {$('ul', this).show(100);}, 
		function () {$('ul', this).hide();}
	);	
});



function showhide(name_id)
{
 var obj=document.getElementById(name_id);
 if(obj.style.display=='none')
  obj.style.display='inline';
 else
  obj.style.display='none';
}

function showin(name_id, name_id2)
{
 var obj=document.getElementById(name_id);
 var obj2=document.getElementById(name_id2);
 if(obj.style.display=='inline', obj2.style.display=='none')
  obj.style.display='inline';
 else
  obj.style.display='inline';
}

function hide(name_id, name_id2)
{
 var obj=document.getElementById(name_id);
 var obj2=document.getElementById(name_id2);
 if(obj.style.display=='inline', obj2.style.display=='none')
  obj.style.display='none';
 else
  obj.style.display='inline';
}


function hideall(name_id, name_id2)
{
 var obj=document.getElementById(name_id);
 var obj2=document.getElementById(name_id2); 
    obj.style.display = 'none';
    obj2.style.display = 'none';
}



$(function(){ 
	$(".form_pop").click(function(){					
		$(".overlay").fadeIn();
		var form = $(this).attr('rel'), fh = ($(form).height() + 30) / -2;
		$(form).css({'margin-top':fh+'px'}).fadeIn();
		
	});
	$(".overlay, .form_popup .close").click(function(){						 
		$('.overlay, .form_popup, .tip').fadeOut();
	});		
 
});




$(function(){ 
	$(".form").submit(function() {// обрабатываем отправку формы	s				  
		var fname = $(this).find('input[name=name]'),
		fphone = $(this).find('input[name=phone]'),
		fmail = $(this).find('input[name=mail]'),
		a=0,b=0,c=0;
		

			if(fname.val()=='¬ведите им€: *' || !fname.val()){
				fname.parent().addClass('error');a=1;
			}else{
				fname.parent().removeClass('error');a=0;	
			}
			
			if(fphone.val()=='¬ведите телефон: *' || !fphone.val()){
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

		if(a==1 || b==1 || c==1){
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
