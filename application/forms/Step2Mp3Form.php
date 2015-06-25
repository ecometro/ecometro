<?php
/**
* Formulario MP 3: Valor del suelo. Permeabilidad y gestión de escorrentías
*/
 class Form_Step2Mp3Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{

 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp3'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp3',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: evapotranspiracion_real textbox
		$evapotranspiracion_real = $this->createElement('text', 'evapotranspiracion_real');
		$evapotranspiracion_real->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Evapotranspiración real'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);	
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($evapotranspiracion_real);

		// add element: evapotranspiracion_potencial textbox
		$evapotranspiracion_potencial = $this->createElement('text', 'evapotranspiracion_potencial');
		$evapotranspiracion_potencial->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Evapotranspiración potencial'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);	
		//$evapotranspiracion_potencial->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($evapotranspiracion_potencial);
		
		// add element: humedad_del_suelo textbox
		$humedad_del_suelo = $this->createElement('text', 'humedad_del_suelo');
		$humedad_del_suelo->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Humedad del suelo'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($humedad_del_suelo);
		
		// add element: escorrentias_zonas_vulnerables textbox
		$escorrentias_zonas_vulnerables = $this->createElement('radio', 'escorrentias_zonas_vulnerables');
		$escorrentias_zonas_vulnerables->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Escorrentías. Zonas vulnerables'));
									//->setRequired(true)
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$escorrentias_zonas_vulnerables->addMultiOptions($options);
		$this->addElement($escorrentias_zonas_vulnerables);
		
		// add element: escorrentias_zonas_sensibles textbox
		$escorrentias_zonas_sensibles = $this->createElement('radio', 'escorrentias_zonas_sensibles');
		$escorrentias_zonas_sensibles->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Escorrentías. Zonas sensibles'));
									//->setRequired(true)									
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$escorrentias_zonas_sensibles->addMultiOptions($options);
		$this->addElement($escorrentias_zonas_sensibles);
		
		// add element: escorrentias_zona_de_captacion_de_zona_sensible textbox
		$escorrentias_zona_de_captacion_de_zona_sensible = $this->createElement('radio', 'escorrentias_zona_de_captacion_de_zona_sensible');
		$escorrentias_zona_de_captacion_de_zona_sensible->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Escorrentías. Zona de captación de zona sensible'));
													//->setRequired(true)													
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$escorrentias_zona_de_captacion_de_zona_sensible->addMultiOptions($options);
		$this->addElement($escorrentias_zona_de_captacion_de_zona_sensible);
		
		// add element: permeabilidad textbox
		$permeabilidad = $this->createElement('select', 'permeabilidad');
		$permeabilidad->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Litoestratigrafía. Permeabilidad'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim');
		//$permeabilidad->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => 'Elige',
			'Muy alta' => 'Muy alta',
			'Alta' => 'Alta',
			'Media' => 'Media',
			'Baja' => 'Baja',
			'Muy baja' => 'Muy baja',	
		);
		$permeabilidad->addMultiOptions($options);
		$this->addElement($permeabilidad);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_3.phtml'))));
 	}
 }