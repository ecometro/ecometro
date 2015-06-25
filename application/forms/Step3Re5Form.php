<?php
/**
* Formulario RE 5: Dotaciones y accesibilidad para bicicletas, peatones y coches
*/
 class Form_Step3Re5Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
		// set action, id, class and method		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre5'), 'step3Route'))
			 ->setAttribs(array( 		  		
 				'id' => 'step3-re5',
 		  		'class' => 'mp' 				
 				))
 			 	->setMethod('post'); 	

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 			 
 			 	
 		// add element: aparcamiento_para_bicicletas textbox
		$aparcamiento_para_bicicletas = $this->createElement('text', 'aparcamiento_para_bicicletas');
		$aparcamiento_para_bicicletas->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aparcamiento para bicicletas'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($aparcamiento_para_bicicletas);
		
 		// add element: accesibilidad textbox
		$accesibilidad = $this->createElement('radio', 'accesibilidad');
		$accesibilidad->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Accesibilidad'));
					//->setRequired(true)										
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$accesibilidad->addMultiOptions($options);
		$this->addElement($accesibilidad);		 						

		// add element: aparcamiento_para_coches textbox
		$aparcamiento_para_coches = $this->createElement('text', 'aparcamiento_para_coches');
		$aparcamiento_para_coches->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aparcamiento para coches'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($aparcamiento_para_coches);
		
		// add element: aparcamiento_para_coches_electricos textbox
		$aparcamiento_para_coches_electricos = $this->createElement('text', 'aparcamiento_para_coches_electricos');
		$aparcamiento_para_coches_electricos->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aparcamiento para coches eléctricos'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($aparcamiento_para_coches_electricos);
		
		// add element: aparcamiento_para_coches_compartidos textbox
		$aparcamiento_para_coches_compartidos = $this->createElement('text', 'aparcamiento_para_coches_compartidos');
		$aparcamiento_para_coches_compartidos->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aparcamiento para coches compartidos'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($aparcamiento_para_coches_compartidos);
		
		// add element: demanda_energetica_transporte textbox
		$demanda_energetica_transporte = $this->createElement('text', 'demanda_energetica_transporte');
		$demanda_energetica_transporte->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda energética transporte (v. eléctricos)'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_energetica_transporte);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_5.phtml'))));
 	}
 }