// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {
	
	var prid = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var baseUrl = 'http://vivienda.ecometro.org/'; 
	var count = 1;
	var selectedfm, selectedfp, selectedpr, selectedtr, connectionfm, connectionfp, connectionpr, firstrow, cantidad;
	
	// When the user press insert material		
	$('.insert-material').click(function() {		

		count++;				
		$('.etapas .plus').before(insertNuevoMaterial(count, ''));				
		fetchSelectFamilyMaterials('listfamilymaterials', '', 'Selecciona material...', 'id', 'family_material', '.familymaterials-' + count);		

		return false;
	});
	
	// When the user press guardar button
	$('button.derecha').click(function() {

		var newrow;

		for (var i = 1; i <= count; i++) {			
			selectedfm = $('.familymaterials-' + i).find('option').eq($('.familymaterials-' + i).prop('selectedIndex'));
			selectedfp = $('.familyproducts-' + i).find('option').eq($('.familyproducts-' + i).prop('selectedIndex'));
			selectedpr = $('.products-' + i).find('option').eq($('.products-' + i).prop('selectedIndex'));
			cantidad = $('.qty-' + i).val();
			selectedtr = $('.familymaterials-' + i).closest('tr');
			selectedtrclass = $('.familymaterials-' + i).closest('tr').attr('class');									
			
			connectionfm = selectedfm.data('connection');			
			connectionfp = selectedfp.data('connection');
			connectionpr = selectedpr.data('connection');									
			
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: baseUrl + 'step4/save/' + prid,
				data: {familymaterialsid: connectionfm, familyproductsid: connectionfp, productsid: connectionpr, selectedtrclass: selectedtrclass, numrow: i, cantidad: cantidad},
				success: function(r) {
					if(r.newrow == true) {												
						$('.familymaterials-' + r.numrow).closest('tr').addClass(r.id + '');												
					}
				},
				error: function() {

				}
			});									
		}

		$('.etapa-success').css('display', 'block');
		$('.etapa-success').append('Material(es) guardado(s).');
		$('.etapa-success').fadeOut(4000);		
	});
		
	
	$('body').on('click', '.column1', function(event) {

		if($(this).parent().attr('class') == '') {			
			$(this).parent().remove();			
		} else {			
			var productid = $(this).parent().attr('class');
			$(this).parent().remove();
				
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: baseUrl + 'step4/delete/' + prid,
				data: {productid: productid},
				success: function(r) {
					$('.etapa-error').css('display', 'block');
					$('.etapa-error').append(r.message);
					$('.etapa-error').fadeOut(4000);
				},
				error: function(r) {

				}
			});			
		}
	});
	
	$('body').on('change', 'select', function(event) {
		
		var identifier = $(this).attr('class');		
		var identifierClass = identifier.split(' ');		
		var identifierArray = identifierClass[0].split('-');		
		
		switch(identifierArray[0]) {
			case 'familymaterials': 
				onChangeFamilyMaterials(identifierClass, identifierArray[1]);
				break; 
			case 'familyproducts': 
				onChangeFamilyProducts(identifierClass, identifierArray[1]);
			 	break; 	
			case 'products': 
				onChangeProducts(identifierClass, identifierArray[1]);
				break; 	 							
		}	
	});
	
	// when the user selects one specific family materials
	function onChangeFamilyMaterials(div, count) {	
		
		// The selected option
		var selected = $('.' + div).find('option').eq($('.' + div).prop('selectedIndex'));		
		// Look up the data-connection attribute
		var connection = selected.data('connection');
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/findfamilyproducts/' + prid,
			data: {key: connection},
			success: function(r) {				
			 	var connection, options = '';			 	
			 	options = '<option>' + 'Selecciona familia de productos...' + '</option>';			 
				$.each(r, function(i, val) {
					connection = 'data-connection="' + r[i]['id'] + '"';
					options += '<option value="' + r[i]['family_product'] + '" ' + connection + '>' + r[i]['family_product'] + '</option>';
				});
				
				// Add family product
				$('.familyproducts-' + count + ' option').remove();				
				$('.familyproducts-' + count).append(options);
								
				// Removing product
				$('.products-' + count + ' option').remove();
				
				// Removing unit
				$('.unit-' + count + ' span').remove();
				$('.unit-' + count).append('<span> </span>');
				
				// Removing product origin				
				$('.productorigin-' + count + ' span').remove();
				$('.productorigin-' + count).append('<span> </span>');				
				
				// Removing emplazamiento fabricante				
				$('.emplazamiento_fabricante-' + count + ' span').remove();
				$('.emplazamiento_fabricante-' + count).append('<span> </span>');
				
				// Removing distancia distribuidor				
				$('.distancia-distribuidor-obra-' + count + ' span').remove();
				$('.distancia-distribuidor-obra-' + count).append('<span> </span>');
				
				// Removing vida util				
				$('.vida_util_producto-' + count + ' span').remove();
				$('.vida_util_producto-' + count).append('<span> </span>');
				
				// Removing transport type
				$('.transporttype-' + count + ' span').remove();
				$('.transporttype-' + count).append('<span> </span>');			
			},
			error: function(r) {

			}
		});								
	}

	// when the user selects one specific family product
	function onChangeFamilyProducts(div, count) {			
		// The selected option
		var selected = $("." + div).find('option').eq($('.' + div).prop('selectedIndex'));		
		// Look up the data-connection attribute
		var connection = selected.data('connection');
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/findproducts/' + prid,
			data: {key: connection},
			success: function(r) {
				
			 	var connection, options = '';			 	
			 	options += '<option>' + 'Selecciona productos...' + '</option>';			 
				$.each(r, function(i, val){																											    					
					connection = 'data-connection="' + r[i]['id'] + '"';												
					options += '<option value="' + r[i]['producto'] + '" ' + connection + '>' + r[i]['producto'] + '</option>';
				});
				
				// Add products
				$('.products-' + count + ' option').remove();
				$('.products-' + count).append(options);
				
				// Removing unit
				$('.unit-' + count + ' span').remove();
				$('.unit-' + count).append('<span> </span>');
				
				// Removing product origin				
				$('.productorigin-' + count + ' span').remove();
				$('.productorigin-' + count).append('<span> </span>');				
				
				// Removing emplazamiento fabricante				
				$('.emplazamiento_fabricante-' + count + ' span').remove();
				$('.emplazamiento_fabricante-' + count).append('<span> </span>');
				
				// Removing distancia distribuidor				
				$('.distancia-distribuidor-obra-' + count + ' span').remove();
				$('.distancia-distribuidor-obra-' + count).append('<span> </span>');
				
				// Removing vida util				
				$('.vida_util_producto-' + count + ' span').remove();
				$('.vida_util_producto-' + count).append('<span> </span>');
				
				// Removing transport type
				$('.transporttype-' + count + ' span').remove();
				$('.transporttype-' + count).append('<span> </span>');										
			},
			error: function(r) {

			}			
		});		
	}	
	
	// When the user selects one specific family product
	function onChangeProducts(div, count) {	
		
		// The selected option
		var selected = $('.' + div).find('option').eq($('.' + div).prop('selectedIndex'));
		// Look up the data-connection attribute
		var connection = selected.data('connection');
		
		// Load product unit
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/finddetailsproduct/' + prid,
			data: {key: connection},
			success: function(r) {												
				var unit = '<span>' + r[0]['product_unit'] + '</span>';				
				var productorigin = '<span>' + r[0]['product_origin'] + '</span>';
				var emplazamiento_fabricante = '<span>' + r[0]['emplazamiento_fabricante'] + '</span>';
				var transport_type = '<span>' + r[0]['transport_type'] + '</span>';				
				var distancia = '<span>' + r[0]['distancia_distribuidor'] + '</span>';
				var vida_util_producto = '<span>' + r[0]['vida_util_producto'] + '</span>';
				
				// Removing the span container that follow
				$('.unit-' + count + ' span').remove();
				$('.unit-' + count).append(unit);
				
				// Removing the span container that follow
				$('.productorigin-' + count + ' span').remove();
				$('.productorigin-' + count).append(productorigin);
				
				// Removing the span container that follow
				$('.emplazamiento_fabricante-' + count + ' span').remove();
				$('.emplazamiento_fabricante-' + count).append(emplazamiento_fabricante);
				
				// Removing the span container that follow
				$('.transporttype-' + count + ' span').remove();
				$('.transporttype-' + count).append(transport_type);				
				
				// Removing the span container that follow
				$('.distancia-distribuidor-obra-' + count + ' span').remove();
				$('.distancia-distribuidor-obra-' + count).append(distancia);
				
				// Removing the span container that follow
				$('.vida_util_producto-' + count + ' span').remove();
				$('.vida_util_producto-' + count).append(vida_util_producto);			
			}			
		});		
	}
	
	// Load family materials
	function fetchSelectFamilyMaterials(action, request, optiontext, paramkey, paramvalue, div, selected) {
									
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/' + action + '/' + prid,
			data: {key: request},
			success: function(r) {				
				var connection, options = '';
			 	options = '<option selected>' + optiontext + '</option>';			 	
				$.each(r, function(i, val) {																						
						connection = 'data-connection="' + r[i][paramkey] + '"';
						if(selected != null && r[i][paramkey] == selected)
							options += '<option selected value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
						else
							options += '<option value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
						    														
				});
				$(div).append(options);
			}, 
			error: function(r) {

			}
		});
	}	
	
	// load family product
	function fetchSelectFamilyProducts(action, request, optiontext, paramkey, paramvalue, div, selected) {			
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/' + action + '/' + prid,
			data: {key: request},
			success: function(r) {				
				var connection, options = '';				 
			 	options = '<option selected>' + optiontext + '</option>';			 	
				$.each(r, function(i, val) {																												
						connection = 'data-connection="' + r[i][paramkey] + '"';						
						if(selected != null && r[i][paramkey] == selected)
							options += '<option selected value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
						else
							options += '<option value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
						    														
				});				
				$(div).append(options);
			}
		});						
	}
	
	// load product
	function fetchSelectProducts(action, request, optiontext, paramkey, paramvalue, div, selected) {			
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/' + action + '/' + prid,
			data: {key: request},
			success: function(r) {				
				var connection, options = '';				 
			 	options = '<option selected>' + optiontext + '</option>';			 	
				$.each(r, function(i, val) {						
						connection = 'data-connection="' + r[i][paramkey] + '"';						
						if(selected != null && r[i][paramkey] == selected)
							options += '<option selected value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
						else
							options += '<option value="' + r[i][paramvalue] + '" ' + connection + '>' + r[i][paramvalue] + '</option>';
				});
				
				$(div).append(options);
			}
		});		
	}
	
	// load details product
	function fetchDetailsProduct(count, request) {			
		
		// Load product unit
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + 'step4/finddetailsproduct/' + prid,
			data: {key: request},
			success: function(r) {
												
					var unit = '<span>' + r[0]['product_unit'] + '</span>';
					var productorigin = '<span>' + r[0]['product_origin'] + '</span>';
					var emplazamiento_fabricante = '<span>' + r[0]['emplazamiento_fabricante'] + '</span>';
					var transport_type = '<span>' + r[0]['transport_type'] + '</span>';					
					var distancia = '<span>' + r[0]['distancia_distribuidor'] + '</span>';
					var vida_util_producto = '<span>' + r[0]['vida_util_producto'] + '</span>';
										
					$('.unit-' + count).append(unit);
					
					// Removing the span container that follow					
					$('.productorigin-' + count).append(productorigin);
					
					// Removing the span container that follow					
					$('.emplazamiento_fabricante-' + count).append(emplazamiento_fabricante);
					
					// Removing the span container that follow					
					$('.transporttype-' + count).append(transport_type);
					
					// Removing the span container that follow					
					$('.density-' + count).append(density);
					
					// Removing the span container that follow					
					$('.thikness-' + count).append(density);
					
					// Removing the span container that follow					
					$('.distancia-distribuidor-obra-' + count).append(distancia);
					
					// Removing the span container that follow					
					$('.vida_util_producto-' + count).append(vida_util_producto);			
			}			
		});		
	}

	// Initially load of data on page refresh/load
	$.ajax({
		type: 'post',
		dataType: 'json',
		url: baseUrl + 'step4/getetapas/' + prid,		
		success: function(r) {
			if(r.length < 1)
				// Initially load the family materials select
				fetchSelectFamilyMaterials('listfamilymaterials', '', 'Selecciona material...', 'id', 'family_material', '.familymaterials-1', null);
			else {	
				// Load rows stored in db
				count = 1;
				$.each(r, function(i,val) {															
					
					if(r[i]['family_material_id'] != null) {
						// first row default
						if(count == 1) {
							
							fetchSelectFamilyMaterials('listfamilymaterials', '', 'Selecciona material...', 'id', 'family_material', '.familymaterials-' + count, r[i]['family_material_id']);
							$('.familymaterials-' + count).closest('tr').addClass(r[i]['id'] + '');
							$('.del-' + count).prop('disabled', false);
							
							if(r[i]['family_product_id'] != null) {
								
								fetchSelectFamilyProducts('findfamilyproducts', r[i]['family_material_id'], 'Selecciona familia de productos...', 'id', 'family_product', '.familyproducts-' + count, r[i]['family_product_id']);
							
								if(r[i]['product_id'] != null) {
									fetchSelectProducts('findproducts', r[i]['family_product_id'], 'Selecciona productos...', 'id', 'producto', '.products-' + count, r[i]['product_id']);									
									fetchDetailsProduct(count, r[i]['product_id']);
									var cantidad = r[i]['cantidad'];														
									$('.qty-' + count).val(cantidad);
								}
								else
									fetchSelectProducts('findproducts', r[i]['family_product_id'], 'Selecciona productos...', 'id', 'producto', '.products-' + count, r[i]['product_id']);
							}
							else
								fetchSelectFamilyProducts('findfamilyproducts', r[i]['family_material_id'], 'Selecciona familia de productos...', 'id', 'family_product', '.familyproducts-' + count, null);
							
						} else {
							// next rows							
							$('.etapas .plus').before(insertNuevoMaterial(count, r[i]['id'] + ''));
							$('.del-' + count).prop('disabled', false);
							fetchSelectFamilyMaterials('listfamilymaterials', '', 'Selecciona material...', 'id', 'family_material', '.familymaterials-' + count, r[i]['family_material_id']);
							
							if(r[i]['family_product_id'] != null) {
								
								fetchSelectFamilyProducts('findfamilyproducts', r[i]['family_material_id'], 'Selecciona familia de productos...', 'id', 'family_product', '.familyproducts-' + count, r[i]['family_product_id']);
							
								if(r[i]['product_id'] != null) {
									fetchSelectProducts('findproducts', r[i]['family_product_id'], 'Selecciona productos...', 'id', 'producto', '.products-' + count, r[i]['product_id']);
									fetchDetailsProduct(count, r[i]['product_id']);
									var cantidad = r[i]['cantidad'];														
									$('.qty-' + count).val(cantidad);
								}
								else
									fetchSelectProducts('findproducts', r[i]['family_product_id'], 'Selecciona productos...', 'id', 'producto', '.products-' + count, r[i]['product_id']);
							}	
							else
								fetchSelectFamilyProducts('findfamilyproducts', r[i]['family_material_id'], 'Selecciona familia de productos...', 'id', 'family_product', '.familyproducts-' + count, null);
						}
					}
					count++;
				});
			}
		}		
	});	
	
	// Insert new material row
	function insertNuevoMaterial(count, classname) {
		
		var nuevomaterial = '<tr class="' + classname + '">' +
		'<td class="column1"><span class="del-' + count + '">x</span></td>' +
		'<td><select name="familymaterials" class="familymaterials-' + count + ' arrow"></select></td>' +		
		'<td><select name="familyproducts" class="familyproducts-' + count + ' arrow"><option></option></select></td>' +
		'<td><select name="products" class="products-' + count + ' arrow"><option></option></select></td>' +
		'<td><input type="text" name="qty" size="10" class="qty-' + count + ' acvinput" value="" /></td>' +
		'<td><span class="unit-' + count + '"' + '>&nbsp;</span></td>' + 		
		'<td><span class="productorigin-' + count + '"' + '>&nbsp;</span></td>' + 
		'<td><span class="emplazamiento_fabricante-' + count + '"' + '>&nbsp;</span></td>' +
		'<td><span class="distancia-distribuidor-obra-' + count + '"' + '>&nbsp;</span></td>' +
		'<td><span class="transporttype-' + count + '"' + '>&nbsp;</span></td>' + 
		'<td><span class="vida_util_producto-' + count + '"' + '>&nbsp;</span></td>' +
		'</tr>';
		
		return nuevomaterial;
	}	
});