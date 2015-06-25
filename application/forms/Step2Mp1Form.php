<?php
/**
* Formulario MP 1: Compacidad y complejidad
*/
 class Form_Step2Mp1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp1'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp1',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			
 		// add element: densidad_de_habitantes textbox
		$densidad_de_habitantes = $this->createElement('text', 'densidad_de_habitantes');
		$densidad_de_habitantes->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Densidad de habitantes'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($densidad_de_habitantes);

		// add element: densidad_de_viviendas textbox
		$densidad_de_viviendas = $this->createElement('text', 'densidad_de_viviendas');
		$densidad_de_viviendas->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Densidad de viviendas'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($densidad_de_viviendas);
		
		// add element: superficie_urbana textbox
		$superficie_urbana = $this->createElement('text', 'superficie_urbana');
		$superficie_urbana->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie urbana'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($superficie_urbana);
		
		// add element: volumen_edificado textbox
		$volumen_edificado = $this->createElement('text', 'volumen_edificado');
		$volumen_edificado->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Volumen edificado'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($volumen_edificado);
		
		// add element: area_verde_urbana textbox
		$area_verde_urbana = $this->createElement('text', 'area_verde_urbana');
		$area_verde_urbana->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Área verde urbana'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($area_verde_urbana);
		
		// add element: superficie_de_uso_no_residencial textbox
		$superficie_de_uso_no_residencial = $this->createElement('text', 'superficie_de_uso_no_residencial');
		$superficie_de_uso_no_residencial->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie de uso no residencial'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_de_uso_no_residencial);
		
		// add element: numero_de_actividades_diferentes textbox
		$numero_de_actividades_diferentes = $this->createElement('text', 'numero_de_actividades_diferentes');
		$numero_de_actividades_diferentes->setLabel('<span>h.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Número de actividades diferentes'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator('int')
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($numero_de_actividades_diferentes);
		
		// add element: superficie_artificial textbox
		$superficie_artificial = $this->createElement('text', 'superficie_artificial');
		$superficie_artificial->setLabel('<span>i.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Superficie artificial'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
		//$superficie_artificial->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($superficie_artificial);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_1.phtml'))));
 	}
 }