<?php
/**
* Documentation Block Here
*/
 class Form_Step1F1Form extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// initialize form
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step1', 'action' => 'edit'), 'step1Route'))
			 ->setAttribs(array( 		  		
				'id' => 'step1-f1',
 		  		'class' => 'form-horizontal login',
 				'enctype' => 'multipart/form-data'
			))
 			 ->setMethod('post');
 			 	
 		
 		// change text of error message	for float and int validator
 		$validatorFloat = new Zend_Validate_Float();
    	$validatorFloat->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Float::NOT_FLOAT
    	);
    	
    	$validatorInt = new Zend_Validate_Int();
    	$validatorInt->setMessage(
	        Zend_Registry::get('Zend_Translate')->translate("'%value%' es un valor incorrecto"),
	        Zend_Validate_Int::NOT_INT
    	);	 	

 		// add element: user_photo_profile input file
		$photo = $this->createElement('file','photo');
		$photo->setLabel(Zend_Registry::get('Zend_Translate')->translate('Foto'))
		      ->setDestination(Zend_Registry::get('config')->paths->backend->images->projects);
		// ensure only one file
		$photo->addValidator('Count', false, 1);
		// max 2MB
		$photo->addValidator('Size', false, 2097152)
		      ->setMaxFileSize(2097152);
		// only JPEG, PNG, or GIF
		$photo->addValidator('Extension', false, 'jpg,png,gif');
		$photo->setValueDisabled(true);
		$photo->addFilter(new Skoch_Filter_File_Resize(array(
		    'width' => 150,
		    'height' => 100,
		    'keepRatio' => true,
		)));
		$photo->setAttrib('class', 'input-xlarge');
		$photo->addDecorator('Label', array('class' => 'control-label'));
		$photo->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($photo);
 			
 		// add element: nombre_del_proyecto textbox
		$nombre_del_proyecto = $this->createElement('text', 'nombre_del_proyecto');
		$nombre_del_proyecto->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nombre del proyecto'))
							->setRequired(true)
							->addValidator('StringLength', false, array('min' => 1, 'max' => 30))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
							->addFilter('StripTags')							
							->addFilter('StringTrim');							
		$this->addElement($nombre_del_proyecto);

		// add element: fase_del_proyecto textbox
		$fase_del_proyecto = $this->createElement('select', 'fase_del_proyecto', array('RegisterInArrayValidator' => false));
		$fase_del_proyecto->setLabel(Zend_Registry::get('Zend_Translate')->translate('Fase del proyecto'))
						->setRequired(true)						
						->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('class', 'input-xlarge')
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
						->addFilter('StripTags')						
						->addFilter('StringTrim');						
		$options = array(
			'' => 'Elige',
			'Proyecto' => 'Proyecto',
			'Construcción' => 'Construcción',
			'Uso' => 'Uso',
			'Fin de vida' => 'Fin de vida',
		);
		$fase_del_proyecto->addMultiOptions($options);
		$this->addElement($fase_del_proyecto);
		
		// add element: lugar textbox
		$lugar = $this->createElement('text', 'lugar');
		$lugar->setLabel(Zend_Registry::get('Zend_Translate')->translate('Lugar'))
				->setRequired(true)
				->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
				->addFilter('StringTrim')
				->addFilter('StripTags')
				->setAttrib('size', 30)
				->setAttrib('class', 'input-xlarge')
				->addDecorator('Label', array('class' => 'control-label'))
				->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
				->addFilter('StripTags')				
				->addFilter('StringTrim');				
		$this->addElement($lugar);
		
		// add element: latitud textbox
		$latitud = $this->createElement('text', 'latitud');
		$latitud->setLabel(Zend_Registry::get('Zend_Translate')->translate('Latitud'))
				//->setRequired(true)
				->setAttrib('size', 30)
				->setAttrib('class', 'input-xlarge')
				->addDecorator('Label', array('class' => 'control-label'))
				->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
				->addFilter('StripTags')				
				->addFilter('StringTrim');
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($latitud);
		
		// add element: longitud textbox
		$longitud = $this->createElement('text', 'longitud');
		$longitud->setLabel(Zend_Registry::get('Zend_Translate')->translate('Longitud'))
				//->setRequired(true)
				->setAttrib('size', 30)
				->setAttrib('class', 'input-xlarge')
				->addDecorator('Label', array('class' => 'control-label'))
				->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
				->addFilter('StripTags')				
				->addFilter('StringTrim');
				//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($longitud);
		
		// add element: uso_principal_del_edificio textbox
		$uso_principal_del_edificio = $this->createElement('select', 'uso_principal_del_edificio', array('RegisterInArrayValidator' => false));
		$uso_principal_del_edificio->setLabel(Zend_Registry::get('Zend_Translate')->translate('Uso principal del edificio'))
								->setRequired(true)								
								->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
								->addFilter('StringTrim')
								->addFilter('StripTags')
								->setAttrib('class', 'input-xlarge')
								->addDecorator('Label', array('class' => 'control-label'))
								->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
								->addFilter('StripTags')								
								->addFilter('StringTrim');								
		$options = array(
			'' => 'Elige',
			'Vivienda' => 'Vivienda',
			'Oficina' => 'Oficina',
			'Comercial' => 'Comercial',
			'Hospitalario' => 'Hospitalario',
		);
		$uso_principal_del_edificio->addMultiOptions($options);
		$this->addElement($uso_principal_del_edificio);
		
		// add element: tipo_de_proyecto textbox
		$tipo_de_proyecto = $this->createElement('select', 'tipo_de_proyecto', array('RegisterInArrayValidator' => false));
		$tipo_de_proyecto->setLabel(Zend_Registry::get('Zend_Translate')->translate('Tipo de proyecto'))
						->setRequired(true)						
						->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('class', 'input-xlarge')
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
						->addFilter('StripTags')						
						->addFilter('StringTrim');						
		$options = array(
			'' => 'Elige',
			'Nueva construcción' => 'Nueva construcción',
			'Rehabilitación' => 'Rehabilitación',
		);
		$tipo_de_proyecto->addMultiOptions($options);
		$this->addElement($tipo_de_proyecto);
		
		// add element: breve_descripcion textbox
		$breve_descripcion = $this->createElement('text', 'breve_descripcion');
		$breve_descripcion->setLabel(Zend_Registry::get('Zend_Translate')->translate('Breve descripción'))
						//->setRequired(true)
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
						->addFilter('StripTags')					
						->addFilter('StringTrim');
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($breve_descripcion);
		
		// add element: no_de_ocupantes textbox
		$no_de_ocupantes = $this->createElement('text', 'no_de_ocupantes');
		$no_de_ocupantes->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nº de ocupantes'))
						->setRequired(true)
						->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge-m2')
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
						->addFilter('StripTags')						
						->addFilter('StringTrim')																																								
						->addValidator($validatorInt);
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($no_de_ocupantes);
		
		// add element: superficie_de_parcela textbox
		$superficie_de_parcela = $this->createElement('text', 'superficie_de_parcela');
		$superficie_de_parcela->setLabel(Zend_Registry::get('Zend_Translate')->translate('Superficie de parcela'))
							->setRequired(true)
							->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge-m2')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
							->addFilter('StripTags')							
							->addFilter('StringTrim')																																									
							->addValidator($validatorFloat);							
		$this->addElement($superficie_de_parcela);
		
		// add element: superficie_ocupada textbox
		$superficie_ocupada = $this->createElement('text', 'superficie_ocupada');
		$superficie_ocupada->setLabel(Zend_Registry::get('Zend_Translate')->translate('Superficie ocupada'))
							->setRequired(true)
							->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge-m2')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
							->addFilter('StripTags')							
							->addFilter('StringTrim')																																									
							->addValidator($validatorFloat);							
		$this->addElement($superficie_ocupada);
		
		
		// add element: superficie_edificada textbox
		$superficie_edificada = $this->createElement('text', 'superficie_edificada');
		$superficie_edificada->setLabel(Zend_Registry::get('Zend_Translate')->translate('Superficie edificada'))
							->setRequired(true)
							->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge-m2')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
							->addFilter('StripTags')							
							->addFilter('StringTrim')																																									
							->addValidator($validatorFloat);							
		$this->addElement($superficie_edificada);
		
		// add element: volumen_edificado textbox
		$volumen_edificado = $this->createElement('text', 'volumen_edificado');
		$volumen_edificado->setLabel(Zend_Registry::get('Zend_Translate')->translate('Volumen edificado'))
						->setRequired(true)
						->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge-m2')
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
						->addFilter('StripTags')						
						->addFilter('StringTrim')																																														
						->addValidator($validatorFloat);						
		$this->addElement($volumen_edificado);
		
		// add element: superficie_cubierta textbox
		$superficie_cubierta = $this->createElement('text', 'superficie_cubierta');
		$superficie_cubierta->setLabel(Zend_Registry::get('Zend_Translate')->translate('Superficie cubierta'))
							->setRequired(true)							
							->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge-m2')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'openOnly' => true, 'class' => 'controls'))
							->addFilter('StripTags')							
							->addFilter('StringTrim')																																																							
							->addValidator($validatorFloat);							
		$this->addElement($superficie_cubierta);
							
		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');		
		$this->addElement($hash);
		
		// add element: user_submit_profile submit button
		$submit = $this->createElement('submit', 'submit');		
		$submit->setLabel(Zend_Registry::get('Zend_Translate')->translate('Guardar'))
				->setAttrib('class', 'boton black')
				->removeDecorator('DtDdWrapper');		
		$this->addElement($submit);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_1_f_1.phtml'))));
 	}
 }