<?php
/**
* Formulario MP 9: Radiación no ionizante. Campos electromagnéticos
*/
 class Form_Step2Mp9Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
		// set action, id, class and method
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp9'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp9',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	 			
 		// add element: radiacion_ambiental textbox
		$radiacion_ambiental = $this->createElement('text', 'radiacion_ambiental');
		$radiacion_ambiental->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Radiación ambiental'))
							//->setRequired(true)							
							->addFilter('StripTags')						
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($radiacion_ambiental);

		// add element: gas_radon textbox
		$gas_radon = $this->createElement('text', 'gas_radon');
		$gas_radon->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Gas radón'))
					//->setRequired(true)					
					->addFilter('StripTags')										
					->addFilter('StringTrim')
					->addValidator($validatorFloat)
					->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($gas_radon);		
		
		// add element: comentarios textarea
		$comentarios = $this->createElement('textarea', 'comentarios',  array('rows' => '4'));
		$comentarios->addFilter('StripTags')
					->addFilter('HtmlEntities')
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_9.phtml'))));
 	}
 }