<?php
/**
* Formulario RE 4: Biodiversidad y hábitat en el proyecto
*/
 class Form_Step3Re4Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
		// set action, id, class and method
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre4'), 'step3Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step3-re4',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			 	
 		// add element: aportaciones_a_la_restauracion_del_habitat textbox
		$aportaciones_a_la_restauracion_del_habitat = $this->createElement('radio', 'aportaciones_a_la_restauracion_del_habitat');
		$aportaciones_a_la_restauracion_del_habitat->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aportaciones a la restauración del hábitat'));
												//->setRequired(true)												
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$aportaciones_a_la_restauracion_del_habitat->addMultiOptions($options);
		$this->addElement($aportaciones_a_la_restauracion_del_habitat);
		
 		// add element: numero_de_especies_identificadas textbox
		$numero_de_especies_identificadas = $this->createElement('text', 'numero_de_especies_identificadas');
		$numero_de_especies_identificadas->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Número de especies identificadas. Vegetación'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($numero_de_especies_identificadas);	

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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_4.phtml'))));
 	}
 }