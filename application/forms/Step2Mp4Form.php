<?php
/**
* Formulario MP 4: Valor del suelo. Ecosistemas
*/
 class Form_Step2Mp4Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
		// set action, id, class and method
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', "action" => "editmp4"), 'step2Route'))		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp4',
 		  		'class' => 'mp' 				
			))
			->setMethod('post'); 			 	
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	 			
 		// add element: naturaleza_riqueza_de_especies_fauna_y_flora textbox
		$naturaleza_riqueza_de_especies_fauna_y_flora = $this->createElement('text', 'naturaleza_riqueza_de_especies_fauna_y_flora');
		$naturaleza_riqueza_de_especies_fauna_y_flora->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Naturaleza. Riqueza de especies. Fauna y flora.'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($naturaleza_riqueza_de_especies_fauna_y_flora);

		// add element: naturaleza_numero_de_especies_identificadas textbox
		$naturaleza_numero_de_especies_identificadas = $this->createElement('text', 'naturaleza_numero_de_especies_identificadas');
		$naturaleza_numero_de_especies_identificadas->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Naturaleza. Número de especies identificadas.'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($naturaleza_numero_de_especies_identificadas);
		
		// add element: ecosistemas_tipo_de_paisaje_inventario_nacional_inp textbox
		$ecosistemas_tipo_de_paisaje_inventario_nacional_inp = $this->createElement('text', 'ecosistemas_tipo_de_paisaje_inventario_nacional_inp');
		$ecosistemas_tipo_de_paisaje_inventario_nacional_inp->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ecosistemas. Tipo de Paisaje. Inventario nacional INP'))
														//->setRequired(true)														
														->addFilter('StripTags')														
														->addFilter('StringTrim')
														->setAttrib('size', 30);
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($ecosistemas_tipo_de_paisaje_inventario_nacional_inp);
				
		// add element: ecosistemas_habitat textbox
		$ecosistemas_habitat = $this->createElement('text', 'ecosistemas_habitat');
		$ecosistemas_habitat->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ecosistemas. Hábitat'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($ecosistemas_habitat);

		// add element: agricultura_cultivos_sobrecarga textbox
		$agricultura_cultivos_sobrecarga = $this->createElement('text', 'agricultura_cultivos_sobrecarga');
		$agricultura_cultivos_sobrecarga->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agricultura. Cultivos sobrecarga'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agricultura_cultivos_sobrecarga);
		
		// add element: agricultura_cultivos_uso textbox
		$agricultura_cultivos_uso = $this->createElement('text', 'agricultura_cultivos_uso');
		$agricultura_cultivos_uso->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agricultura. Cultivos uso'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agricultura_cultivos_uso);
		
		// add element: naturaleza_espacio_protegido_o_de_interes textbox
		$naturaleza_espacio_protegido_o_de_interes = $this->createElement('radio', 'naturaleza_espacio_protegido_o_de_interes');
		$naturaleza_espacio_protegido_o_de_interes->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Naturaleza. Espacio protegido o de interés.'));
												//->setRequired(true)
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$naturaleza_espacio_protegido_o_de_interes->addMultiOptions($options);
		$this->addElement($naturaleza_espacio_protegido_o_de_interes);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_4.phtml'))));
 	}
 }