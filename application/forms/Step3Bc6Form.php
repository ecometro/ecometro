<?php
/**
* Formulario BC 6: Compuestos Orgánicos Volátiles en uso. Tasa de emisión
*/
 class Form_Step3Bc6Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 		
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc6'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc6',
 		  		'class' => 'mp' 				
 				))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: materiales_en_base_madera textbox
		$materiales_en_base_madera = $this->createElement('text', 'materiales_en_base_madera');
		$materiales_en_base_madera->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Materiales en base madera'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($materiales_en_base_madera);		

		// add element: acabados_suelos textbox
		$acabados_suelos = $this->createElement('text', 'acabados_suelos');
		$acabados_suelos->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Acabados suelos'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);						
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($acabados_suelos);	
		
		// add element: adhesivos_y_sellantes textbox
		$adhesivos_y_sellantes = $this->createElement('text', 'adhesivos_y_sellantes');
		$adhesivos_y_sellantes->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Adhesivos y sellantes'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($adhesivos_y_sellantes);

		// add element: acabados_tabiqueria textbox
		$acabados_tabiqueria = $this->createElement('text', 'acabados_tabiqueria');
		$acabados_tabiqueria->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Acabados, tabiquería'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($acabados_tabiqueria);
		
		// add element: acabados_pinturas textbox
		$acabados_pinturas = $this->createElement('text', 'acabados_pinturas');
		$acabados_pinturas->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Acabados, pinturas.'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);						
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($acabados_pinturas);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_6.phtml'))));
 	}
 }