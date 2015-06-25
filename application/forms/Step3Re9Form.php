<?php
/**
* Formulario RE 9: Radiación no ionizante.  Campos electromagnéticos
*/
 class Form_Step3Re9Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editre9'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-re9',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 			 		
 		// add element: alteraciones_geofisicas_radiacion_gamma textbox
		$alteraciones_geofisicas_radiacion_gamma = $this->createElement('radio', 'alteraciones_geofisicas_radiacion_gamma');
		$alteraciones_geofisicas_radiacion_gamma->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Alteraciones geofísicas (radiación gamma)'));
												//->setRequired(true);		
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$alteraciones_geofisicas_radiacion_gamma->addMultiOptions($options);
		$this->addElement($alteraciones_geofisicas_radiacion_gamma);		 						
		
		// add element: campos_electricos_bf textbox
		$campos_electricos_bf = $this->createElement('radio', 'campos_electricos_bf');
		$campos_electricos_bf->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Campos eléctricos bf'));
							//->setRequired(true);		
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$campos_electricos_bf->addMultiOptions($options);
		$this->addElement($campos_electricos_bf);
		
		// add element: campos_electromagneticos_alta_frecuencia textbox
		$campos_electromagneticos_alta_frecuencia = $this->createElement('radio', 'campos_electromagneticos_alta_frecuencia');
		$campos_electromagneticos_alta_frecuencia->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Campos electromagnéticos alta frecuencia'));
												//->setRequired(true);		
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$campos_electromagneticos_alta_frecuencia->addMultiOptions($options);
		$this->addElement($campos_electromagneticos_alta_frecuencia);
		
		// add element: campos_magneticos_bf textbox
		$campos_magneticos_bf = $this->createElement('radio', 'campos_magneticos_bf');
		$campos_magneticos_bf->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Campos magnéticos bf'));
							//->setRequired(true);		
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$campos_magneticos_bf->addMultiOptions($options);
		$this->addElement($campos_magneticos_bf);
		
		// add element: radioactividad_ambiental textbox
		$radioactividad_ambiental = $this->createElement('radio', 'radioactividad_ambiental');
		$radioactividad_ambiental->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Radioactividad ambiental'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$radioactividad_ambiental->addMultiOptions($options);
		$this->addElement($radioactividad_ambiental);
		
		// add element: redes_geomagneticas textbox
		$redes_geomagneticas = $this->createElement('radio', 'redes_geomagneticas');
		$redes_geomagneticas->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Redes geomagnéticas'));
							//->setRequired(true);		
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$redes_geomagneticas->addMultiOptions($options);
		$this->addElement($redes_geomagneticas);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_re_9.phtml'))));
 	}
}