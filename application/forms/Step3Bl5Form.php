<?php
/**
* Formulario BL 5:  Energía en uso. Otros
*/
 class Form_Step3Bl5Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method	
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbl5'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bl5',
 		  		'class' => 'mp' 				
 				))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	
    		 
 		// add element: demanda_para_iluminacion_interior textbox
		$demanda_para_iluminacion_interior = $this->createElement('text', 'demanda_para_iluminacion_interior');
		$demanda_para_iluminacion_interior->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda para iluminación interior'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30)	;				
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_para_iluminacion_interior);				
		
		// add element: demanda_para_iluminacion_exterior textbox
		$demanda_para_iluminacion_exterior = $this->createElement('text', 'demanda_para_iluminacion_exterior');
		$demanda_para_iluminacion_exterior->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda para iluminación exterior'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_para_iluminacion_exterior);

		// add element: equipos_y_electrodomesticos_eficientes textbox
		$equipos_y_electrodomesticos_eficientes = $this->createElement('radio', 'equipos_y_electrodomesticos_eficientes');
		$equipos_y_electrodomesticos_eficientes->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Equipos y electrodomésticos eficientes'));
											//->setRequired(true);											
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$equipos_y_electrodomesticos_eficientes->addMultiOptions($options);
		$this->addElement($equipos_y_electrodomesticos_eficientes);
		
		// add element: espacio_para_tender_la_ropa textbox
		$espacio_para_tender_la_ropa = $this->createElement('radio', 'espacio_para_tender_la_ropa');
		$espacio_para_tender_la_ropa->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Espacio para tender la ropa'));
									//->setRequired(true);	
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$espacio_para_tender_la_ropa->addMultiOptions($options);
		$this->addElement($espacio_para_tender_la_ropa);
		
		// add element: ascensores_y_escaleras_mecanicas_eficientes textbox
		$ascensores_y_escaleras_mecanicas_eficientes = $this->createElement('radio', 'ascensores_y_escaleras_mecanicas_eficientes');
		$ascensores_y_escaleras_mecanicas_eficientes->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ascensores y escaleras mecánicas eficientes'));
												//->setRequired(true);												
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$ascensores_y_escaleras_mecanicas_eficientes->addMultiOptions($options);
		$this->addElement($ascensores_y_escaleras_mecanicas_eficientes);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bl_5.phtml'))));
 	}
 }