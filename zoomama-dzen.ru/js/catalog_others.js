$(document).ready(function() {
    
    var catalog_type1_disabled = $('#catalog_type1').html();
    var catalog_type2_disabled = $('#catalog_type2').html();
    var request = {};

	//получаем категорию другой продукции
	request.action = 'type1';
	
	$.post(document.location.href, request, function(data) {
		$('#catalog_type1').append(data);
	});
	
	//при смене категории 1 уровня выводим результат фильтра
	$('#catalog_type1').change(function() {
        request.action = 'type2';
	    request.type1 = $('#catalog_type1').val();
	    request.type2 = '';
	    request.offset = 0;
		
		$('#catalog_type2').html(catalog_type1_disabled).val('Подкатегория').attr('disabled','disabled');

		$.post(document.location.href, request, function(data) {
			$('#catalog_type2').html(catalog_type1_disabled+data).val('Подкатегория').removeAttr('disabled');
			
		});
		
		request.action = 'items';
		
		$.post(document.location.href, request, function(data) {
		    
            $('.more-ajax .btn-more').hide();
            $('.more-ajax .btn-more-filter').hide();

		    if(data.total > data.offset) {
		        request.offset = data.offset;
		        $('.more-ajax .btn-more-filter').show();
		    }
		    
		    $('.goods_list .rows').html(data.html);
		}, 'JSON');
			
	});
    
    //получаем товары категории 2 уровня
	$('#catalog_type2').change(function() {
        request.action = 'type2';
		request.type1 = '';
	    request.type2 = $('#catalog_type2').val();
	    request.offset = 0;

		
		request.action = 'items';
		
		$.post(document.location.href, request, function(data) {
		    
            $('.more-ajax .btn-more').hide();
            $('.more-ajax .btn-more-filter').hide();

		    if(data.total > data.offset) {
		        request.offset = data.offset;
		        $('.more-ajax .btn-more-filter').show();
		    }
		    
		    $('.goods_list .rows').html(data.html);
		}, 'JSON');
			
	});
	
    //получаем товары
	$('#catalog_equipment').change(function() {

        request.action = 'items';
        request.offset = 0;
	    request.equipment = $('#catalog_equipment').val();

		$.post(document.location.href, request, function(data) {
		    
            $('.more-ajax .btn-more').hide();
            $('.more-ajax .btn-more-filter').hide();

		    if(data.total > data.offset) {
		        request.offset = data.offset;
		        $('.more-ajax .btn-more-filter').show();
		    }
		    
		    $('.goods_list .rows').html(data.html);
		}, 'JSON');
			
	});
	
	//получаем товары
	$('.more-ajax .btn-more-filter').click(function() {

		$.post(document.location.href, request, function(data) {
		    
		    if(data.total > data.offset) {
		        $('.more-ajax .btn-more-filter').show();
		        request.offset = data.offset;
		    } else {
		        $('.more-ajax .btn-more-filter').hide();
		    }
		    
		    $('.goods_list .rows').append(data.html);
		    
		}, 'JSON');
			
	});
	
	//очищаем фильтры
	$('#catalog_clear').click(function() {
        $('#catalog_type1').val('Тип продукции');
	    $('#catalog_type2').html(catalog_type2_disabled).attr('disabled','disabled');
        
        request.action = 'items';
		request.offset = 0;
		request.type1 = '';
	    request.type2 = '';
        

        $.post(document.location.href, request, function(data) {
		    
            $('.more-ajax .btn-more').hide();
            $('.more-ajax .btn-more-filter').hide();

		    if(data.total > data.offset) {
		        request.offset = data.offset;
		        $('.more-ajax .btn-more-filter').show();
		    }
		    
		    $('.goods_list .rows').html(data.html);
		}, 'JSON');
			
	});
    
});