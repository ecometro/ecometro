<?php
/**
* Formulario MP 2: Valor del suelo. Ocupación y riesgos
*/
 class Form_Step2Mp2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 	
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp2'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp2',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post'); 			 	

 		// add element: categorizacion_urbana_siose textbox
		$categorizacion_urbana_siose = $this->createElement('select', 'categorizacion_urbana_siose', array('RegisterInArrayValidator' => false));
		$categorizacion_urbana_siose->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Categorización urbana SIOSE'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim');
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => 'Elige',
			'Urbano-mixto-Casco' => 'Urbano mixto - Casco', 
			'Urbano-mixto-Ensanche' => 'Urbano mixto - Ensanche',
			'Urbano-mixto-Discontinuo' => 'Urbano mixto - Discontinuo',
			'Otras-construcciones' => 'Otras construcciones',
			'Artificial-no-edificado' => 'Artificial no edificado',
			'Asentamiento-agricola-residencial' => 'Asentamiento agrícola residencial',
			'Huerta-familiar' => 'Huerta familiar',
			'Dotacional' => 'Dotacional',
			'Parques-y-zonas verdes urbanas' => 'Parques y zonas verdes urbanas',
			'Terciario' => 'Terciario',
			'Industrial' => 'Industrial',
			'Infraestructuras-de-transporte' => 'Infraestructuras de transporte',
			'Infraestructuras-de-energia-agua' => 'Infraestructuras de energía, agua y otras',
			'Minas-y-canteras' => 'Minas y canteras',
			'Cultivos' => 'Cultivos',
			'Forestal-y-dehesas' => 'Forestal y dehesas',
			'Aguas-continentales' => 'Aguas continentales',
			'Zonas-humedas' => 'Zonas húmedas',
			'Terrenos-naturales' => 'Terrenos naturales sin vegetación',
		);
		$categorizacion_urbana_siose->addMultiOptions($options);
		$this->addElement($categorizacion_urbana_siose);
			 	
		// add element: ocupacion_del_suelo_corine_2000 textbox
		$ocupacion_del_suelo_corine_2000 = $this->createElement('select', 'ocupacion_del_suelo_corine_2000', array('RegisterInArrayValidator' => false));
		$ocupacion_del_suelo_corine_2000->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ocupación del suelo CORINE 2000'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim');
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => 'Elige',
			'Tejido-urbano-continuo' => 'Tejido urbano continuo', 
			'Tejido-urbano-discontinuo' => 'Tejido urbano discontinuo',
			'Zonas-industriales-o-comerciales' => 'Zonas industriales o comerciales',
			'Redes-viarias-y-ferroviarias' => 'Redes viarias y ferroviarias',
			'Zonas-portuarias' => 'Zonas portuarias',
			'Zonas-industriales o comerciales' => 'Zonas industriales o comerciales',
			'Aeropuertos' => 'Aeropuertos',
			'Escombreras-y-vertederos' => 'Escombreras y vertederos',
			'Zonas-en-construccion' => 'Zonas en construcción',
			'Zonas-verdes-urbanas' => 'Zonas verdes urbanas',
			'Instalaciones-deportivas-y-recreativas' => 'Instalaciones deportivas y recreativas',
			'Zonas-agricolas' => 'Zonas agrícolas',
			'Zonas-forestales' => 'Zonas forestales',
			'Zonas-humedas' => 'Zonas húmedas',
			'Masas-de-agua' => 'Masas de agua',							
		);
		$ocupacion_del_suelo_corine_2000->addMultiOptions($options);
		$this->addElement($ocupacion_del_suelo_corine_2000);
		
		// add element: ocupacion_del_suelo_corine_2006 textbox
		$ocupacion_del_suelo_corine_2006 = $this->createElement('select', 'ocupacion_del_suelo_corine_2006', array('RegisterInArrayValidator' => false));
		$ocupacion_del_suelo_corine_2006->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ocupación del suelo CORINE 2006'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim');
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => 'Elige',
			'Tejido-urbano-continuo' => 'Tejido urbano continuo', 
			'Tejido-urbano-discontinuo' => 'Tejido urbano discontinuo',
			'Zonas-industriales-o-comerciales' => 'Zonas industriales o comerciales',
			'Redes-viarias-y-ferroviarias' => 'Redes viarias y ferroviarias',
			'Zonas-portuarias' => 'Zonas portuarias',
			'Zonas-industriales o comerciales' => 'Zonas industriales o comerciales',
			'Aeropuertos' => 'Aeropuertos',
			'Escombreras-y-vertederos' => 'Escombreras y vertederos',
			'Zonas-en-construccion' => 'Zonas en construcción',
			'Zonas-verdes-urbanas' => 'Zonas verdes urbanas',
			'Instalaciones-deportivas-y-recreativas' => 'Instalaciones deportivas y recreativas',
			'Zonas-agricolas' => 'Zonas agrícolas',
			'Zonas-forestales' => 'Zonas forestales',
			'Zonas-humedas' => 'Zonas húmedas',
			'Masas-de-agua' => 'Masas de agua',							
		);
		$ocupacion_del_suelo_corine_2006->addMultiOptions($options);
		$this->addElement($ocupacion_del_suelo_corine_2006);
		
		// add element: cambios_significativos_en_la_ocupacion_del_suelo textbox
		$cambios_significativos_en_la_ocupacion_del_suelo = $this->createElement('radio', 'cambios_significativos_en_la_ocupacion_del_suelo');
		$cambios_significativos_en_la_ocupacion_del_suelo->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cambios significativos en la ocupación del suelo'));
														//->setRequired(true)														
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$cambios_significativos_en_la_ocupacion_del_suelo->addMultiOptions($options);
		$this->addElement($cambios_significativos_en_la_ocupacion_del_suelo);

		// add element: hay_indicios_de_contaminacion_del_suelo textbox
		$hay_indicios_de_contaminacion_del_suelo = $this->createElement('radio', 'hay_indicios_de_contaminacion_del_suelo');
		$hay_indicios_de_contaminacion_del_suelo->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('¿Hay indicios de contaminación del suelo?'));
												//->setRequired(true)												
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$hay_indicios_de_contaminacion_del_suelo->addMultiOptions($options);
		$this->addElement($hay_indicios_de_contaminacion_del_suelo);
		
		// add element: riesgo_de_erosion_potencial_del_suelo textbox
		$riesgo_de_erosion_potencial_del_suelo = $this->createElement('select', 'riesgo_de_erosion_potencial_del_suelo');
		$riesgo_de_erosion_potencial_del_suelo->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('BDN. Riesgo de erosión potencial del suelo'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim');
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => 'Elige',
			'Nula o muy baja' => 'Nula o muy baja',
			'Baja o moderada' => 'Baja o moderada',
			'Media' => 'Media',
			'Alta' => 'Alta',
			'Muy alta' => 'Muy alta',
			'Laminas de agua' => 'Laminas de agua',
			'Superficies artificiales' => 'Superficies artificiales',
		);
		$riesgo_de_erosion_potencial_del_suelo->addMultiOptions($options);
		$this->addElement($riesgo_de_erosion_potencial_del_suelo);
		
		// add element: riesgo_potencial_significativo_de_inundacion textbox
		$riesgo_potencial_significativo_de_inundacion = $this->createElement('radio', 'riesgo_potencial_significativo_de_inundacion');
		$riesgo_potencial_significativo_de_inundacion->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Riesgo potencial significativo de inundación'));
													//->setRequired(true)													
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$riesgo_potencial_significativo_de_inundacion->addMultiOptions($options);
		$this->addElement($riesgo_potencial_significativo_de_inundacion);
		
		// add element: zona_inundable_probabilidad textbox
		$zona_inundable_probabilidad = $this->createElement('select', 'zona_inundable_probabilidad', array('RegisterInArrayValidator' => false));
		$zona_inundable_probabilidad->setLabel('<span>h.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agua. Zona inundable. Probabilidad'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim');
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		
		$options = array(
			'' => 'Elige',
			'ARPSI' => 'ARPSI',
			'Alta-probabilidad' => 'Alta probabilidad (10 años)',
			'Frecuente' => 'Frecuente (50 años)',
			'Probabiblidad-media' => 'Probabiblidad media u ocasional (100 años)',
			'Probabilidad-baja' => 'Probabilidad baja o exdcepcional (500 años)',
		);
		$zona_inundable_probabilidad->addMultiOptions($options);
		$this->addElement($zona_inundable_probabilidad);
		
		// add element: algun_otro_riesgo_o_valor_ambiental_relevante textbox
		$algun_otro_riesgo_o_valor_ambiental_relevante = $this->createElement('text', 'algun_otro_riesgo_o_valor_ambiental_relevante');
		$algun_otro_riesgo_o_valor_ambiental_relevante->setLabel('<span>i.</span> ' . Zend_Registry::get('Zend_Translate')->translate('¿Algún otro riesgo o valor ambiental relevante?'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim');
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($algun_otro_riesgo_o_valor_ambiental_relevante);

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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_2.phtml'))));
 	}
 }