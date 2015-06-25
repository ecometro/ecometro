<?php
/**
* Documentation Block Here
*/
 class Form_ProfileForm extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{ 			
 		// add element: user_photo_profile input file
		$user_photo_profile = $this->createElement('file','user_photo_profile');
		$user_photo_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Foto'))
		      				->setDestination(Zend_Registry::get('config')->paths->backend->images->profile)
							// ensure only one file
							->addValidator('Count', false, 1)
							// max 2MB
							->addValidator('Size', false, 2097152)
		      				->setMaxFileSize(2097152)
							// only JPEG, PNG, or GIF
							->addValidator('Extension', false, 'jpg,png,gif')
							->setValueDisabled(true)
							->addFilter(new Skoch_Filter_File_Resize(array(
							    'width' => 95,
							    'height' => 75,
							    'keepRatio' => true,
							)))
							->setAttrib('class', 'input-xlarge')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($user_photo_profile);

		// add element: user_email_register textbox		
		$user_email_profile = $this->createElement('text', 'user_email_profile');
		$user_email_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Correo electrónico'))
							->setRequired(true)
							->addValidators(array(
								new Zend_Validate_EmailAddress(),
								new Zend_Validate_StringLength(array('max' => 50))
							))
							->addFilters(array(
								new Zend_Filter_StringTrim(),
								new Zend_Filter_StripTags(),
								new Zend_Filter_StringToLower()
							))
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_email_profile);

		// add element: user_username_profile textbox
		$user_username_profile = $this->createElement('text', 'user_username_profile');
		$user_username_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nombre de usuario'))
						->setRequired(true)
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')
						->setAttrib('readonly', true)
						->setDescription('El nombre de usuario no puede cambiarse.')						
						->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($user_username_profile);

		// add element: user_firstname_profile textbox
		$user_firstname_profile = $this->createElement('text', 'user_firstname_profile');
		$user_firstname_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nombre(s)'))
								//->setRequired(true)
								->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
								->addFilter('StringTrim')
								->addFilter('StripTags')
								->setAttrib('size', 30)
								->setAttrib('class', 'input-xlarge')								
								->addDecorator('Label', array('class' => 'control-label'))
								->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));								
		$this->addElement($user_firstname_profile);
		
		// add element: user_lastname_profile textbox
		$user_lastname_profile = $this->createElement('text', 'user_lastname_profile');
		$user_lastname_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Apellido(s)'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_lastname_profile);
		
		// add element: user_company_profile textbox
		$user_company_profile = $this->createElement('text', 'user_company_profile');
		$user_company_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Compañía'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 0, 'max' => 30))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_company_profile);
		
		// add element: user_city_profile textbox
		$user_city_profile = $this->createElement('text', 'user_city_profile');
		$user_city_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Ciudad'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_city_profile);
		
		// add element: user_province_profile textbox
		$user_province_profile = $this->createElement('text', 'user_province_profile');
		$user_province_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Provincia'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_province_profile);
		
		// add element: user_country_profile textbox
		$user_country_profile = $this->createElement('text', 'user_country_profile');
		$user_country_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('País'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_country_profile);
		
		// add element: user_web_profile textbox
		$user_web_profile = $this->createElement('text', 'user_web_profile');
		$user_web_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Web'))
						//->setRequired(true)
						->addValidator('StringLength', false, array('min' => 0, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')						
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));						
		$this->addElement($user_web_profile);

		// add element: user_nuevo_pswd textbox
		$user_nuevo_pswd = $this->createElement('password', 'user_nuevo_pswd');
		$user_nuevo_pswd->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nueva Contraseña'))
						//->setRequired(true)
						->addValidator('StringLength', false, array('min' => 6, 'max' => 20))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')						
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
						//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($user_nuevo_pswd);
		
		// add element: user_rp_nuevo_pswd textbox
		$user_rp_nuevo_pswd = $this->createElement('password', 'user_rp_nuevo_pswd');
		$user_rp_nuevo_pswd->setLabel(Zend_Registry::get('Zend_Translate')->translate('Repetir Contraseña'))
							//->setRequired(true)
							->addValidator('StringLength', false, array('min' => 6, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')							
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($user_rp_nuevo_pswd);

		// create the role element
		$role = $this->createElement('select', 'user_role');
		$role->setLabel(Zend_Registry::get('Zend_Translate')->translate('Seleccionar role:'))
			->addMultiOption('user', 'user')
			->addMultiOption('administrator', 'administrator')
			->addDecorator('Label', array('class' => 'control-label'))
			->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));		
		$this->addElement($role);
		
		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');		
		$this->addElement($hash);
		
		// add element: user_submit_profile submit button
		$user_submit_profile = $this->createElement('submit', 'user_submit_profile');
		$user_submit_profile->setLabel(Zend_Registry::get('Zend_Translate')->translate('Actualizar Perfil'))
							->setAttrib('class', 'boton black')
							->removeDecorator('DtDdWrapper');
		$this->addElement($user_submit_profile);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_profile.phtml'))));
 	}
 } 
