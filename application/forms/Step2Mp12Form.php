<?php
/**
* Formulario MP 12: Redes locales. Agua
*/
 class Form_Step2Mp12Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 		
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', "action"=>"editmp12"), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp12',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post'); 			 	
 			 		
 		// add element: suministro_de_agua_potable textbox
		$suministro_de_agua_potable = $this->createElement('radio', 'suministro_de_agua_potable');
		$suministro_de_agua_potable->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Suministro de agua potable'));
								//->setRequired(true)
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$suministro_de_agua_potable->addMultiOptions($options);
		$this->addElement($suministro_de_agua_potable);
		
		// add element: suministro_de_agua_reciclada_no_potable textbox
		$suministro_de_agua_reciclada_no_potable = $this->createElement('radio', 'suministro_de_agua_reciclada_no_potable');
		$suministro_de_agua_reciclada_no_potable->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Suministro de agua reciclada/ no potable'));
											//->setRequired(true)	
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$suministro_de_agua_reciclada_no_potable->addMultiOptions($options);
		$this->addElement($suministro_de_agua_reciclada_no_potable);
		
		// add element: red_separativa_de_evacuacion textbox
		$red_separativa_de_evacuacion = $this->createElement('radio', 'red_separativa_de_evacuacion');
		$red_separativa_de_evacuacion->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Red separativa de evacuación'));
									//->setRequired(true)									
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$red_separativa_de_evacuacion->addMultiOptions($options);
		$this->addElement($red_separativa_de_evacuacion);
		
		// add element: estacion_depuradora_de_aguas_residuales_edar textbox
		$estacion_depuradora_de_aguas_residuales_edar = $this->createElement('radio', 'estacion_depuradora_de_aguas_residuales_edar');
		$estacion_depuradora_de_aguas_residuales_edar->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Estación depuradora de aguas residuales EDAR'));
													//->setRequired(true)													
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$estacion_depuradora_de_aguas_residuales_edar->addMultiOptions($options);
		$this->addElement($estacion_depuradora_de_aguas_residuales_edar);
		
		// add element: tipo_de_tratamiento_de_la_depuradora textbox
		$tipo_de_tratamiento_de_la_depuradora = $this->createElement('text', 'tipo_de_tratamiento_de_la_depuradora');
		$tipo_de_tratamiento_de_la_depuradora->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Tipo de tratamiento de la depuradora'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->setAttrib('size', 30);
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($tipo_de_tratamiento_de_la_depuradora);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_12.phtml'))));
 	}
 }