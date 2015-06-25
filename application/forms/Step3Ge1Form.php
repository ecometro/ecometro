<?php
/**
* Formulario GE 1:  Energías renovables in-situ. Emisiones de CO2eq
*/
 class Form_Step3Ge1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{ 		 					
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editge1'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-ge1',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);		 
 			 
 		// add element: calificacion_energetica_emisiones_por_calefaccion textbox
		$calificacion_energetica_emisiones_por_calefaccion = $this->createElement('text', 'calificacion_energetica_emisiones_por_calefaccion');
		$calificacion_energetica_emisiones_por_calefaccion->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calificación energética emisiones por calefacción'))
														//->setRequired(true)														
														->addFilter('StripTags')														
														->addFilter('StringTrim')
														->setAttrib('size', 30);					
														//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($calificacion_energetica_emisiones_por_calefaccion);		
		
		// add element: calificacion_energetica_emisiones_por_refrigeracion textbox
		$calificacion_energetica_emisiones_por_refrigeracion = $this->createElement('text', 'calificacion_energetica_emisiones_por_refrigeracion');
		$calificacion_energetica_emisiones_por_refrigeracion->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calificación energética  emisiones por  refrigeración'))
															//->setRequired(true)															
															->addFilter('StripTags')															
															->addFilter('StringTrim')
															->setAttrib('size', 30);					
															//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($calificacion_energetica_emisiones_por_refrigeracion);
		
		// add element: calificacion_energetica_emisiones_por_acs textbox
		$calificacion_energetica_emisiones_por_acs = $this->createElement('text', 'calificacion_energetica_emisiones_por_acs');
		$calificacion_energetica_emisiones_por_acs->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calificación energética  emisiones por ACS'))
												//->setRequired(true)												
												->addFilter('StripTags')												
												->addFilter('StringTrim')
												->setAttrib('size', 30);					
												//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($calificacion_energetica_emisiones_por_acs);
		
		// add element: emisiones_por_calefaccion textbox
		$emisiones_por_calefaccion = $this->createElement('text', 'emisiones_por_calefaccion');
		$emisiones_por_calefaccion->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisiones por calefacción'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);					
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($emisiones_por_calefaccion);
		
		// add element: emisiones_por_refrigeracion textbox
		$emisiones_por_refrigeracion = $this->createElement('text', 'emisiones_por_refrigeracion');
		$emisiones_por_refrigeracion->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisiones por refrigeración'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);					
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($emisiones_por_refrigeracion);
		
		// add element: emisiones_por_acs textbox
		$emisiones_por_acs = $this->createElement('text', 'emisiones_por_acs');
		$emisiones_por_acs->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Emisiones por ACS'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($emisiones_por_acs);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_ge_1.phtml'))));
 	}
 }