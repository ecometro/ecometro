<?php
/**
* Formulario BC 1: Recursos. Ciclo de vida de los materiales
*/
 class Form_Step3Bc1Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc1'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc1',
 		  		'class' => 'mp' 				
			))
			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: calentamiento_global textbox
		$calentamiento_global = $this->createElement('text', 'calentamiento_global');
		$calentamiento_global->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Calentamiento global'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($calentamiento_global);

		// add element: agotamiento_de_la_capa_de_ozoono textbox
		$agotamiento_de_la_capa_de_ozoono = $this->createElement('text', 'agotamiento_de_la_capa_de_ozoono');
		$agotamiento_de_la_capa_de_ozoono->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agotamiento de la capa de ozono'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agotamiento_de_la_capa_de_ozoono);
		
		// add element: acidificacion textbox
		$acidificacion = $this->createElement('text', 'acidificacion');
		$acidificacion->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Acidificación'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim')
					->addValidator($validatorFloat)
					->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($acidificacion);
		
		// add element: eutrofizacion textbox
		$eutrofizacion = $this->createElement('text', 'eutrofizacion');
		$eutrofizacion->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Eutrofización'))
					//->setRequired(true)					
					->addFilter('StripTags')					
					->addFilter('StringTrim')
					->addValidator($validatorFloat)
					->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($eutrofizacion);
		
		// add element: creacion_de_ozono_fotoquimico textbox
		$creacion_de_ozono_fotoquimico = $this->createElement('text', 'creacion_de_ozono_fotoquimico');
		$creacion_de_ozono_fotoquimico->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Creación de ozono fotoquímico'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($creacion_de_ozono_fotoquimico);
		
		// add element: agotamiento_de_recursos_abioticos_elementos textbox
		$agotamiento_de_recursos_abioticos_elementos = $this->createElement('text', 'agotamiento_de_recursos_abioticos_elementos');
		$agotamiento_de_recursos_abioticos_elementos->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agotamiento de recursos abióticos-elementos'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agotamiento_de_recursos_abioticos_elementos);
				
		// add element: agotamiento_de_recursos_abioticos_combustibles textbox
		$agotamiento_de_recursos_abioticos_combustibles = $this->createElement('text', 'agotamiento_de_recursos_abioticos_combustibles');
		$agotamiento_de_recursos_abioticos_combustibles->setLabel('<span>g.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Agotamiento de recursos abióticos-combustibles f'))
													//->setRequired(true)													
													->addFilter('StripTags')													
													->addFilter('StringTrim')
													->addValidator($validatorFloat)
													->setAttrib('size', 30);
													//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agotamiento_de_recursos_abioticos_combustibles);
		
		// add element: vida_util_del_edificio textbox
		$vida_util_del_edificio = $this->createElement('text', 'vida_util_del_edificio');
		$vida_util_del_edificio->setLabel('<span>h.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Vida útil del edificio'))
								//->setRequired(true);
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($vida_util_del_edificio);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_1.phtml'))));
 	}
 }