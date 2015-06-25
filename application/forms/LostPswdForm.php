<?php
/**
* Documentation Block Here
*/
 class Form_LostPswdForm extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// add element: user_email_register textbox		
		$user_email_lost = $this->createElement('text', 'user_email_lost');
		$user_email_lost->setLabel(Zend_Registry::get('Zend_Translate')->translate('Correo electrónico'))
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
		$this->addElement($user_email_lost);	

		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');			
		$this->addElement($hash);
		
		// add element: user_submit_login submit button
		$user_submit_lost = $this->createElement('submit', 'user_submit_lost');
		$user_submit_lost->setLabel(Zend_Registry::get('Zend_Translate')->translate('Recordar contraseña'))
						->setAttrib('class', 'boton black')
						->removeDecorator('DtDdWrapper');
		$this->addElement($user_submit_lost);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_lost_pswd.phtml'))));
 	}
 } 