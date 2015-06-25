<?php
/**
* Formulario RE 7: Calidad del aire. Emisones locales
*/
 class Form_Step3Re7Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{

 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre7'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re7',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post'); 
 			 	
 		// add element: emision_co2eq_medio_urbano textbox
		$emision_co2eq_medio_urbano = $this->createElement('radio', 'emision_co2eq_medio_urbano');
		$emision_co2eq_medio_urbano->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisión CO2eq (medio urbano)'));
								//->setRequired(true);								
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$emision_co2eq_medio_urbano->addMultiOptions($options);
		$this->addElement($emision_co2eq_medio_urbano);		 						
		
		// add element: emisiones_nox_medio_urbano textbox
		$emisiones_nox_medio_urbano = $this->createElement('radio', 'emisiones_nox_medio_urbano');
		$emisiones_nox_medio_urbano->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisiones NOx (medio urbano)'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$emisiones_nox_medio_urbano->addMultiOptions($options);
		$this->addElement($emisiones_nox_medio_urbano);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_7.phtml'))));
 	}
}