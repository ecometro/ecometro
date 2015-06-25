<?php
/**
* Formulario MP 7: Ambiente local. Ruido exterior. Luz
*/
 class Form_Step2Mp7Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp7'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp7',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 	
 			 		
 		// add element: ruido_aereo_ambiental_diurno textbox
		$ruido_aereo_ambiental_diurno = $this->createElement('text', 'ruido_aereo_ambiental_diurno');
		$ruido_aereo_ambiental_diurno->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ruido aéreo ambiental diurno'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($ruido_aereo_ambiental_diurno);

		// add element: ruid_aereo_ambiental_nocturno textbox
		$ruid_aereo_ambiental_nocturno = $this->createElement('text', 'ruid_aereo_ambiental_nocturno');
		$ruid_aereo_ambiental_nocturno->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Ruido aéreo ambiental nocturno'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($ruid_aereo_ambiental_nocturno);
					
		// add element: contaminacion_luminica textbox
		$contaminacion_luminica = $this->createElement('text', 'contaminacion_luminica');
		$contaminacion_luminica->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Contaminación lumínica'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($contaminacion_luminica);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_7.phtml'))));
 	}
 }