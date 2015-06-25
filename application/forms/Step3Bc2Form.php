<?php
/**
* Formulario BC 2: Recursos. Origen de los materiales
*/
 class Form_Step3Bc2Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step3', 'action' => 'editbc2'), 'step3Route'))
			 ->setAttribs(array( 		  		
 				'id' => 'step3-bc2',
 		  		'class' => 'mp' 				
 				))
 			 ->setMethod('post');
 		
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    		 	
 		// add element: cantidad_de_material_reutilizado textbox
		$cantidad_de_material_reutilizado = $this->createElement('text', 'cantidad_de_material_reutilizado');
		$cantidad_de_material_reutilizado->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cantidad de material reutilizado'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);					
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cantidad_de_material_reutilizado);

		// add element: cantidad_de_material_reciclado textbox
		$cantidad_de_material_reciclado = $this->createElement('text', 'cantidad_de_material_reciclado');
		$cantidad_de_material_reciclado->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cantidad de material reciclado'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cantidad_de_material_reciclado);
		
		// add element: cantidad_de_material_virgen textbox
		$cantidad_de_material_virgen = $this->createElement('text', 'cantidad_de_material_virgen');
		$cantidad_de_material_virgen->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cantidad de material virgen'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cantidad_de_material_virgen);
		
		// add element: cantidad_de_material_renovable textbox
		$cantidad_de_material_renovable = $this->createElement('text', 'cantidad_de_material_renovable');
		$cantidad_de_material_renovable->setLabel('<span>d.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Cantidad de material renovable'))
									//->setRequired(true)									
									->addFilter('StripTags')									
									->addFilter('StringTrim')
									->addValidator($validatorFloat)
									->setAttrib('size', 30);
									//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cantidad_de_material_renovable);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_3_bc_2.phtml'))));
 	}
 }