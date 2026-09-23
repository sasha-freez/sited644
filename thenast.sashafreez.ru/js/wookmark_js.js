$(window).load(function() {
	$('#tiles li').wookmark({
		// Prepare layout options.
		autoResize: true, // This will auto-update the layout when the browser window is resized.
		container: $('#tiles'), // Optional, used for some extra CSS styling
		offset: 5, // Optional, the distance between grid items
		outerOffset: 10, // Optional, the distance to the containers border
		itemWidth: 240 // Optional, the width of a grid item
	});
	
	$('#tiles_big li').wookmark({
		// Prepare layout options.
		autoResize: true, // This will auto-update the layout when the browser window is resized.
		container: $('#tiles_big'), // Optional, used for some extra CSS styling
		offset: 5, // Optional, the distance between grid items
		outerOffset: 10, // Optional, the distance to the containers border
		itemWidth: 290 // Optional, the width of a grid item
	});
});
