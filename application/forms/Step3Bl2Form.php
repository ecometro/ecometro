<?php
/**
* Formulario BL 2:  Calidad de la luminación, acceso solar, vistas, ruido
*/
 class Form_Step3Bl2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 					
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbl2'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bl2',
 		  		'class' => 'mp' 				
 				))
 			->setMethod('post');
 			 
 		// add element: factor_luz_dia textbox
		$factor_luz_dia = $this->createElement('radio', 'factor_luz_dia');
		$factor_luz_dia->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Factor luz día'));
						//->setRequired(true);		
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$factor_luz_dia->addMultiOptions($options);
		$this->addElement($factor_luz_dia);

		// add element: control_de_sistemas_de_sombreamiento textbox
		$control_de_sistemas_de_sombreamiento = $this->createElement('radio', 'control_de_sistemas_de_sombreamiento');
		$control_de_sistemas_de_sombreamiento->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Control de sistemas de sombreamiento'));
											//->setRequired(true);		
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$control_de_sistemas_de_sombreamiento->addMultiOptions($options);
		$this->addElement($control_de_sistemas_de_sombreamiento);
		
		// add element: acceso_solar_en_estancias_principales textbox
		$acceso_solar_en_estancias_principales = $this->createElement('radio', 'acceso_solar_en_estancias_principales');
		$acceso_solar_en_estancias_principales->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Acceso solar en estancias principales'));
											//->setRequired(true);		
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$acceso_solar_en_estancias_principales->addMultiOptions($options);
		$this->addElement($acceso_solar_en_estancias_principales);
		
		// add element: linea_visual_profundidad textbox
		$linea_visual_profundidad = $this->createElement('radio', 'linea_visual_profundidad');
		$linea_visual_profundidad->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('línea visual.  profundidad> 10m en estancias'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$linea_visual_profundidad->addMultiOptions($options);
		$this->addElement($linea_visual_profundidad);
		
		// add element: confort_acustico_atenuacion_de_ruido textbox
		$confort_acustico_atenuacion_de_ruido = $this->createElement('radio', 'confort_acustico_atenuacion_de_ruido');
		$confort_acustico_atenuacion_de_ruido->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Confort acústico. Atenuación de ruido'));
											//->setRequired(true);		
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$confort_acustico_atenuacion_de_ruido->addMultiOptions($options);
		$this->addElement($confort_acustico_atenuacion_de_ruido);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bl_2.phtml'))));
 	}
 }