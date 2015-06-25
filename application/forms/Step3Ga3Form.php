<?php
/**
* Formulario GA 3: Cargas de aguas residuales (cantidad)
*/
 class Form_Step3Ga3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method	
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editga3'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ga3',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 
 		// add element: agua_evacuada_a_la_red_local_domestica textbox
		$agua_evacuada_a_la_red_local_domestica = $this->createElement('text', 'agua_evacuada_a_la_red_local_domestica');
		$agua_evacuada_a_la_red_local_domestica->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agua evacuada a la red local. Doméstica.'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);					
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agua_evacuada_a_la_red_local_domestica);

		// add element: agua_evacuada_a_la_red_local_pluviales textbox
		$agua_evacuada_a_la_red_local_pluviales = $this->createElement('text', 'agua_evacuada_a_la_red_local_pluviales');
		$agua_evacuada_a_la_red_local_pluviales->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agua evacuada a la red local. Pluviales.'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agua_evacuada_a_la_red_local_pluviales);					
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ga_3.phtml'))));
 	}
 }