<?php
/**
* Formulario MP 14: Redes locales. Gestión de residuos en uso
*/
 class Form_Step2Mp14Form extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step2', 'action' => 'editmp14'), 'step2Route')) 		
			->setAttribs(array( 		  		
 				'id' => 'step2-mp14',
 		  		'class' => 'mp' 				
 			))
			->setMethod('post');
 			 	
 		// change text of error message	for float validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);	
    		 		
 		// add element: distancia_a_contenedores_de_papel textbox
		$distancia_a_contenedores_de_papel = $this->createElement('text', 'distancia_a_contenedores_de_papel');
		$distancia_a_contenedores_de_papel->setLabel('<span>a.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a contenedores de papel/envases/vidrio'))
										//->setRequired(true)										
										->addFilter('StripTags')										
										->addFilter('StringTrim')
										->addValidator($validatorFloat)
										->setAttrib('size', 30);
										//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_a_contenedores_de_papel);

		// add element: distania_a_un_punto_limpio textbox
		$distania_a_un_punto_limpio = $this->createElement('text', 'distania_a_un_punto_limpio');
		$distania_a_un_punto_limpio->setLabel('<span>b.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a un punto limpio'))
								//->setRequired(true)								
								->addFilter('StripTags')								
								->addFilter('StringTrim')
								->addValidator($validatorFloat)
								->setAttrib('size', 30);
								//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distania_a_un_punto_limpio);

		// add element: distancia_a_un_punto_para_compostaje textbox
		$distancia_a_un_punto_para_compostaje = $this->createElement('text', 'distancia_a_un_punto_para_compostaje');
		$distancia_a_un_punto_para_compostaje->setLabel('<span>c.</span> ' . Zend_Registry::get('Zend_Translate')->translate('Distancia a un punto para compostaje'))
											//->setRequired(true)											
											->addFilter('StripTags')											
											->addFilter('StringTrim')
											->addValidator($validatorFloat)
											->setAttrib('size', 30);
											//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_a_un_punto_para_compostaje);
		
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
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_2_mp_14.phtml'))));
 	}
 }