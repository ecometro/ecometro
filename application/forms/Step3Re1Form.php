<?php
/**
* Formulario RE 1: Compacidad y complejidad
*/
 class Form_Step3Re1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre1'), 'step3Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step3-re1',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post'); 			 	
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);

 		// add element: numero_de_viviendas textbox
		$numero_de_viviendas = $this->createElement('text', 'numero_de_viviendas');
		$numero_de_viviendas->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Número de viviendas'))
							//->setRequired(true)						
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))		
		$this->addElement($numero_de_viviendas);

		// add element: suelo_de_uso_pulbico textbox
		$suelo_de_uso_pulbico = $this->createElement('text', 'suelo_de_uso_pulbico');
		$suelo_de_uso_pulbico->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Suelo de uso público'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($suelo_de_uso_pulbico);
		
		// add element: volumen_edificado textbox
		$volumen_edificado = $this->createElement('text', 'volumen_edificado');
		$volumen_edificado->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Volumen edificado'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($volumen_edificado);
		
		// add element: superficie_verde textbox
		$superficie_verde = $this->createElement('text', 'superficie_verde');
		$superficie_verde->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie verde'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_verde);
		
		// add element: superficie_artificial textbox
		$superficie_artificial = $this->createElement('text', 'superficie_artificial');
		$superficie_artificial->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie artificial'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_artificial);
		
		// add element: superficie_de_uso_no_residencial textbox
		$superficie_de_uso_no_residencial = $this->createElement('text', 'superficie_de_uso_no_residencial');
		$superficie_de_uso_no_residencial->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie de uso no residencial'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_de_uso_no_residencial);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_1.phtml'))));
 	}
 }