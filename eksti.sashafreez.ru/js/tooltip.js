$(document).ready(function() {
	// $('.catalogList').find('.imgCont').each(function() {
	// 	if($(this).parent().is(':nth-child(3n)')) {
	// 		$(this).parent().css('margin-right', '0');
	// 	}

	// 	$(this).hover(function() {
	// 		var hoverBlock = $(this).parent().find('.hoverBlock');
	// 		hoverBlock.slideDown('fast');


	// 	}, function() {
	// 			var hoverBlock = $(this).parent().find('.hoverBlock');
	// 			hoverBlock.slideUp('fast');			
	// 	});
	// 	$(this).mousemove(function( event ) {
			
	// 		var hoverBlock = $(this).parent().find('.hoverBlock');

	// 		var pageCoordsX = "" + event.pageX + "";
	// 		var pageCoordsY = "" + event.pageY + "";
			

	// 		var b = $('body').width()+20;
			
	// 		hoverBlock.css('left', pageCoordsX + "px");
	// 		hoverBlock.css('top', pageCoordsY + "px");

	// 		if($(this).parent().is(':nth-child(3n)')) {
	// 			hoverBlock.css('left', 'auto');
	// 			hoverBlock.css('right', b-pageCoordsX + "px");
	// 			hoverBlock.css('top', pageCoordsY + "px");
	// 		}
			
	// 	});
	// });
	$('a.fancy').fancybox();
})