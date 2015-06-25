// Shortcut with fail-safe usage of $. Keep in mind that a reference
// to the jQuery function is passed into the anonymous function.
// Use $() without fear of conflicts.
jQuery(function ($) {			
		
	// get project's id
	var idOfTheProject = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var parts = $('form').attr('id').split('-');
	// get step's number
	var numberOfTheStep = parts[0];
	// get form's id (ex.: mp1, re1)
	var idOfTheForm = parts[1];
	// set base url
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
		// value of input field
		var valueOfTheField = getFieldValue(rowOfTheForm.nextAll('.column3:first').find('input'));						
		// define data object that will be send through ajax
		var data = {};			
		data['indexOfTheField'] = rowOfTheForm.parent().index() + 1;
		data['idOfTheForm'] = idOfTheForm;
		data['flagOfTheField'] = 0;	
		data['valueOfTheField'] = valueOfTheField;		
		// make the ajax call
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + numberOfTheStep + '/aplicable/' + idOfTheProject,
			data: data,
			success: function(response) {					
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
		// value of input field
		var valueOfTheField = getFieldValue(rowOfTheForm.nextAll('.column3:first').find('input'));				
		// define data object that will be send through ajax
		var data = {};			
		data['indexOfTheField'] = rowOfTheForm.parent().index() + 1;
		data['idOfTheForm'] = idOfTheForm;
		data['flagOfTheField'] = 1;			
		// make the ajax call
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseUrl + numberOfTheStep + '/aplicable/' + idOfTheProject,
			data: data,
			success: function(response) {					
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
		if ($(this).attr('class') == 'aplicable-no') {
			$(this).find('input').prop('disabled', true);
			$(this).find('select').prop('disabled', true);
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

	// remove <br> tags
	$('.column3 br').remove(); 	
});	