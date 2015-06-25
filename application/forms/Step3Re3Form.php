<?php
/**
* Formulario RE 3: Cargas de escorrentía y erosión del suelo
*/
 class Form_Step3Re3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre3'), 'step3Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step3-re3',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post'); 	

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 			 	
 			 		
 		// add element: permeabilidad_del_suelo textbox
		$permeabilidad_del_suelo = $this->createElement('text', 'permeabilidad_del_suelo');
		$permeabilidad_del_suelo->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Permeabilidad del suelo'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($permeabilidad_del_suelo);

		// add element: cargas_de_agua_pluvial_a_la_red textbox
		$cargas_de_agua_pluvial_a_la_red = $this->createElement('text', 'cargas_de_agua_pluvial_a_la_red');
		$cargas_de_agua_pluvial_a_la_red->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cargas de agua pluvial a la red'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cargas_de_agua_pluvial_a_la_red);
		
		// add element: erosion_del_suelo textbox
		$erosion_del_suelo = $this->createElement('text', 'erosion_del_suelo');
		$erosion_del_suelo->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Erosión del suelo'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);					
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($erosion_del_suelo);
				
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_3.phtml'))));
 	}
 }