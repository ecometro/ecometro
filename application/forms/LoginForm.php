<?php
/**
* Documentation Block Here
*/
 class Form_LoginForm extends Zend_Form
 {
 	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// add element: user_login textbox
		$user_login = $this->createElement('text', 'user_login');
		$user_login->setLabel(Zend_Registry::get('Zend_Translate')->translate('Nombre de usuario'))
					->setRequired(true)
					->addFilter('StringTrim')
					->addFilter('StripTags')
					->setAttrib('size', 30)
					->setAttrib('class', 'input-xlarge')					
					->addDecorator('Label', array('class' => 'control-label'))
					->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($user_login);		
		
		// add element: user_pswd_login textbox password
		$user_pswd_login = $this->createElement('password', 'user_pswd_login');
		$user_pswd_login->setLabel(Zend_Registry::get('Zend_Translate')->translate('Contraseña'))
						->setRequired(true)
						->addFilter('StringTrim')
						->addFilter('StripTags')
						->setAttrib('size', 30)
						->setAttrib('class', 'input-xlarge')						
						->addDecorator('Label', array('class' => 'control-label'))
						->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($user_pswd_login);				
		
		$hash = $this->createElement('hash', 'csrfVerificationLogin', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');		
		$this->addElement($hash);
		
		// add element: user_submit_login submit button
		$user_submit_login = $this->createElement('submit', 'user_submit_login');		
		$user_submit_login->setLabel(Zend_Registry::get('Zend_Translate')->translate('Iniciar sesión'))
						->setAttrib('class', 'boton black')
						->removeDecorator('DtDdWrapper');
		$this->addElement($user_submit_login);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript', array('viewScript' => 'forms/_form_login.phtml'))));
 	}
 }