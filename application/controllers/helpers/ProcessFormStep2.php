<?php

/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_ProcessFormStep2 extends Zend_Controller_Action_Helper_Abstract
{	
    public function getProcessFormStep2($projectId, $stepNumber, $formType, $formNumber, array $fields)   
    {    	
    	// init session
		$myNamespace = new Zend_Session_Namespace('myNamespace');
		$view = $this->getActionController()->view;

		// instantiate form model	
		$formModelClass = 'Model_Step' . $stepNumber . $formType . $formNumber;
		$formModelObject = new $formModelClass();

		// form total fields
	    $nrColumnsTotal = $formModelObject->getNumberOfColumns(strtolower($formType));       
		// form total fields completed
		$nrColumnsCompleted = 0;

		// instantiate step model
		$stepModelString =  'Model_Step' . $stepNumber;
		$stepModel = new $stepModelString();

		// instantiate form
		$stepFormString = 'Form_Step' . $stepNumber . $formType . $formNumber . 'Form'; 
		$stepForm = new $stepFormString();

		// filter to convert float values from aa,bb to aa.bb 
		$filter_en = new Zend_Filter_LocalizedToNormalized();		
		// filter to convert float values from aa.bb to aa,bb
		$filter_es = new Zend_Filter_NormalizedToLocalized();

		// find form by project's id		
		$result = $stepModel->{'findStep' . $stepNumber . 'byProjectId'}($projectId, $formNumber, $formType);	

		// check field state
		$fieldsAplicable = Zend_Controller_Action_HelperBroker::getStaticHelper('CheckAplicable')->direct($formModelObject, $result, $formType, $formNumber, $nrColumnsTotal);				
		$view->fieldsAplicable = $fieldsAplicable;

		// get form units
		$units = Zend_Controller_Action_HelperBroker::getStaticHelper('FieldsUnits')->direct($stepNumber, $formType . $formNumber, $nrColumnsTotal);
		$view->units = $units;

		// store errors
		$errors = array();

		if($this->getActionController()->getRequest()->isPost()) {
			if($stepForm->isValid($_POST)) {

				$result->modified = 1;					
				
				foreach($fields as $key => $value) {	

					$key++;
					$tmp = $stepForm->getValue($value);					
					$field = $formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $key);
					
					// check aplicable											
					if($myNamespace->{'aplicable_' . $projectId . strtolower($formType). $formNumber}[$key]) {						
						if($tmp != '') {
							if(Zend_Controller_Action_HelperBroker::getStaticHelper('CheckFieldType')->direct($stepNumber, $formType . $formNumber, $key) !== false)
								$field->usuario_dato_1 = $filter_en->filter($tmp);								
							else
								$field->usuario_dato_1 = $tmp;								
								$field->aplicable = 1;	
								$field->save();
								$nrColumnsCompleted++;
						} else {
							$field->usuario_dato_1 = null;
							$field->aplicable = 1;
							$field->save();
						}
					} else {
						if($myNamespace->{'value_' . $projectId . strtolower($formType) . $formNumber}[$key] != '') {							
							$field->usuario_dato_1 = $myNamespace->{'value_' . $projectId . strtolower($formType) . $formNumber}[$key];
						} else {							
							$field->usuario_dato_1 = null;							
						}
						$field->aplicable = 0;							
						$field->save();
						$nrColumnsCompleted++;
					}
				}

				$tmp = $stepForm->getValue('comentarios');	
				if ($tmp != '') {							
					$result->comments = $tmp;
					$result->save();						
				}	

				if($nrColumnsCompleted == $nrColumnsTotal) {
					$result->completed = 1;
					$result->save();
				} else {
					$result->completed = 0;
					$result->save();
				}	
						
				// delete session data of this field
				unset($myNamespace->{'aplicable_' . $projectId . strtolower($formType) . $formNumber});					
				    	
				Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->addMessage(
					Zend_Registry::get('Zend_Translate')->translate('Se ha guardado el formulario.')
				);					
				$urlOptions = array('controller' => 'step' . $stepNumber, 'action' => 'edit' . strtolower($formType) . $formNumber, 'project_id' => $projectId);
				Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector')->gotoRoute($urlOptions, 'step' . $stepNumber . 'Route');
																		
			} else {
				array_push($errors, Zend_Registry::get('Zend_Translate')->translate('Hay errores en el formulario. Por favor, revise los campos.'));							
				$view->errors = $errors;
			}
		}
		
		$data = array();			
		foreach($fields as $key => $value) {
			$key++;
			if(Zend_Controller_Action_HelperBroker::getStaticHelper('CheckFieldType')->direct($stepNumber, $formType . $formNumber, $key) !== false)
				$data[$value] = $filter_es->filter($formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $key)->usuario_dato_1);
			else
				$data[$value] = $formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $key)->usuario_dato_1;
		}
		$data['comentarios'] = $result->comments;
		$stepForm->populate($data);												
		
		$view->{'form_step' . $stepNumber . '_'. strtolower($formType) . '_' . $formNumber} = $stepForm;		
    }
    
    public function direct($projectId, $stepNumber, $formType, $formNumber, array $fields)
    {
        return $this->getProcessFormStep2($projectId, $stepNumber, $formType, $formNumber, $fields);
    }
}	
?>