<?php
/**
* Formulario BC 8: Control en obra. Calidad del aire, energía agua materiales.
*/
 class Form_Step3Bc8Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 		
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc8'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc8',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	
    		 
 		// add element: consumo_de_energia_en_obra textbox
		$consumo_de_energia_en_obra = $this->createElement('text', 'consumo_de_energia_en_obra');
		$consumo_de_energia_en_obra->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de energía en obra'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_energia_en_obra);		

		// add element: consumo_de_agua_en_obra textbox
		$consumo_de_agua_en_obra = $this->createElement('text', 'consumo_de_agua_en_obra');
		$consumo_de_agua_en_obra->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Consumo de agua en obra'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_agua_en_obra);	
		
 		// add element: control_en_obra_de_la_calidad_del_aire_interior textbox
		$control_en_obra_de_la_calidad_del_aire_interior = $this->createElement('radio', 'control_en_obra_de_la_calidad_del_aire_interior');
		$control_en_obra_de_la_calidad_del_aire_interior->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control en obra de la calidad del aire interior'));
														//->setRequired(true);		
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_en_obra_de_la_calidad_del_aire_interior->addMultiOptions($options);
		$this->addElement($control_en_obra_de_la_calidad_del_aire_interior);				
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_8.phtml'))));
 	}
 }