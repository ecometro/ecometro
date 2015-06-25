<?php
/**
* Formulario MP 5: Clima local y efecto isla de calor
*/
 class Form_Step2Mp5Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{

 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp5'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp5',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			 	
 		// add element: horas_fuera_de_la_zona_de_confort textbox
		$horas_fuera_de_la_zona_de_confort = $this->createElement('text', 'horas_fuera_de_la_zona_de_confort');
		$horas_fuera_de_la_zona_de_confort->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Horas fuera de la zona de confort'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($horas_fuera_de_la_zona_de_confort);

		// add element: radiacion_solar_directa_horizontal textbox
		$radiacion_solar_directa_horizontal = $this->createElement('text', 'radiacion_solar_directa_horizontal');
		$radiacion_solar_directa_horizontal->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Radiación solar directa (horizontal)'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($radiacion_solar_directa_horizontal);
					
		// add element: obstruccion_solar_y_de_vientos textbox
		$obstruccion_solar_y_de_vientos = $this->createElement('radio', 'obstruccion_solar_y_de_vientos');
		$obstruccion_solar_y_de_vientos->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Obstrucción solar y de vientos'));
									//->setRequired(true)
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$obstruccion_solar_y_de_vientos->addMultiOptions($options);
		$this->addElement($obstruccion_solar_y_de_vientos);
		
		// add element: isla_de_calor_indice_de_reflectancia_medio_local textbox
		$isla_de_calor_indice_de_reflectancia_medio_local = $this->createElement('text', 'isla_de_calor_indice_de_reflectancia_medio_local');
		$isla_de_calor_indice_de_reflectancia_medio_local->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Isla de calor. Índice de reflectancia medio local'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($isla_de_calor_indice_de_reflectancia_medio_local);
		
		// add element: isla_de_calor_numero_de_equipos_emisores_de_calor textbox
		$isla_de_calor_numero_de_equipos_emisores_de_calor = $this->createElement('text', 'isla_de_calor_numero_de_equipos_emisores_de_calor');
		$isla_de_calor_numero_de_equipos_emisores_de_calor->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Isla de calor. Número de equipos emisores de calor'))
														//->setRequired(true)
														->addFilter('StripTags')														
														->addFilter('StringTrim')
														->addValidator($validatorFloat)
														->setAttrib('size', 30);
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($isla_de_calor_numero_de_equipos_emisores_de_calor);

		// add element: isla_de_calor_area_verde textbox
		$isla_de_calor_area_verde = $this->createElement('text', 'isla_de_calor_area_verde');
		$isla_de_calor_area_verde->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Isla de calor. Área verde'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
		//$isla_de_calor_area_verde->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($isla_de_calor_area_verde);

		// add element: comentarios textarea
		$comentarios = $this->createElement('textarea', 'comentarios',  array('rows' => '4'));
		$comentarios->addFilter('StripTags')					
					->addFilter('StringTrim');		
					//->setRequired(true);		
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($comentarios);
				
		$this->setElementDecorators(array(
			"ViewHelper",
			"Errors",			
			array('decorator' => array('td' => 'HtmlTag'), 'options' => array('tag' => 'td', 'class' => 'column3')),
			array('Label', array('tag' => 'td', 'tagClass' => 'column2', 'escape' => false)),						
		));
		
		// add element: user_submit_profile submit button
		$submit = $this->createElement('submit', 'submit');
		$submit->setAttrib('class', 'boton red')
				->setLabel(Zend_Registry::get('Zend_Translate')->translate('Guardar'))
				->removeDecorator('DtDdWrapper')
				->removeDecorator('Label');
		$this->addElement($submit);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_5.phtml'))));
 	}
 }