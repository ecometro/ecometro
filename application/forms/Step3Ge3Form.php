<?php
/**
* Formulario GE 3:  Control en uso de la energía. Información. Monitorización. Mantenimiento.
*/
 class Form_Step3Ge3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editge3'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ge3',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 
 		// add element: sistema_de_control_de_temperatura_por_zonas textbox
		$sistema_de_control_de_temperatura_por_zonas = $this->createElement('radio', 'sistema_de_control_de_temperatura_por_zonas');
		$sistema_de_control_de_temperatura_por_zonas->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Sistema de control de temperatura por zonas'));
													//->setRequired(true);		
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$sistema_de_control_de_temperatura_por_zonas->addMultiOptions($options);
		$this->addElement($sistema_de_control_de_temperatura_por_zonas);		 		
				
		// add element: sistema_de_monitorizacion textbox
		$sistema_de_monitorizacion = $this->createElement('radio', 'sistema_de_monitorizacion');
		$sistema_de_monitorizacion->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Sistema de monitorización'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$sistema_de_monitorizacion->addMultiOptions($options);
		$this->addElement($sistema_de_monitorizacion);
		
		// add element: guia_de_uso_y_mantenimiento textbox
		$guia_de_uso_y_mantenimiento = $this->createElement('radio', 'guia_de_uso_y_mantenimiento');
		$guia_de_uso_y_mantenimiento->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Guía de uso y mantenimiento'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$guia_de_uso_y_mantenimiento->addMultiOptions($options);
		$this->addElement($guia_de_uso_y_mantenimiento);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ge_3.phtml'))));
 	}
 }