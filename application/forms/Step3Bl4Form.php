<?php
/**
* Formulario BL 4:  Energía en uso. Térmicos
*/
 class Form_Step3Bl4Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 			
		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbl4'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bl4',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 
 		// add element: calificacion_demanda_de_calefaccion textbox
		$calificacion_demanda_de_calefaccion = $this->createElement('text', 'calificacion_demanda_de_calefaccion');
		$calificacion_demanda_de_calefaccion->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calificación demanda de calefacción'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->setAttrib('size', 30)	;				
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($calificacion_demanda_de_calefaccion);				
		
		// add element: calificacion_demanda_de_refrigeracion textbox
		$calificacion_demanda_de_refrigeracion = $this->createElement('text', 'calificacion_demanda_de_refrigeracion');
		$calificacion_demanda_de_refrigeracion->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calificación demanda de refrigeración'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->setAttrib('size', 30);					
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($calificacion_demanda_de_refrigeracion);
		
		// add element: demanda_de_acs textbox
		$demanda_de_acs = $this->createElement('text', 'demanda_de_acs');
		$demanda_de_acs->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda de ACS'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim')
					->addValidator($validatorFloat)
					->setAttrib('size', 30);					
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_de_acs);
		
		// add element: demanda_de_calefaccion textbox
		$demanda_de_calefaccion = $this->createElement('text', 'demanda_de_calefaccion');
		$demanda_de_calefaccion->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda de calefacción'))
								//>setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_de_calefaccion);
		
		// add element: demanda_de_refrigeracion textbox
		$demanda_de_refrigeracion = $this->createElement('text', 'demanda_de_refrigeracion');
		$demanda_de_refrigeracion->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda de refrigeración'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_de_refrigeracion);
		
		// add element: demanda_de_acs_2 textbox
		$demanda_de_acs_2 = $this->createElement('text', 'demanda_de_acs_2');
		$demanda_de_acs_2->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Demanda de ACS'))
						//->setRequired(true)						
						->addFilter('StripTags')						
						->addFilter('StringTrim')
						->addValidator($validatorFloat)
						->setAttrib('size', 30);					
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($demanda_de_acs_2);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bl_4.phtml'))));
 	}
 }