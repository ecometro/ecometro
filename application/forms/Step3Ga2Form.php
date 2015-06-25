<?php
/**
* Formulario GA 2: Control del agua de suministro. (calidad del agua)
*/
 class Form_Step3Ga2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editga2'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ga2',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 
 		// add element: control_de_la_calidad_del_agua_de_suministro textbox
		$control_de_la_calidad_del_agua_de_suministro = $this->createElement('radio', 'control_de_la_calidad_del_agua_de_suministro');
		$control_de_la_calidad_del_agua_de_suministro->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control de la calidad del agua de suministro'));
													//->setRequired(true);		
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_de_la_calidad_del_agua_de_suministro->addMultiOptions($options);
		$this->addElement($control_de_la_calidad_del_agua_de_suministro);
		
		// add element: control_del_consumo_de_agua textbox
		$control_del_consumo_de_agua = $this->createElement('radio', 'control_del_consumo_de_agua');
		$control_del_consumo_de_agua->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control del consumo de agua'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_del_consumo_de_agua->addMultiOptions($options);
		$this->addElement($control_del_consumo_de_agua);
		
		// add element: sistema_de_deteccion_de_fugas textbox
		$sistema_de_deteccion_de_fugas = $this->createElement('radio', 'sistema_de_deteccion_de_fugas');
		$sistema_de_deteccion_de_fugas->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Sistema de detección de fugas'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$sistema_de_deteccion_de_fugas->addMultiOptions($options);
		$this->addElement($sistema_de_deteccion_de_fugas);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ga_2.phtml'))));
 	}
 }