<?php
/**
* Formulario BC 5: Equipos refrigerantes. Evitar la emisión de gases que perjudiquen la capa de ozono
*/
 class Form_Step3Bc5Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		
 		// set action, id, class and method	
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc5'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc5',
 		  		'class' => 'mp' 				
 				))
 			->setMethod('post');

 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	 
 			 
 		// add element: se_utilizan_refrigerantes textbox
		$se_utilizan_refrigerantes = $this->createElement('radio', 'se_utilizan_refrigerantes');
		$se_utilizan_refrigerantes->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Se utilizan refrigerantes'));
								//->setRequired(true);		
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$options = array(
			0 => 'No',
			1 => 'Si',
		);
		$se_utilizan_refrigerantes->addMultiOptions($options);
		$this->addElement($se_utilizan_refrigerantes);
 			
 		// add element: odp_segun_el_tipo_de_refrigerante textbox
		$odp_segun_el_tipo_de_refrigerante = $this->createElement('text', 'odp_segun_el_tipo_de_refrigerante');
		$odp_segun_el_tipo_de_refrigerante->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('ODP según el tipo de refrigerante'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($odp_segun_el_tipo_de_refrigerante);		

		// add element: gwp_segun_el_tipo_de_refrigerante textbox
		$gwp_segun_el_tipo_de_refrigerante = $this->createElement('text', 'gwp_segun_el_tipo_de_refrigerante');
		$gwp_segun_el_tipo_de_refrigerante->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('GWP según el tipo de refrigerante'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($gwp_segun_el_tipo_de_refrigerante);	
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_5.phtml'))));
 	}
 }