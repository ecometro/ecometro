<?php
/**
* Formulario RE 11: Espacio para reciclar basuras y compostaje
*/
 class Form_Step3Re11Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre11'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re11',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 		
 		// add element: hay_espacio_disponible_para_reciclar_basuras textbox
		$hay_espacio_disponible_para_reciclar_basuras = $this->createElement('radio', 'hay_espacio_disponible_para_reciclar_basuras');
		$hay_espacio_disponible_para_reciclar_basuras->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Hay espacio disponible para reciclar basuras?'));
													//->setRequired(true);		
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$hay_espacio_disponible_para_reciclar_basuras->addMultiOptions($options);
		$this->addElement($hay_espacio_disponible_para_reciclar_basuras);		 						
		
		// add element: hay_espacio_disponible_para_compostaje textbox
		$hay_espacio_disponible_para_compostaje = $this->createElement('radio', 'hay_espacio_disponible_para_compostaje');
		$hay_espacio_disponible_para_compostaje->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Hay espacio disponible para compostaje?'));
											//->setRequired(true);		
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$hay_espacio_disponible_para_compostaje->addMultiOptions($options);
		$this->addElement($hay_espacio_disponible_para_compostaje);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_11.phtml'))));
 	}
 }