<?php
/**
* Documentation Block Here
*/
 class Form_Step4Bc3Form extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// initialize form
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step4', 'action' => 'index'), 'step4Route'))
			 ->setAttribs(array( 		  		
				'id' => 'step4-bc3',
 		  		'class' => 'form-horizontal upload',
 				'enctype' => 'multipart/form-data'
			))
 			 ->setMethod('post'); 			 	 	

 		// add element: user_photo_profile input file
		$file = $this->createElement('file','fichero');
		$file->setLabel(Zend_Registry::get('Zend_Translate')->translate('Seleccione fichero'))
		      ->setDestination(Zend_Registry::get('config')->paths->backend->csvs);
		// ensure only one file
		$file->addValidator('Count', false, 1);
		// max 2MB
		$file->addValidator('Size', false, 400000)
		      ->setMaxFileSize(400000);
		// only JPEG, PNG, or GIF
		$file->addValidator('Extension', false, 'bc3');
		$file->setValueDisabled(true);		
		$file->setAttrib('class', 'input-xlarge');
		$file->addDecorator('Label', array('class' => 'control-label'));
		$file->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
		$this->addElement($file); 			 													
		// add element: user_submit_profile submit button
		$submit = $this->createElement('submit', 'submit');		
		$submit->setLabel(Zend_Registry::get('Zend_Translate')->translate('Subir archivo seleccionado'))
				->setAttrib('class', 'red black')
				->removeDecorator('DtDdWrapper');		
		$this->addElement($submit);
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_4_bc3.phtml'))));
 	}
}