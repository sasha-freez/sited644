$(function () {
   /** preload images */
   var $cont = $('.slider_images');
   var $items = $cont.find('.slider_images_pic');
   var f = $items.first().children();
   var b =  $cont.find('.mask-with-blur');

//  b.append(f.clone(true));


   /* show first */
   f.attr('src', f.attr('data-src'));
   f.removeAttr('data-src');

   var imageLoaded = function() {
    $items.each(function(){
      var a = $(this).children();
      var s = a.attr('data-src');
      a.attr('src', s);
      a.removeAttr('data-src');
    });
   };

   $items.each(function(){
    var a = $(this).children();
    var s = a.attr('data-src');
    if(!(a.attr('data-src') == '')) {
      var tImg = new Image();
      tImg.onload = imageLoaded;
      tImg.src = s;
    }
   });

   /** force preload images except for first images from container */
	$('.slider_images_pic').live('click', function () {
		var cur_url = $('.slider_desc_item .active .link').first().attr('href');
		if (cur_url.length > 0) {
			location.href = cur_url;
		}
	});
});