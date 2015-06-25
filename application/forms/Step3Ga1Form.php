<?php
/**
* Formulario GA 1: Consumo de agua potable (cantidad)
*/
 class Form_Step3Ga1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editga1'), 'step3Route'))
			 ->setAttribs(array( 		  		
 				'id' => 'step3-ga1',
 		  		'class' => 'mp' 				
 				))
 			 ->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 
    	
 		// add element: consumo_de_agua_potable_ducha textbox
		$consumo_de_agua_potable_ducha = $this->createElement('text', 'consumo_de_agua_potable_ducha');
		$consumo_de_agua_potable_ducha->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua potable ducha/ bañera'))
									//->setRequired(true)
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_potable_ducha);

		// add element: consumo_de_agua_potable_cocina textbox
		$consumo_de_agua_potable_cocina = $this->createElement('text', 'consumo_de_agua_potable_cocina');
		$consumo_de_agua_potable_cocina->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua potable cocina'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_potable_cocina);	
		
		// add element: consumo_agua_potable_lavadora textbox
		$consumo_agua_potable_lavadora = $this->createElement('text', 'consumo_agua_potable_lavadora');
		$consumo_agua_potable_lavadora->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo agua potable lavadora'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($consumo_agua_potable_lavadora);	
		
		// add element: consumo_de_agua_potable_lavavajillas textbox
		$consumo_de_agua_potable_lavavajillas = $this->createElement('text', 'consumo_de_agua_potable_lavavajillas');
		$consumo_de_agua_potable_lavavajillas->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua potable lavavajillas'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_potable_lavavajillas);
		
		// add element: consumo_de_agua_potable_inodoro textbox
		$consumo_de_agua_potable_inodoro = $this->createElement('text', 'consumo_de_agua_potable_inodoro');
		$consumo_de_agua_potable_inodoro->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua potable inodoro'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_potable_inodoro);
		
		// add element: consumo_de_agua_potable_para_riego textbox
		$consumo_de_agua_potable_para_riego = $this->createElement('text', 'consumo_de_agua_potable_para_riego');
		$consumo_de_agua_potable_para_riego->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua potable para riego'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_potable_para_riego);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ga_1.phtml'))));
 	}
 }