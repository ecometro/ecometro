<?php
/**
* Formulario BL 3:  Calidad del aire. Ventilación. Control.
*/
 class Form_Step3Bl3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbl3'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bl3',
 		  		'class' => 'mp' 				
 				))
 			->setMethod('post');
 			 
 		// add element: ventilacion_cruzada textbox
		$ventilacion_cruzada = $this->createElement('radio', 'ventilacion_cruzada');
		$ventilacion_cruzada->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ventilación cruzada'));
							//->setRequired(true);		
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$ventilacion_cruzada->addMultiOptions($options);
		$this->addElement($ventilacion_cruzada);

		// add element: sensores_de_co2 textbox
		$sensores_de_co2 = $this->createElement('radio', 'sensores_de_co2');
		$sensores_de_co2->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Sensores de CO2'));
						//->setRequired(true);		
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$sensores_de_co2->addMultiOptions($options);
		$this->addElement($sensores_de_co2);
		
		// add element: control_de_las_zonas_de_admision textbox
		$control_de_las_zonas_de_admision = $this->createElement('radio', 'control_de_las_zonas_de_admision');
		$control_de_las_zonas_de_admision->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control de las zonas de admisión'));
										//->setRequired(true);		
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_de_las_zonas_de_admision->addMultiOptions($options);
		$this->addElement($control_de_las_zonas_de_admision);
		
		// add element: mantenimiento_y_limpieza textbox
		$mantenimiento_y_limpieza = $this->createElement('radio', 'mantenimiento_y_limpieza');
		$mantenimiento_y_limpieza->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Mantenimiento y limpieza'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$mantenimiento_y_limpieza->addMultiOptions($options);
		$this->addElement($mantenimiento_y_limpieza);				
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bl_3.phtml'))));
 	}
 }