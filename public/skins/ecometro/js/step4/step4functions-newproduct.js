// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {
	
	var prid = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var baseUrl = 'http://vivienda.ecometro.org/';

	if($('.family-products ul.errors').length > 0) {		
		// load family products
		loadFamilyProducts();				
	}
	
	// when the user selects the unit of measure
	$('#unidad').on('change', function(event) {
		
		switch($('#unidad option:selected').text()) {
			case 'm': $('.densidad').css('display', 'block');
					  $('.densidad input').val('');
					  $('.espesor').css('display', 'none');					  
					  $('.densidad label').text('Densidad lineal (kg/m)');
					  break;
			case 'm2': $('.densidad').css('display', 'block');
					   $('.densidad input').val('');
					   $('.espesor').css('display', 'block');
					   $('.espesor').val('');
					   $('.densidad label').text('Densidad (kg/m2)');
			  		   break;
			case 'm3': $('.densidad').css('display', 'block');
					   $('.densidad input').val('');
					   $('.espesor').css('display','none');					   
					   $('.densidad label').text('Densidad (kg/m3)');
	  		   		   break;
			case 'kg': $('.densidad').css('display', 'none');					   
					   $('.espesor').css('display', 'none');					   
	   		   		   break;
			case 'Componente': $('.densidad').css('display', 'block');
					   $('.densidad input').val('');
					   $('.espesor').css('display', 'none');					   
					   $('.densidad label').text('Peso/Componente (kg)');
			   		   break;   		   
		}		
	});
	
	// when the user selects one specific family materials
	$('#familia_de_productos_materiales').on('change', function(event) {			
		// load family products
		loadFamilyProducts();								
	});
	
	function loadFamilyProducts() {		
		$('.family-products').css('display', 'block');		
		var connection = $('#familia_de_productos_materiales').val();
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/findfamilyproducts/' + prid,
			data: {key: connection},
			success: function(r) {				
			 	var connection, options = '';			 	
			 	options = '<option value="0">' + 'Seleccione...' + '</option>';			 
				$.each(r, function(i, val) {
					options += '<option value="' + r[i]['id'] + '" ' + '>' + r[i]['family_product'] + '</option>';
				});

				// Add family product
				$('#familia_de_productos option').remove();				
				$('#familia_de_productos').append(options);
			}
		});	
	}
});