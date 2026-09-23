$(window).load(function() {
	$('.tiles li').wookmark({
		// Prepare layout options.
		autoResize: true, // This will auto-update the layout when the browser window is resized.
		container: $('.tiles'), // Optional, used for some extra CSS styling
		offset: 0, // Optional, the distance between grid items
		outerOffset: 0, // Optional, the distance to the containers border
		itemWidth: 328, // Optional, the width of a grid item
		flexibleWidth:true,
		align:'left'
	});
	
});
