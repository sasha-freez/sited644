$(document).ready(function() {
    
    var catalog_series_disabled = $('#catalog_series').html();
    var catalog_wood_disabled = $('#catalog_wood').html();
    var catalog_equipment_disabled = $('#catalog_equipment').html();
    var request = {};

	//получаем типы кроватей
	request.action = 'type';
	
	$.post(document.location.href, request, function(data) {
		$('#catalog_type').append(data);
	});
	
	//получаем серию
	$('#catalog_type').change(function() {
        
        request.action = 'series';
	    request.type = $('#catalog_type').val();
	    request.series = '';
	    request.wood = '';
	    request.offset = 0;
	    request.equipment = '';
	    
	    $('#catalog_wood').html(catalog_wood_disabled).attr('disabled','disabled');
		$('#catalog_equipment').html(catalog_equipment_disabled).attr('disabled','disabled');
		$('#catalog_series').html(catalog_series_disabled).val('Серия').attr('disabled','disabled');

		$.post(document.location.href, request, function(data) {
			$('#catalog_series').html(catalog_series_disabled+data).val('Серия').removeAttr('disabled');
			
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
    
    //получаем тип дерева
	$('#catalog_series').change(function() {

        request.action = 'wood';
	    request.series = $('#catalog_series').val();
	    request.offset = 0;
	    request.wood = '';
	    request.equipment = '';
	    
	    $('#catalog_wood').html(catalog_wood_disabled).val('Тип дерева').attr('disabled','disabled');
	    $('#catalog_equipment').html(catalog_equipment_disabled).attr('disabled','disabled');

		$.post(document.location.href, request, function(data) {
			$('#catalog_wood').html(catalog_wood_disabled+data).val('Тип дерева').removeAttr('disabled');
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
    
    //получаем комплектации
	$('#catalog_wood').change(function() {

        request.action = 'equipment';
	    request.wood = $('#catalog_wood').val();
	    request.offset = 0;
	    request.equipment = '';

	    $('#catalog_equipment').html(catalog_equipment_disabled).attr('disabled','disabled');

		$.post(document.location.href, request, function(data) {
		    $('#catalog_equipment').html(catalog_equipment_disabled+data).val('Комплектация').removeAttr('disabled');
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

        $('#catalog_type').val('Тип кровати');
	    $('#catalog_series').html(catalog_series_disabled).attr('disabled','disabled');
        $('#catalog_wood').html(catalog_wood_disabled).attr('disabled','disabled');
        $('#catalog_equipment').html(catalog_equipment_disabled).attr('disabled','disabled');
        
        request.action = 'items';
        request.offset = 0;
        
        request.series = '';
	    request.wood = '';
        request.equipment = '';
        request.type = '';
            
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