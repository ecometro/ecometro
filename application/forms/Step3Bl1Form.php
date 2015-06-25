<?php
/**
* Formulario BL 1:  Confort higrotérmico
*/
 class Form_Step3Bl1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbl1'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bl1',
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
		$horas_fuera_de_la_zona_de_confort->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Horas fuera de la zona de confort (8-24)'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($horas_fuera_de_la_zona_de_confort);		
		
		// add element: ` textarea
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bl_1.phtml'))));
 	}
 }