<?php
/**
* Formulario RE 2: Suelo desarrollado
*/
 class Form_Step3Re2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre2'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re2',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post'); 

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 				 	
 			
 		// add element: aplicacion_de_medidas_para_la_regeneracion textbox
		$aplicacion_de_medidas_para_la_regeneracion = $this->createElement('radio', 'aplicacion_de_medidas_para_la_regeneracion');
		$aplicacion_de_medidas_para_la_regeneracion->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Aplicación de medidas para la regeneración'));
													//->setRequired(true)																										
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$aplicacion_de_medidas_para_la_regeneracion->addMultiOptions($options);
		$this->addElement($aplicacion_de_medidas_para_la_regeneracion);

		// add element: descontaminar textbox
		$descontaminar = $this->createElement('radio', 'descontaminar');
		$descontaminar->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Descontaminar'));
					//->setRequired(true)					
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$descontaminar->addMultiOptions($options);
		$this->addElement($descontaminar);
		
		// add element: se_han_tratado_otros_riesgos textbox
		$se_han_tratado_otros_riesgos = $this->createElement('radio', 'se_han_tratado_otros_riesgos');
		$se_han_tratado_otros_riesgos->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Se han tratado otros riesgos'));
									//->setRequired(true)									
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$se_han_tratado_otros_riesgos->addMultiOptions($options);
		$this->addElement($se_han_tratado_otros_riesgos);

		// add element: suelo_ocupado textbox
		$suelo_ocupado = $this->createElement('text', 'suelo_ocupado');
		$suelo_ocupado->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Suelo ocupado'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($suelo_ocupado);

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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_2.phtml'))));
 	}
 }