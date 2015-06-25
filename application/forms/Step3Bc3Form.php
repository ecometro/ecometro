<?php
/**
* Formulario BC 3: Recursos de la cuna a la puerta. Transporte a obra
*/
 class Form_Step3Bc3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc3'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc3',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: distacia_media_de_recorrido_de_transporte textbox
		$distacia_media_de_recorrido_de_transporte = $this->createElement('text', 'distacia_media_de_recorrido_de_transporte');
		$distacia_media_de_recorrido_de_transporte->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia media de recorrido de transporte'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);					
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distacia_media_de_recorrido_de_transporte);	

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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_3.phtml'))));
 	}
 }