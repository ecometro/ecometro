<?php
/**
* Documentation Block Here
*/
 class Form_FilterProjectsForm extends Zend_Form
 {
	/**
	* Documentation Block Here
	*/
 	public function init()
 	{
 		// initialize form
 		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'projectslist', 'action' => 'index'), 'projectsEvaluatedRoute')) 		
			 ->setAttribs(array( 		  		
 				'id' => 'filterprojects-form',
 		  		'class' => 'form-horizontal login'
 				))
 			 	->setMethod('post');
 			 	 		
		// add element: buscar_por_categoria textbox
		$buscar_por_categoria = $this->createElement('select', 'buscar_por_categoria', array('RegisterInArrayValidator' => false));
		$buscar_por_categoria->setLabel(Zend_Registry::get('Zend_Translate')->translate('Buscar por categoría'))
							//->setRequired(true)								
							->setAttrib('class', 'input-xlarge')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))
							->addFilter('StripTags')								
							->addFilter('StringTrim')
							->addFilter('Alpha');
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$options = array(
			'' => '',
			'Vivienda' => 'Vivienda',
			'Oficina' => 'Oficina',
			'Comercial' => 'Comercial',
			'Hospitalario' => 'Hospitalario',
		);
		$buscar_por_categoria->addMultiOptions($options);
		$this->addElement($buscar_por_categoria);
				
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_filter_projects.phtml'))));
 	}
 }