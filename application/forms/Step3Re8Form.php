<?php
/**
* Formulario RE 8: Ambiente local. Otras emisiones. Luz. Ruido, vibraciones
*/
 class Form_Step3Re8Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre8'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re8',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 		
 		// add element: emision_de_ruido textbox
		$emision_de_ruido = $this->createElement('radio', 'emision_de_ruido');
		$emision_de_ruido->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisión de ruido'));
						//->setRequired(true);		
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$emision_de_ruido->addMultiOptions($options);
		$this->addElement($emision_de_ruido);		 						
		
		// add element: emision_de_luz textbox
		$emision_de_luz = $this->createElement('radio', 'emision_de_luz');
		$emision_de_luz->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisión de luz'));
						//->setRequired(true);		
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$emision_de_luz->addMultiOptions($options);
		$this->addElement($emision_de_luz);
		
		// add element: comentarios textarea
		$comentarios = $this->createElement('textarea', 'comentarios',  array('rows' => '4'));
		$comentarios->addFilter('StripTags')
					->addFilter('HtmlEntities')
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_8.phtml'))));
 	}
 }