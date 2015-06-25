<?php
/**
* Documentation Block Here
*/
 class Form_RegisterForm extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// add element: user_register textbox
		$user_register = $this->createElement('text', 'user_register');
		$user_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nombre de usuario'))
						->setRequired(true)
						->addValidator('StringLength', false, array('min' => 3, 'max' => 10))
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')						
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($user_register);

		// add element: user_email_register textbox		
		$user_email_register = $this->createElement('text', 'user_email_register');
		$user_email_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Correo electrónico'))
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
		$this->addElement($user_email_register);
		
		// add element: user_pswd_register textbox password
		$user_pswd_register = $this->createElement('password', 'user_pswd_register');
		$user_pswd_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Contraseña'))
							->setRequired(true)
							->addValidator('StringLength', false, array('min' => 6, 'max' => 20))
							->addFilter('StringTrim')
							->addFilter('StripTags')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-xlarge')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
		$this->addElement($user_pswd_register);
		
		// add element: user_rp_pswd_register textbox password
		$user_rp_pswd_register = $this->createElement('password', 'user_rp_pswd_register');
		$user_rp_pswd_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Repetir contraseña'))
								->setRequired(true)
								->addValidator('StringLength', false, array('min' => 6, 'max' => 20))
								->addFilter('StringTrim')
								->addFilter('StripTags')
								->setAttrib('size', 30)
								->setAttrib('class', 'input-xlarge')
								->addDecorator('Label', array('class' => 'control-label'))
								->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));								
		$this->addElement($user_rp_pswd_register);
		
		// add element: user_acpt_pswd_register checkbox
		$user_acpt_register = $this->createElement('checkbox', 'user_acpt_register');
		$user_acpt_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Acepto las condiciones legales'))
							->setRequired(true)
							->addValidator(new Zend_Validate_InArray(array(1)), false)
							->addDecorator('Label', array('class' => 'checkbox inline'))
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($user_acpt_register);
		
		$hash = $this->createElement('hash', 'csrfVerificationRegister', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');		
		$this->addElement($hash);
		
		// add element: user_submit_register submit button
		$user_submit_register = $this->createElement('submit', 'user_submit_register');
		$user_submit_register->setLabel(Zend_Registry::get('Zend_Translate')->translate('Registrarse'))
							->setAttrib('class', 'boton black')
							->removeDecorator('DtDdWrapper');
		$this->addElement($user_submit_register);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_register.phtml'))));
 	}
 } 
