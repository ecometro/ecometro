<?php
/**
* Formulario GE 2:  Tecnologías para la reducción de emisiones de carbono.
*/
 class Form_Step3Ge2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 					
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editge2'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ge2',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 
 			 
 		// add element: contrato_con_la_empresa_verde textbox
		$contrato_con_la_empresa_verde = $this->createElement('radio', 'contrato_con_la_empresa_verde');
		$contrato_con_la_empresa_verde->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Contrato con la empresa "verde"'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$contrato_con_la_empresa_verde->addMultiOptions($options);
		$this->addElement($contrato_con_la_empresa_verde);		 		
		
		// add element: energia_aportada_a_la_red textbox
		$energia_aportada_a_la_red = $this->createElement('text', 'energia_aportada_a_la_red');
		$energia_aportada_a_la_red->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía aportada a la red'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_aportada_a_la_red);				
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ge_2.phtml'))));
 	}
 }