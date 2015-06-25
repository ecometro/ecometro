<?php
/**
* Formulario MP 11: Redes locales. Energía
*/
 class Form_Step2Mp11Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp11'), 'step2Route')) 		
			 ->setAttribs(array( 		  		
 				'id' => 'step2-mp11',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 			 	
 			 			
 		// add element: es_posible_aportar_energia_electrica_a_la_red textbox
		$es_posible_aportar_energia_electrica_a_la_red = $this->createElement('radio', 'es_posible_aportar_energia_electrica_a_la_red');
		$es_posible_aportar_energia_electrica_a_la_red->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Es posible aportar energía eléctrica a la red'));
													//->setRequired(true)													
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$es_posible_aportar_energia_electrica_a_la_red->addMultiOptions($options);
		$this->addElement($es_posible_aportar_energia_electrica_a_la_red);

		// add element: otras_redes_locales textbox
		$otras_redes_locales = $this->createElement('text', 'otras_redes_locales');
		$otras_redes_locales->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Otras redes locales'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($otras_redes_locales);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_11.phtml'))));
 	}
 }