$(window).load(function () {
var width_item=$(".portfolio .item").width(); 
var width_img=$(".portfolio .item img").width(); 
//alert(width_item);
//alert(tl); + прибавляет
/* .each пройти по всем элементам */

var imgW=0; 
$("#portfolio .item img").each(function(){
		imgW = $(this).width();

		//alert(imgW);
		
	
	if(imgW<600){
			$(this).parent().parent().css('width', 452+'px');
		} 
      });
	  
/*
//alert($(this).find("img").width());
if (width_img>width_item) { 
$(".portfolio .item").css('width', width_img+'px');
}else{
$(".portfolio .item").css('width', width_item+'px');
}
*/

});