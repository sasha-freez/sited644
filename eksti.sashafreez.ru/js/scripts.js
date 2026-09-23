$(document).ready(function() {
	$(window).load(function() {
		$('.blueberry').unslider({
			speed: 1000,               //  The speed to animate each slide (in milliseconds)
			delay: 5000,              //  The delay between slide animations (in milliseconds)
			complete: function() {},  //  A function that gets called after every slide animation
			keys: false,               //  Enable keyboard (left, right) arrow shortcuts
			dots: true,               //  Display dot navigation
			fluid: false 
		});
	});
})




