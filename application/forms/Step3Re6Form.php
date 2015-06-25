<?php
/**
* Formulario RE 6: Clima local y efecto isla de calor
*/
 class Form_Step3Re6Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre6'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re6',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			 	
 		// add element: indice_de_reflectancia_cubiertas_y_suelos textbox
		$indice_de_reflectancia_cubiertas_y_suelos = $this->createElement('text', 'indice_de_reflectancia_cubiertas_y_suelos');
		$indice_de_reflectancia_cubiertas_y_suelos->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Índice de reflectancia cubiertas y suelos'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);					
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($indice_de_reflectancia_cubiertas_y_suelos);
		
		// add element: equipos_emisores_de_calor textbox
		$equipos_emisores_de_calor = $this->createElement('text', 'equipos_emisores_de_calor');
		$equipos_emisores_de_calor->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Equipos emisores de calor'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($equipos_emisores_de_calor);
		
		// add element: area_verde_en_cubiertas_y_suelos textbox
		$area_verde_en_cubiertas_y_suelos = $this->createElement('text', 'area_verde_en_cubiertas_y_suelos');
		$area_verde_en_cubiertas_y_suelos->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Área verde en cubiertas y suelos'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);						
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($area_verde_en_cubiertas_y_suelos);
		
 		// add element: obstruccion_solar_y_de_vientos textbox
		$obstruccion_solar_y_de_vientos = $this->createElement('radio', 'obstruccion_solar_y_de_vientos');
		$obstruccion_solar_y_de_vientos->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Obstrucción solar y de vientos'));
									//->setRequired(true);		
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$obstruccion_solar_y_de_vientos->addMultiOptions($options);
		$this->addElement($obstruccion_solar_y_de_vientos);		 						
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_6.phtml'))));
 	}
}