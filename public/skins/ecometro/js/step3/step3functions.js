// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {
	
	// get project's id
	var idOfTheProject = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);	
	var parts = $('form').attr('id').split('-');	
	var numberOfTheStep = parts[0];	
	var idOfTheForm = parts[1];	
	var baseUrl = 'http://vivienda.ecometro.org/'; 

	/**
	 * [ajaxError redirect en case of expired session]
	 * @return {[type]} [description]
	 */
	function ajaxError() {
		window.location.replace(baseUrl + 'account/sessionexpired/');
	}		
	
	/**
	 * [checkIfFieldIsEmpty description]
	 * @param  {[type]} field [description]
	 * @return {[type]}       [description]
	 */
	function getFieldValue(field) {

		var valueField = '';

		if(field.length == 1) {
			if(field.val() != '')
				valueField = field.val();
		} else {			
			field.each(function () {
				if($(this).is(':checked'))
					valueField = $(this).val();				
			});
		}			
		return valueField;
	}

	/**
	 * [checkIfFieldIsEmpty description]
	 * @param  {[type]} field [description]
	 * @return {[type]}       [description]
	 */
	function checkIfFieldIsEmpty(field) {

		var validField = false;

		if(field.length == 1) {
			if(field.val() != '')
				validField = true;
		} else {			
			field.each(function () {
				if($(this).is(':checked'))
					validField = true;				
			});
		}	
		return validField;
	}
	
	/**
	 * [setClassAplicableNo description]
	 * @param {[type]} rowOfTheForm [description]
	 */
	function setClassAplicableNo(rowOfTheForm) {
		// remove class "aplicable-si"
		rowOfTheForm.parent().removeClass();
		// set class "aplicable-no"
		rowOfTheForm.parent().addClass('aplicable-no');
		// find input and select that corresponds to this field and set property "disabled" to "true"
		rowOfTheForm.nextAll('.column3:first').find('input').attr('disabled', true);
		rowOfTheForm.nextAll('.column3:first').find('select').attr('disabled', true);
		
		// get index of result cell
		var indexOfResultCell = rowOfTheForm.parent().index() + 1;
		// set class 'valoracion-no' to entire row of table with class ".valoracion"
		$('.valoracion tr:eq(' + indexOfResultCell + ')').addClass('valoracion-no');
		// value of input field
		var valueOfTheField = getFieldValue(rowOfTheForm.nextAll('.column3:first').find('input'));				

		/* DEACTIVATES FUNCTIONS - TO BE DELETED */
		// reset value of input field
		// rowOfTheForm.nextAll('.column3:first').find('input').val('');				
		// set to empty result cell
		// $('.res-' + indexOfResultCell).text('');
		
		// define data object that will be send through ajax
		var data = {};			
		data['indexOfTheField'] = rowOfTheForm.parent().index() + 1;
		data['idOfTheForm'] = idOfTheForm;
		data['flagOfTheField'] = 0;
		data['valueOfTheField'] = valueOfTheField;
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + numberOfTheStep + '/aplicable/' + idOfTheProject,
			data: data,
			success: function(response) {
				$('.res-' + indexOfResultCell).text(response['valueOfTheField']);
				$('.total-pct').text(response['total_pct']);
			},
			error: function(response) {
				ajaxError();
			}	
		});
	}

	/**
	 * [setClassAplicableYes description]
	 * @param {[type]} rowOfTheForm [description]
	 */
	function setClassAplicableYes(rowOfTheForm) {
		// remove class "aplicable-no"	
		rowOfTheForm.parent().removeClass();
		// set class "aplicable-si"
		rowOfTheForm.parent().addClass('aplicable-si');
		// find input and select that corresponds to this field and set property "disabled" to "false"
		rowOfTheForm.nextAll('.column3:first').find('input').attr('disabled', false);
		rowOfTheForm.nextAll('.column3:first').find('select').attr('disabled', false);
		// index of result cell
		var indexOfResultCell = rowOfTheForm.parent().index() + 1;
		$('.valoracion tr:eq(' + indexOfResultCell + ')').removeClass('valoracion-no');
		// value of input field
		var valueOfTheField = getFieldValue(rowOfTheForm.nextAll('.column3:first').find('input'));			
		// define data object that will be send through ajax
		var data = {};			
		data['indexOfTheField'] = rowOfTheForm.parent().index() + 1;
		data['idOfTheForm'] = idOfTheForm;
		data['flagOfTheField'] = 1;
		data['valueOfTheField'] = valueOfTheField;		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + numberOfTheStep + '/aplicable/' + idOfTheProject,
			data: data,
			success: function(response) {
				$('.res-' + indexOfResultCell).text(response['valueOfTheField']);
				$('.total-pct').text(response['total_pct']);
			},
			error: function(response) {
				ajaxError();
			}	
		});
	}	

	// on keyup/input send value and retrieve result and total
	$('form input:text').on('keyup', function() {
		// define data object that will be send through ajax
		var data = {};
		var idOfTheField = {};
		idOfTheField[$(this).attr('id')] = $(this).val();
		// get field's index in form
		var indexOfTheField = $(this).parent().parent().index() + 1;
		// get field's id and value 		
		data['indexOfTheField'] = indexOfTheField;
		data['idOfTheForm'] = idOfTheForm;		
		data['idOfTheField'] = idOfTheField;
		data['valueOfTheField'] = $(this).val();				
		// set border style on result cell that corresponds to this field		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + numberOfTheStep + '/calculus/' + idOfTheProject,
			data: data,
			success: function(response) {
				// if is a valid value then				
				if(response['valid'] == true) {
					// remove any present generated html errors 
					$('.errors').remove();								
				} else {
					// if is an invalid value then loop through each error message
					$.each(response.valid, function(i, val) {
						// get field's id
						var idOfTheField = i;
						$.each(response.valid[i], function(j, val) {
							var errorMessage = val;
							$('.errors').remove();
							$('#' + idOfTheField).parent().append('<ul class="errors"><li>' + errorMessage + '</li></ul>');
						});	    				 
		    		});	    					    			
		    	}
			},
			// if the ajax call failed
			error: function(response) {					
				ajaxError();			
			}
		});	    	
	});
		
	// on load page disable input and select fields with class "aplicable-no"
	// traverse each row of the form
	$('tr').each(function () {
		// find rows with class "aplicable-no" and set field's property disabled to "true"
		if ($(this).attr('class') == 'aplicable-no') {
			$(this).find('input').attr('disabled', true);
			$(this).find('select').attr('disabled', true);
		}
	});	
		
	// on toggle not-aplicable send flag, value and retrieve result & total		
	$('body').on('click', '.column1', function() {
		if($(this).parent().attr('class') == 'aplicable-si') {			
			setClassAplicableNo($(this));									
		} else if($(this).parent().attr('class') == 'aplicable-no') {
			setClassAplicableYes($(this));			
		}
	});		 	

	// open popover 
	$('a[data-toggle=popover]').popover().click(function(e) {
		e.preventDefault();
		$('a[data-toggle=popover]').not($(this)).popover('hide');				
	});

	// on click	"close" button   of popover 
	$('body').on('click', 'a.right-close', function(e) {
		e.preventDefault();
	  	$(this).parent().parent().parent().parent().find('a.grade-btn').popover('hide');
	});

	// on submit popover form	   
	$('body').on('submit', '.popover-content form', function(e) {		    	
		// remove border for cells's row
		$(this).parent().parent().parent().parent().find('> td').addClass('valoracion-notselected');		    	
		var context = $(this).parent().parent().parent().parent().find('a.grade-btn');
		// set border on selected cell
		$(this).parent().parent().parent().removeClass('valoracion-notselected');	
		$(this).parent().parent().parent().addClass('valoracion-selected');			    		    		  
		// get field's index
		var indexOfTheField = ($(this).parent().parent().parent().parent().index() + 1);		
		if(checkIfFieldIsEmpty($('.forms tr:eq(' + indexOfTheField + ') input'))){
			$('.res-' + indexOfTheField).css({'border' : '1px solid red', 'padding' : '4px'});		
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: baseUrl + numberOfTheStep + '/comments/' + idOfTheProject,
				data: {indexOfTheField: indexOfTheField, idOfTheForm: idOfTheForm, comments: $(this).parent().parent().parent().index() + 1 + ':' + $(this).find('textarea').val()},
				success: function(response) {
					// get comments from ajax response
					var comments = response.comments.split(':');				
					// set index of cell
					var indexOfTheCell = comments[0] - 1;			    	
			    	// loop over the cells and reset all cells to the empty form of comments
					context.each(function() {				    		
						$(this).popover('destroy');			    	
						$(this).popover({content:'<form method="post"><a class="right-close" title="Cerrar"><img src="' + baseUrl + 'skins/ecometro/img/close.png" alt="" width="16" height="16" /></a><textarea cols="40" rows="4"></textarea><div><div class="left">Comentarios y especificaciones para la valoración</div><div class="right"><input id="submit" class="boton red" type="submit" value="Guardar" name="submit"></input></div></div><div class="clr"></div></form>'});					    		
					});	
			    	
			    	// set the content of the popover of the selected cell
					$('.valoracion tr:eq(' + indexOfTheField + ') td:eq(' + indexOfTheCell + ')').find('> a').popover('destroy');
					$('.valoracion tr:eq(' + indexOfTheField + ') td:eq(' + indexOfTheCell + ')').find('> a').popover({content:'<form method="post"><a class="right-close" title="Cerrar"><img src="' + baseUrl + 'skins/ecometro/img/close.png" alt="" width="16" height="16" /></a><textarea cols="40" rows="4">' + comments[1] + '</textarea><div><div class="left">Comentarios y especificaciones para la valoración</div><div class="right"><input id="submit" class="boton red" type="submit" value="Guardar" name="submit"></input></div></div><div class="clr"></div></form>'});

					// set value in cell
					$('.res-' + response['indexOfTheField']).text(response['valueOfTheField']);
					$('.res-' + indexOfTheField).css('border', 'none');
					// set total in cell
					$('.total-pct').text(response['total_pct']);
				},
				error: function(response) {
					ajaxError();
				}	
			});
		} else {
			// remove border on selected cell
			$(this).parent().parent().parent().addClass('valoracion-notselected');
			alert('Tienes que introducir un valor antes de valorar');
		}		
		e.preventDefault();	
	});

	// hide popover when press key "esc" 
	$(document).keyup(function(e) {
		if (e.keyCode == 27) { $('a[data-toggle=popover]').popover('hide'); } 
	});

	// hide popover when click outside popover 	
	$('html').click(function() {
		$('a[data-toggle=popover]').popover('hide');
	});

	$('a[data-toggle=popover]').click(function(event) {
	    event.stopPropagation();
	});

	$('html').on('click', '.popover', function(event) {		
	    event.stopPropagation();
	});		
			
	// equals heights of results, valoracion and form rows (5px border - 1px border = 4px)		
	$('table.forms tbody').find('> tr').each(function(index, value) {		
		$('table.valoracion tbody tr:eq(' + index + ')').height($(this).height() - 4);
		$('table.results tbody tr:eq(' + index + ')').height($(this).height() - 4);
	});					   	

	// equals heights of results, valoracion and form table's header
	var heightOfTheResultsHeader = $('table.results thead th').height();
	$('table.valoracion thead th').height(heightOfTheResultsHeader);
	$('table.forms thead th').height(heightOfTheResultsHeader + 10);

	// remove <br> tags
	$('.column3 br').remove();

	$('.red').click(function() {		
		$('form[id^=step3-]').submit();
		return false;
	});
});	