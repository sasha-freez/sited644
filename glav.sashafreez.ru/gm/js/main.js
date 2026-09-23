$(function(){
	$('.imenu').on('click',function(){
		var $body = $('body');
		if($body.hasClass("mobile_menu")){
			$body.removeClass('mobile_menu');
		}else{
			$body.addClass('mobile_menu');
		}
	});

	var owl = $('.reviews_carusel');
	owl.owlCarousel({
		loop: true,
		items: 1,
		margin: 0,
		navRewind: false
	});
	
	var owl = $('.service_carousel');
	owl.owlCarousel({
		smartSpeed:1000,
		loop:true,
		autoWidth:true,
		autoplay:true,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
		items: 1,
		margin: 0,
		navRewind: false,
		onInitialized: owlInitialized
	});
	
	function owlInitialized(){
		addPopupTxt($('.service_carousel'),0);
	}

	owl.on('changed.owl.carousel', function(event) {
		addPopupTxt($(this),event.page.index);
	});

	function addPopupTxt(owl, number){
		var $current = owl.find('.item[data-number="'+number+'"]');
		var popupTxt = $current.find('.service_desc').html();
		owl.find('.item__active').removeClass('item__active');
		$current.addClass('item__active');
		$('#service_popup__txt').hide().fadeIn(500).html(popupTxt);
	}
});

/* SetCookie + GetCookie */
function setCookie(c_name, value, expiredays, path, expirehours, expireminutes) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate()+expiredays);
  if (typeof expirehours != 'undefined') {
	  exdate.setHours(exdate.getHours()+expirehours);
  }
	if (typeof expireminutes != 'undefined') {
		exdate.setMinutes(exdate.getMinutes() + expireminutes);
	}
  var exdate_UTC = exdate.toUTCString();
  document.cookie = c_name + "=" + encodeURIComponent(value) +
  ((expiredays == null) ? "" : ";expires=" + exdate_UTC) +
  ((path == null) ? "" : ";path=" + path);
}

function getCookie(name) {
  var start = document.cookie.indexOf(name + '=');
  var len = start + name.length + 1;
  if ((!start) && (name != document.cookie.substring(0, name.length))) {
		return null;
	}
  if (start == -1) {
		return null;
	}
  var end = document.cookie.indexOf(';', len);
  if (end == -1) {
		end = document.cookie.length;
	}
  return decodeURIComponent(document.cookie.substring(len, end));
}
