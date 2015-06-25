<?php
/**
* Formulario MP 8: Radiación ionizante
*/
 class Form_Step2Mp8Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp8'), 'step2Route')) 		
			->setAttribs(array( 		  		
				'id' => 'step2-mp8',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			
 		// add element: campos_estaticos textbox
		$campos_estaticos = $this->createElement('text', 'campos_estaticos');
		$campos_estaticos->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Campos estáticos'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($campos_estaticos);

		// add element: radiaciones_naturales textbox
		$radiaciones_naturales = $this->createElement('radio', 'radiaciones_naturales');
		$radiaciones_naturales->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Radiaciones naturales'));
							//->setRequired(true)														
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$radiaciones_naturales->addMultiOptions($options);
		$this->addElement($radiaciones_naturales);

		// add element: baja_frecuencia_campo_magnetico textbox
		$baja_frecuencia_campo_magnetico = $this->createElement('text', 'baja_frecuencia_campo_magnetico');
		$baja_frecuencia_campo_magnetico->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Baja frecuencia. Campo magnético'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($baja_frecuencia_campo_magnetico);
		
		// add element: baja_frecuencia_campo_electrico textbox
		$baja_frecuencia_campo_electrico = $this->createElement('text', 'baja_frecuencia_campo_electrico');
		$baja_frecuencia_campo_electrico->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Baja frecuencia. Campo eléctrico'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($baja_frecuencia_campo_electrico);

		// add element: alta_frecuencia textbox
		$alta_frecuencia = $this->createElement('text', 'alta_frecuencia');
		$alta_frecuencia->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Alta frecuencia'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($alta_frecuencia);

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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_8.phtml'))));
 	}
 }