<?php
/**
* Documentation Block Here
*/
class Form_BugReportListToolsForm extends Zend_Form
{
	/**
	* Documentation Block Here
	*/
	public function init()
	{		
		$options = array(
			'0' => 'None',
			'priority' => 'Priority',
			'status' => 'Status',
			'date' => 'Date',
			'url' => 'URL',
			'author' => 'Submitter'
		);
		
		$sort = $this->createElement('select', 'sort');
		$sort->setLabel(Zend_Registry::get('Zend_Translate')->translate('Sort Records:'))
			->addMultiOptions($options);
		$this->addElement($sort);
		
		$filterField = $this->createElement('select', 'filter_field');
		$filterField->setLabel(Zend_Registry::get('Zend_Translate')->translate('Filter Field:'))
					->addMultiOptions($options);
		$this->addElement($filterField);
		
		// create new element
		$filter = $this->createElement('text', 'filter');
		// element options
		$filter->setLabel(Zend_Registry::get('Zend_Translate')->translate('Filter Value:'))
			->setAttrib('size', 40);
		// add the element to the form
		$this->addElement($filter);
		
		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), true)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');			
		$this->addElement($hash);
			
		// add element: submit button
		$this->addElement('submit', 'submit', array('label' => Zend_Registry::get('Zend_Translate')->translate('Update List')));
	}
}