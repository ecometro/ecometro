<?php
/**
* Formulario MP 10: Redes locales. Movilidad. Dotaciones y acceso al transporte público
*/
 class Form_Step2Mp10Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp10'), 'step2Route')) 		
			 ->setAttribs(array( 		  		
 				'id' => 'step2-mp10',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 		
 		// change text of error message	 for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			 		
 		// add element: distancia_a_parada_de_metro_travia textbox
		$distancia_a_parada_de_metro_travia = $this->createElement('text', 'distancia_a_parada_de_metro_travia');
		$distancia_a_parada_de_metro_travia->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a parada de metro-tranvía'))
										//->setRequired(true)	
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);										
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_a_parada_de_metro_travia);

		// add element: distancia_a_parada_de_tren textbox
		$distancia_a_parada_de_tren = $this->createElement('text', 'distancia_a_parada_de_tren');
		$distancia_a_parada_de_tren->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a parada de tren'))
									//->setRequired(true)
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_a_parada_de_tren);
		
		// add element: distancia_a_parada_de_autobus textbox
		$distancia_a_parada_de_autobus = $this->createElement('text', 'distancia_a_parada_de_autobus');
		$distancia_a_parada_de_autobus->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a parada de autobús'))
										//->setRequired(true)
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);							
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_a_parada_de_autobus);

		// add element: metros_lineales_de_viario textbox
		$metros_lineales_de_viario = $this->createElement('text', 'metros_lineales_de_viario');
		$metros_lineales_de_viario->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Metros lineales de viario'))
									//->setRequired(true)
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);									;
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($metros_lineales_de_viario);
		
		// add element: metros_l_de_viario_para_peatones_y_bicicletas textbox
		$metros_l_de_viario_para_peatones_y_bicicletas = $this->createElement('text', 'metros_l_de_viario_para_peatones_y_bicicletas');
		$metros_l_de_viario_para_peatones_y_bicicletas->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Metros l de viario para peatones y bicicletas'))
													//->setRequired(true)
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);										
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($metros_l_de_viario_para_peatones_y_bicicletas);
		
		// add element: superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion textbox
		$superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion = $this->createElement('text', 'superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion');
		$superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie vial, aparcamiento, zona peatonal sin vegetación'))
																//->setRequired(true)
																->addFilter('StripTags')																
																->addFilter('StringTrim')
																->addValidator($validatorFloat)
																->setAttrib('size', 30);													
																//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion);
		
		// add element: sup_de_viario_para_peatones_y_bicicletas textbox
		$sup_de_viario_para_peatones_y_bicicletas = $this->createElement('text', 'sup_de_viario_para_peatones_y_bicicletas');
		$sup_de_viario_para_peatones_y_bicicletas->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Sup. de viario para peatones y bicicletas'))
												//->setRequired(true)
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($sup_de_viario_para_peatones_y_bicicletas);
		
		// add element: capacidad_de_aparcamiento textbox
		$capacidad_de_aparcamiento = $this->createElement('text', 'capacidad_de_aparcamiento');
		$capacidad_de_aparcamiento->setLabel('<span>h.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Capacidad de aparcamiento'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($capacidad_de_aparcamiento);				
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_10.phtml'))));
 	}
 }