<?php
/**
* Formulario MP 6: Calidad del aire exterior
*/
 class Form_Step2Mp6Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp6'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp6',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			
 		// add element: so2_numero_de_dias_que_se_supera_el_limite textbox
		$so2_numero_de_dias_que_se_supera_el_limite = $this->createElement('text', 'so2_numero_de_dias_que_se_supera_el_limite');
		$so2_numero_de_dias_que_se_supera_el_limite->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('SO2: Número de días que se supera el límite'))
												//->setRequired(true)
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($so2_numero_de_dias_que_se_supera_el_limite);

		// add element: co_numero_de_dias_que_se_supera_el_limite textbox
		$co_numero_de_dias_que_se_supera_el_limite = $this->createElement('text', 'co_numero_de_dias_que_se_supera_el_limite');
		$co_numero_de_dias_que_se_supera_el_limite->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('CO: Número de días que se supera el límite'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($co_numero_de_dias_que_se_supera_el_limite);
					
		// add element: nox_numero_de_dias_que_se_supera_el_limite textbox
		$nox_numero_de_dias_que_se_supera_el_limite = $this->createElement('text', 'nox_numero_de_dias_que_se_supera_el_limite');
		$nox_numero_de_dias_que_se_supera_el_limite->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('NOx: Número de días que se supera el límite'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($nox_numero_de_dias_que_se_supera_el_limite);

		// add element: o3_numero_de_dias_que_se_supera_el_limite textbox
		$o3_numero_de_dias_que_se_supera_el_limite = $this->createElement('text', 'o3_numero_de_dias_que_se_supera_el_limite');
		$o3_numero_de_dias_que_se_supera_el_limite->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('O3: Número de días que se supera el límite'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($o3_numero_de_dias_que_se_supera_el_limite);
		
		// add element: pm10_numero_de_dias_que_se_supera_el_limite textbox
		$pm10_numero_de_dias_que_se_supera_el_limite = $this->createElement('text', 'pm10_numero_de_dias_que_se_supera_el_limite');
		$pm10_numero_de_dias_que_se_supera_el_limite->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('PM10: Número de días que se supera el límite'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->addValidator($validatorFloat)
												->setAttrib('size', 30);
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($pm10_numero_de_dias_que_se_supera_el_limite);
		
		// add element: localizacion_de_fuentes_de_contaminacion_cercanas textbox
		$localizacion_de_fuentes_de_contaminacion_cercanas = $this->createElement('radio', 'localizacion_de_fuentes_de_contaminacion_cercanas');
		$localizacion_de_fuentes_de_contaminacion_cercanas->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Localización de fuentes de contaminación cercanas'));
														//->setRequired(true)														
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$localizacion_de_fuentes_de_contaminacion_cercanas->addMultiOptions($options);
		$this->addElement($localizacion_de_fuentes_de_contaminacion_cercanas);
		
		// add element: olores textbox
		$olores = $this->createElement('radio', 'olores');
		$olores->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Olores'));
				//->setRequired(true);
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$olores->addMultiOptions($options);
		$this->addElement($olores);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_6.phtml'))));
 	}
 }