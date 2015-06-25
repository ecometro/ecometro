<?php
/**
* Formulario MP 13: Redes locales. Recursos
*/
 class Form_Step2Mp13Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method	
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp13'), 'step2Route')) 		
			->setAttribs(array(
			 	'id' => 'step2-mp13',
			 	'class' => 'mp'
			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validator = new Zend_Validate_Float();
    	$validator->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	
    		 			
 		// add element: materiales_locales textbox
		$materiales_locales = $this->createElement('text', 'materiales_locales');
		$materiales_locales->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Materiales locales'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($materiales_locales);
		
		// add element: masa_de_agua_subterranea textbox
		$masa_de_agua_subterranea = $this->createElement('radio', 'masa_de_agua_subterranea');
		$masa_de_agua_subterranea->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Masa de agua subterránea'));
								//->setRequired(true)								
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$masa_de_agua_subterranea->addMultiOptions($options);
		$this->addElement($masa_de_agua_subterranea);
		
		// add element: afloramientos_permeables textbox
		$afloramientos_permeables = $this->createElement('radio', 'afloramientos_permeables');
		$afloramientos_permeables->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Afloramientos permeables'));
								//->setRequired(true)								
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$afloramientos_permeables->addMultiOptions($options);
		$this->addElement($afloramientos_permeables);
		
		// add element: red_de_control_de_estado_quimico textbox
		$red_de_control_de_estado_quimico = $this->createElement('radio', 'red_de_control_de_estado_quimico');
		$red_de_control_de_estado_quimico->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Red de control de estado químico'));
										//->setRequired(true)										
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$red_de_control_de_estado_quimico->addMultiOptions($options);
		$this->addElement($red_de_control_de_estado_quimico);
		
		// add element: pluviometria textbox
		$pluviometria = $this->createElement('text', 'pluviometria');
		$pluviometria->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Pluviometría'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim')
					->addValidator($validator)
					->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($pluviometria);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_13.phtml'))));
 	}
 }