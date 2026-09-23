$(function(){
	var body =$('body');
	$('#font_switcher a').click(function(){
		var t = $(this), rel = t.attr('rel');
		t.parent().find('a').removeClass('f_curr');
		t.addClass('f_curr');
		body.removeAttr('class').addClass(rel);
		
		$.cookie('font_large', null);
		$.cookie('font_mid', null);
		$.cookie('font_small', null);
		
		$.cookie(rel, 1); // сохраняю классы, чтобы при обновлении было чудо 
	});
	if($.cookie('font_large') == 1){body.addClass('font_large'); $('#font_switcher a[rel=font_large]').addClass('f_curr');}
	if($.cookie('font_mid') == 1){body.addClass('font_mid'); $('#font_switcher a[rel=font_mid]').addClass('f_curr');}
	if($.cookie('font_small') == 1){body.addClass('font_small'); $('#font_switcher a[rel=font_small]').addClass('f_curr');}
});


//scrollUp v1.1.0
;(function($) {
	$.scrollUp = function (options) {
		// Defaults
		var defaults = {
			scrollName: 'scrollUp', // Element ID
			topDistance: 300, // Distance from top before showing element (px)
			topSpeed: 300, // Speed back to top (ms)
			animation: 'fade', // Fade, slide, none
			animationInSpeed: 200, // Animation in speed (ms)
			animationOutSpeed: 200, // Animation out speed (ms)
			scrollText: 'Scroll to top', // Text for element
			scrollImg: false, // Set true to use image
			activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
		};

		var o = $.extend({}, defaults, options),
			scrollId = '#' + o.scrollName;

		// Create element
		$('<a/>', {
			id: o.scrollName,
			href: '#top',
			title: o.scrollText
		}).appendTo('body');
		
		// If not using an image display text
		if (!o.scrollImg) {
			$(scrollId).text(o.scrollText);
		}

		// Minium CSS to make the magic happen
		$(scrollId).css({'display':'none','position': 'fixed','z-index': '2147483647'});

		// Active point overlay
		if (o.activeOverlay) {
			$("body").append("<div id='"+ o.scrollName +"-active'></div>");
			$(scrollId+"-active").css({ 'position': 'absolute', 'top': o.topDistance+'px', 'width': '100%', 'border-top': '1px dotted '+o.activeOverlay, 'z-index': '2147483647' });
		}

		// Scroll function
		$(window).scroll(function(){	
			switch (o.animation) {
				case "fade":
					$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed) );
					break;
				case "slide":
					$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed) );
					break;
				default:
					$( ($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0) );
			}
		});

		// To the top
		$(scrollId).click( function(event) {
			$('html, body').animate({scrollTop:0}, o.topSpeed);
			event.preventDefault();
		});

	};
})(jQuery);

$(function () {
    $.scrollUp({
        scrollName: 'back_top', //  ID элемента
        topDistance: '300', // расстояние после которого появится кнопка (px)
        topSpeed: 300, // скорость переноса (миллисекунды)
        animation: 'fade', // вид анимации: fade, slide, none
        animationInSpeed: 200, // скорость разгона анимации (миллисекунды)
        animationOutSpeed: 200, // скорость торможения анимации (миллисекунды)
        scrollText: '', // текст
        activeOverlay: false, // задать CSS цвет активной точке scrollUp, например: '#00FFFF'
    });
});