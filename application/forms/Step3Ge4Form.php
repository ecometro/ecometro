<?php
/**
* Formulario GE 4:  Otras Emisiones
*/
 class Form_Step3Ge4Form extends Zend_Form
 {
	/**
	* initialize form
	*/
 	public function init()
 	{ 		 					
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editge4'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ge4',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 
 		// add element: emisiones_nox_de_sistemas textbox
		$emisiones_nox_de_sistemas = $this->createElement('radio', 'emisiones_nox_de_sistemas');
		$emisiones_nox_de_sistemas->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisiones NOx de sistemas'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$emisiones_nox_de_sistemas->addMultiOptions($options);
		$this->addElement($emisiones_nox_de_sistemas);		 								
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ge_4.phtml'))));
 	}
 }