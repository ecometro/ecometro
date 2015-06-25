<?php
/**
* Documentation Block Here
*/
class Form_BugReportForm extends Zend_Form
{
	/**
	* Documentation Block Here
	*/
	public function init()
	{
		
		$id = $this->createElement('hidden', 'id');
		$this->addElement($id);
		
		// add element: author textbox
		$author = $this->createElement('text', 'author');
		$author->setLabel(Zend_Registry::get('Zend_Translate')->translate('Enter your name:'))
				->setRequired(true)
				->setAttrib('size', 30);
		$this->addElement($author);
		
		// add element: email textbox
		$email = $this->createElement('text', 'email');
		$email->setLabel(Zend_Registry::get('Zend_Translate')->translate('Your email address:'))
				->setRequired(true)
				->addValidator(new Zend_Validate_EmailAddress())
				->addFilters(array(
					new Zend_Filter_StringTrim(),
					new Zend_Filter_StringToLower()
				))
				->setAttrib('size', 40);
		$this->addElement($email);
		
		//add element: date textbox
		$date = $this->createElement('text', 'date');
		$date->setLabel(Zend_Registry::get('Zend_Translate')->translate('Date the issue occurred (mm-dd-yyyy):'))
				->setRequired(true)
				->addValidator(new Zend_Validate_Date('MM-DD-YYYY'))
				->setAttrib('size', 20);
		$this->addElement($date);
		
		//add element: URL textbox		
		$url = $this->createElement('text', 'url');
		$url->setLabel(Zend_Registry::get('Zend_Translate')->translate('Issue URL:'))
			->setRequired(true)
			->setAttrib('size', 50);
		$this->addElement($url);
		
		//add element: description text area		
		$description = $this->createElement('textarea', 'description');
		$description->setLabel(Zend_Registry::get('Zend_Translate')->translate('Issue description:'))
					->setRequired(true)
					->setAttrib('cols', 50)
					->setAttrib('rows', 4);
		$this->addElement($description);
		
		//add element: priority select box				
		$priority = $this->createElement('select', 'priority');
		$priority->setLabel(Zend_Registry::get('Zend_Translate')->translate('Issue priority:'))
				->setRequired(true)
				->addMultiOptions(array(
					'low'=> Zend_Registry::get('Zend_Translate')->translate('Low'),
					'med'=> Zend_Registry::get('Zend_Translate')->translate('Medium'),
					'high'=> Zend_Registry::get('Zend_Translate')->translate('High')
				));
		$this->addElement($priority);
		
		//add element: status select box		
		$status = $this->createElement('select', 'status');
		$status->setLabel(Zend_Registry::get('Zend_Translate')->translate('Current status:'))
				->setRequired(true)
				->addMultiOption('new', Zend_Registry::get('Zend_Translate')->translate('New'))
				->addMultiOption('in_progress', Zend_Registry::get('Zend_Translate')->translate('In Progress'))
				->addMultiOption('resolved', Zend_Registry::get('Zend_Translate')->translate('Resolved'));
		$this->addElement($status);
		
		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');			
		$this->addElement($hash);
		
		$this->addElement('submit', 'submit', array('label' => Zend_Registry::get('Zend_Translate')->translate('Submit')));
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_bug.phtml'))));
		
	}
}