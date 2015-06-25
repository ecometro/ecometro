<?php
/**
* Formulario GA 4: Control del agua evacuada
*/
 class Form_Step3Ga4Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editga4'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ga4',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 
 		// add element: control_de_depracion_in_situ textbox
		$control_de_depracion_in_situ = $this->createElement('radio', 'control_de_depracion_in_situ');
		$control_de_depracion_in_situ->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control de depuración in situ'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_de_depracion_in_situ->addMultiOptions($options);
		$this->addElement($control_de_depracion_in_situ);					
		
		// add element: control_de_calidad_de_agua_evacuada textbox
		$control_de_calidad_de_agua_evacuada = $this->createElement('radio', 'control_de_calidad_de_agua_evacuada');
		$control_de_calidad_de_agua_evacuada->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control de calidad de agua evacuada'));
											//->setRequired(true);		
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_de_calidad_de_agua_evacuada->addMultiOptions($options);
		$this->addElement($control_de_calidad_de_agua_evacuada);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ga_4.phtml'))));
 	}
 }