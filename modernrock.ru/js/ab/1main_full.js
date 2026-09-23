$(document).ready(function(){
	//alert($(window).width());
	
	$("#menu-item-47899 a, #menu-item-68175 a").attr("target","_blank");
	
	$("#menu-item-47899 a").attr("href","http://небо1.рф/");
	$("#menu-item-68175 a").attr("href","https://radio.yandex.ru/author/modernrock");
	
	/* // del for "more null annotation" freeze */
	if($('span[id^=more-]').parent('p').text().length < 1){ 
		$('span[id^=more-]').parent('p').remove();
	}
	if($('.banner_t').text().length < 1){ 
		$('.banner_t').remove();
	}
	
	$('.tonn16').attr('href','http://www.16tons.ru/');
	$('.wm').attr('href','http://www.warnermusic.ru/home');
	$('.sm').attr('href','http://www.sonymusic.ru/ru/home');
	$('.icd').attr('href','http://icecreamdisco.com/');
	$('.pn').attr('href','http://ponominalu.ru/?promote=modernrockru');
	$('.sl').attr('href','http://www.snegiri.ru/');
	$('.pe').attr('href','http://promoend.ru/');
	$('.merc').attr('href','http://merclondon.ru/');
	$('.sts').attr('href','http://www.stopthesilence.ru/');
	$('.pil').attr('href','http://playitloudbooking.com/');
	$('.design_m').attr('href','http://vk.com/mazol500');
	$('.red_club').attr('href','http://red-msk.ru/');

	/* search view freezee */
	$('.search').hover(function(){
		$(this).addClass('s_act');
		$(this).find('.inp').stop().animate({'width':'100%'});
	},function(){
		$(this).find('.inp').stop().animate({'width':'0'});
		$(this).removeClass('s_act');	
	});
	
	/* tabs jquery freezee */
	$('.tabs_s li a').click(function(e){
		e.preventDefault();
		var t=$(this); cl = t.attr('rel'), tc = t.closest('.tabs_s');
		tc.stop().find('li').removeClass('active');
		t.stop().closest('.container').find('.tab-content').hide();
		t.stop().parent().addClass('active');
		$(cl).stop().fadeIn();
		if(t.closest('.b_news').attr('class')=='b_news' && $('.b_news .js-toggle').css('display')=='none'){
			$('.b_news .js-b_arrow').stop().trigger('click');	
		}
	});
	
	/* mrok ipade slide */
	if($('.swiper-container').length){
		var mySwiper = new Swiper('.swiper-container',{
			pagination: '.paginav',
			loop:true,
			grabCursor: true,
			paginationClickable: true
		  })
		  $('.mrok-slide .prev').on('click', function(e){
			e.preventDefault()
			mySwiper.swipePrev()
		  })
		  $('.mrok-slide .next').on('click', function(e){
			e.preventDefault()
			mySwiper.swipeNext()
		  })
	  }
	
	
	$('.event-go .e-users .more a').click(function(){
		$(".event-go .e-users .user.end").toggle();
		if ($(this).html()=='Показать всех'){
			$(this).html('Скрыть');
		}
		else{
			$(this).html('Показать всех');
		}
		return false;
	});
	
	$('.event-go .c-user .status').click(function(){
		if ($('.event-go .c-user .status').attr('user_id')>"0"){
			$.ajax({
				type:"POST",
				url: '/?param=just_concert',
				data: {
					post_id:$('.event-go .c-user .status').attr('post_id'),
					user_id:$('.event-go .c-user .status').attr('user_id')
				},
				success:function(msg){
					if (msg=="true"){
						alert('Спасибо за интерес к концерту.');
						window.location.reload();					
					}
					else
					if (msg=="false"){
						alert('Вы уже указали, что идёте на этот концерт.');
					}
					else{
						alert('Авторизуйтесь.');
					}
				}
			});
		}
		else{
			alert('Авторизуйтесь.');
		}
	});
	
	$('#popup .form .close').click(function(){
		$(this).parent().parent().css("display","none");
		return false;
	});
	
	
	$('.auth a.login').click(function(){
		if ($('.auth #login_user').val()=='false'){
			$("#popup.auth_form").css("display","block");
			$(window).resize();
		}
		else{
			window.location.href=$('.auth #logout').val();
		}
		return false;
	});
	
	$('.city .other_city').click(function(){
		$("#popup.city_select").css("display","block");
		$("#popup .form .city_list #city_input").focus();
		$(window).resize();
		return false;
	});
	
	$("#popup .form .city_list #city_input").keyup(function(){
		var tmp_length=$(this).val();
		tmp_length=tmp_length.length;
		if (tmp_length>3){
			$.ajax({
				type:"POST",
				url: '/?param=city_list',
				data: {
					find:$(this).val()
				},
				success:function(msg){
					$('#popup .form .city_list .result_city_list').html(msg);
					$(window).resize();
				}
			});
		}
	});
	
	$('.pagelist .next_gr, .pagelist .prev_gr').click(function(){
		var class_name=$(this).attr("class");
		
		var next_page=parseInt($('.pagelist #page_num').val())+1;
		var prev_page=parseInt($('.pagelist #page_num').val())-1;
		
		if (next_page>parseInt($('.pagelist #group_pagelist_count').val())){
			next_page=1;
		}
				
		if (prev_page<1){
			prev_page=parseInt($('.pagelist #group_pagelist_count').val());
		}
		
		if (class_name=='next_gr'){
			$('.pagelist #page_num').val(next_page);
		}
		else{
			$('.pagelist #page_num').val(prev_page);
		}

		$.ajax({
			type:"POST",
			url: '/?param=group_list',
			data: {
				pages:parseInt($('.pagelist #page_num').val())
			},
			success:function(msg){
				$('.group-list ul').html(msg);
				$('.pagelist span strong').html($('.pagelist #page_num').val());
				//alert(msg);
			}
		});
		return false;
	});	

	$('#subs_s').click(function(){
		fmail = $(this).closest('form').find('input[name=mail]');
		if(!isValidEmailAddress(fmail.val())){
			fmail.parent().addClass('error');
		}else{
			fmail.parent().removeClass('error');
			$(this).closest('form').submit();
		}
	});
		

	var cat_more = $('#cat_more');
	if(cat_more.length){
		if(cat_more.height() > 317){
			cat_more.addClass('cat_more-hide').after('<div class="txt_more" id="category_more"><span>Далее...</span></div>');
		}
		$('#category_more').bind('click', function() {
			$(this).hide();
			cat_more.removeClass('cat_more-hide');
		});
	}
	
	
	/* menu slidebar */
	var imenu = $('#icon-menu');
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
	$('#hide-sidebar').click(function(){
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

	$(window).resize(function() {
		if ($('body').hasClass(active_class)) {
			$('html, body').css({
				overflow: 'hidden',
				height: $(window).height()
			});
		}
	});

});
/* validate email */
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}



/*
$(window).resize(function(){
	$('#popup.auth_form .form').css({
		"margin-left": -($('#popup.auth_form .form').outerWidth()/2),
		"margin-top": -($('#popup.auth_form .form').outerHeight()/2)
	});
	
	$('#popup.city_select .form').css({
		"margin-left": -($('#popup.city_select .form').outerWidth()/2),
		"margin-top": -($('#popup.city_select .form').outerHeight()/2)
	});
});
*/

function select_alfavit(bukva){
	if (bukva!=''){
		$(".group-alfa a").removeClass("active");
		
		$('.group-alfa a').each(function(i){
			if ($(this).html()==bukva){
				$(this).addClass("active");
				return false;
			}
		});
	}
}




function open_discography(id,url_img){

	$(".discography .anotaciya").hide();
	$(".discography .anotaciya#anotaciya"+id).show();
	for (var i=1;  i<=$('.disc_gr #dis_count').html(); i++){
		$(".discography #pl_"+i).attr({'src':url_img+"/images/plus.png"});
	}
	$("#discography"+id+" #pl_"+id).attr({'src':url_img+"/images/minus.png"});
	/*
	var dis_count=document.getElementById('dis_count').innerHTML;
	for (var i=1;  i<=dis_count; i++){							
		if (i==id){
			if (document.getElementById('anotaciya'+id).style.display=="none"){
				document.getElementById('anotaciya'+id).style.display="block";
				document.getElementById('pl_'+id).src=url_img+"/images/minus.png";
			}
			else{
				document.getElementById('pl_'+id).src=url_img+"/images/plus.png";
				document.getElementById('anotaciya'+id).style.display="none";
			}							
		}
		else{
			document.getElementById('pl_'+i).src=url_img+"/images/plus.png";
			document.getElementById('anotaciya'+i).style.display="none";
		}
	}	*/		
}
/* картинки в контенте все увеличиваются
$('.content img').load(function(){
	var t = $(this), href = t.attr('src');
	t.wrap('<a href="'+href+'" data-lightbox="zoom"></a>').parent('a');
});

 */



function WinOpen(url,name){
var params = 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no width=600,height=350';
//,left=100,top=100	
window.open(url, name, params);

return false;

}