<?php
/**
* Formulario BC 4: Recursos. Materiales con certificación
*/
 class Form_Step3Bc4Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc4'), 'step3Route'))
			->setAttribs(array( 		  		
 				'id' => 'step3-bc4',
 		  		'class' => 'mp' 				
 			))
 			->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: maderas textbox
		$maderas = $this->createElement('text', 'maderas');
		$maderas->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Maderas'))
				//->setRequired(true)				
				->addFilter('StripTags')				
				->addFilter('StringTrim')
				->addValidator($validatorFloat)
				->setAttrib('size', 30);					
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($maderas);		

		// add element: petreos textbox
		$petreos = $this->createElement('text', 'petreos');
		$petreos->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Pétreos'))
				//->setRequired(true)				
				->addFilter('StripTags')				
				->addFilter('StringTrim')
				->addValidator($validatorFloat)
				->setAttrib('size', 30);					
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($petreos);
		
		// add element: ceramicos textbox
		$ceramicos = $this->createElement('text', 'ceramicos');
		$ceramicos->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cerámicos'))
				//->setRequired(true)				
				->addFilter('StripTags')				
				->addFilter('StringTrim')
				->addValidator($validatorFloat)
				->setAttrib('size', 30);						
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($ceramicos);
		
		// add element: plasticos textbox
		$plasticos = $this->createElement('text', 'plasticos');
		$plasticos->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Plásticos'))
				//->setRequired(true)				
				->addFilter('StripTags')				
				->addFilter('StringTrim')
				->addValidator($validatorFloat)
				->setAttrib('size', 30);					
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($plasticos);
		
		// add element: metales textbox
		$metales = $this->createElement('text', 'metales');
		$metales->setLabel('<span>e.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Metales'))
				//->setRequired(true)				
				->addFilter('StripTags')				
				->addFilter('StringTrim')
				->addValidator($validatorFloat)
				->setAttrib('size', 30);						
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($metales);
		
		// add element: materiales_compuestos textbox
		$materiales_compuestos = $this->createElement('text', 'materiales_compuestos');
		$materiales_compuestos->setLabel('<span>f.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Materiales compuestos'))
							//->setRequired(true)							
							->addFilter('StripTags')							
							->addFilter('StringTrim')
							->addValidator($validatorFloat)
							->setAttrib('size', 30);					
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($materiales_compuestos);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_4.phtml'))));
 	}
 }