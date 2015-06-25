<?php
/**
* Formulario MP 16: Cargas existentes. Energía y agua
*/
 class Form_Step2Mp16Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp16'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp16',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			
 		// add element: energia_calefaccion textbox
		$energia_calefaccion = $this->createElement('text', 'energia_calefaccion');
		$energia_calefaccion->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Calefacción'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_calefaccion);		
		
		// add element: energia_refrigeracion textbox
		$energia_refrigeracion = $this->createElement('text', 'energia_refrigeracion');
		$energia_refrigeracion->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Refrigeración'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_refrigeracion);
		
		// add element: energia_acs textbox
		$energia_acs = $this->createElement('text', 'energia_acs');
		$energia_acs->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. ACS'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim')
					->addValidator($validatorFloat)
					->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_acs);
		
		// add element: energia_iluminacion_exterior textbox
		$energia_iluminacion_exterior = $this->createElement('text', 'energia_iluminacion_exterior');
		$energia_iluminacion_exterior->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Iluminación exterior'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_iluminacion_exterior);
		
		// add element: energia_iluminacion_interior textbox
		$energia_iluminacion_interior = $this->createElement('text', 'energia_iluminacion_interior');
		$energia_iluminacion_interior->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Iluminación interior'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_iluminacion_interior);
		
		// add element: energia_equipos textbox
		$energia_equipos = $this->createElement('text', 'energia_equipos');
		$energia_equipos->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Equipos'))
						//->setRequired(true)								
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_equipos);
		
		// add element: energia_compania_de_suministro textbox
		$energia_compania_de_suministro = $this->createElement('text', 'energia_compania_de_suministro');
		$energia_compania_de_suministro->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Energía. Compañía de suministro'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($energia_compania_de_suministro);
		
		// add element: agua_consumo_de_agua_potable textbox
		$agua_consumo_de_agua_potable = $this->createElement('text', 'agua_consumo_de_agua_potable');
		$agua_consumo_de_agua_potable->setLabel('<span>h.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agua. Consumo de agua potable'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agua_consumo_de_agua_potable);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_16.phtml'))));
 	}
 }