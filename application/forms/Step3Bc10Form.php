<?php
/**
* Formulario BC 10: Vida útil y fin de vida de los materiales
*/
 class Form_Step3Bc10Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method	
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc10'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc10',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 
 		// add element: facilidad_de_mantenimiento_y_limpieza textbox
		$facilidad_de_mantenimiento_y_limpieza = $this->createElement('text', 'facilidad_de_mantenimiento_y_limpieza');
		$facilidad_de_mantenimiento_y_limpieza->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Facilidad de mantenimiento y limpieza'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($facilidad_de_mantenimiento_y_limpieza);

		// add element: facilidad_de_separacion_de_componentes textbox
		$facilidad_de_separacion_de_componentes = $this->createElement('text', 'facilidad_de_separacion_de_componentes');
		$facilidad_de_separacion_de_componentes->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Facilidad de separación de componentes. Adaptabilidad y desmontaje'))
												//->setRequired(true)																	
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($facilidad_de_separacion_de_componentes);	
		
		// add element: vida_util_del_edificio textbox
		$vida_util_del_edificio = $this->createElement('text', 'vida_util_del_edificio');
		$vida_util_del_edificio->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Vida útil del edificio'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($vida_util_del_edificio);	
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_10.phtml'))));
 	}
 }