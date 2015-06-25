<?php
/**
* Formulario BC 7: Control en obra. Gestión de residuos.
*/
 class Form_Step3Bc7Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 		
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc7'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc7',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 
 		// add element: separacion_selectiva textbox
		$separacion_selectiva = $this->createElement('radio', 'separacion_selectiva');
		$separacion_selectiva->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Separación selectiva'));
							//->setRequired(true);		
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$separacion_selectiva->addMultiOptions($options);
		$this->addElement($separacion_selectiva);
		
 		// add element: residuos_derivados_a_vertedero textbox
		$residuos_derivados_a_vertedero = $this->createElement('text', 'residuos_derivados_a_vertedero');
		$residuos_derivados_a_vertedero->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Residuos derivados a vertedero'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($residuos_derivados_a_vertedero);		

		// add element: residuos_separados textbox
		$residuos_separados = $this->createElement('text', 'residuos_separados');
		$residuos_separados->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Residuos separados'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($residuos_separados);	
		
		// add element: residos_peligrosos textbox
		$residos_peligrosos = $this->createElement('text', 'residos_peligrosos');
		$residos_peligrosos->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Residuos peligrosos'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);					
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($residos_peligrosos);

		// add element: movimiento_de_tierras textbox
		$movimiento_de_tierras = $this->createElement('text', 'movimiento_de_tierras');
		$movimiento_de_tierras->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Movimiento de tierras'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($movimiento_de_tierras);
		
		// add element: transporte_a_vertedero textbox
		$transporte_a_vertedero = $this->createElement('text', 'transporte_a_vertedero');
		$transporte_a_vertedero->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Transporte a vertedero'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($transporte_a_vertedero);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_7.phtml'))));
 	}
 }