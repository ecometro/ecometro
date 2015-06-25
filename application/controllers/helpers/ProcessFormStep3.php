<?php

/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_ProcessFormStep3 extends Zend_Controller_Action_Helper_Abstract
{	
    public function getProcessFormStep3($projectId, $stepNumber, $formType, $formNumber, array $fields, array $fieldsAllowed)   
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
		$stepModelClass =  'Model_Step' . $stepNumber;
		$stepModelObject = new $stepModelClass();

		// instantiate form
		$stepFormClass = 'Form_Step' . $stepNumber . $formType . $formNumber . 'Form'; 
		$stepFormObject = new $stepFormClass();

		// filter to convert float values from aa,bb to aa.bb 
		$filter_en = new Zend_Filter_LocalizedToNormalized();
		// filter to convert float values from aa.bb to aa,bb
		$filter_es = new Zend_Filter_NormalizedToLocalized();

		// find form by project's id
		$result = $stepModelObject->{'findStep' . $stepNumber . 'byProjectId'}($projectId, $formNumber, $formType);		

		// fields state array
		$fieldsAplicable = Zend_Controller_Action_HelperBroker::getStaticHelper('CheckAplicable')->direct($formModelObject, $result, $formType, $formNumber, $nrColumnsTotal);			
		$view->fieldsAplicable = $fieldsAplicable;

		// comments array
		$comments = Zend_Controller_Action_HelperBroker::getStaticHelper('CheckComment')->direct($formModelObject, $result, $formType, $formNumber, $nrColumnsTotal);				
		$view->comments = $comments;

		// calculus
		$modelCalculus = new Model_Calculus();
		$calculus = $modelCalculus->getFactAndMax(strtolower($formType) . '_' . $formNumber, $nrColumnsTotal); 
		
		// weighting array
		$weightingFactor = $calculus['weightingFactor'];
		$view->weightingFactor = $weightingFactor;		
		
		// maximum points array
		$maximumPoints = $calculus['maximumPoints'];
		$view->maximumPoints = $maximumPoints;		
		
		// maximum points
		$total_max = 30;
		$view->total_max = $total_max;
		
		// results points array
		$points = Zend_Controller_Action_HelperBroker::getStaticHelper('Points')->direct($formModelObject, $result, $formType, $formNumber, $nrColumnsTotal);
		$view->valueOfEachField = $points['valueOfEachField'];	
						
		// obtained points		
		$total_pct = $points['totalValueOfFields'];				
		$view->total_pct = $total_pct;

		$view->nrColumnsTotal = $nrColumnsTotal;

		// get fields from previous step
		if($fieldsAllowed) {		
			$rememberFieldsData = Zend_Controller_Action_HelperBroker::getStaticHelper('FieldsData')->direct($projectId, $fieldsAllowed);
			$view->rememberFieldsData = $rememberFieldsData;
		}

		// vector points array
		$vectorPoints = $calculus['vectorPoints'];
		$view->vectorPoints = $vectorPoints;

        // get form units
        $units = Zend_Controller_Action_HelperBroker::getStaticHelper('FieldsUnits')->direct($stepNumber, $formType . $formNumber, $nrColumnsTotal);        
        $view->units = $units;

        // store errors
		$errors = array();

			if($this->getActionController()->getRequest()->isPost()) {
				if($stepFormObject->isValid($_POST)) {
					
					$result->modified = 1;
					
					foreach($fields as $key => $value) {
						$key++;
						$tmp = $stepFormObject->getValue($value);					
						$field = $formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $key);
						// check aplicable
						if($myNamespace->{'aplicable_' . $projectId . strtolower($formType) . $formNumber}[$key]){													
							if($tmp != '') {
								if(Zend_Controller_Action_HelperBroker::getStaticHelper('CheckFieldType')->direct($stepNumber, $formType . $formNumber, $key) !== false)
									$field->usuario_dato_1 = $filter_en->filter($tmp);								
								else
									$field->usuario_dato_1 = $tmp;																							
								$field->puntos = $myNamespace->{'data_' . $projectId. strtolower($formType) . $formNumber}[$key];						
								$field->comentarios = $myNamespace->{'comments_' . $projectId . strtolower($formType) . $formNumber}[$key];
								$field->aplicable = 1;	
								$field->save();
								$nrColumnsCompleted++;
							} else {
								$field->usuario_dato_1 = null;
	                            $field->puntos = null;                     
	                            $field->comentarios = null;
								$field->aplicable = 1;
								$field->save();
						   }
						} else {
							if($myNamespace->{'value_' . $projectId . strtolower($formType) . $formNumber}[$key] != '') {
								$field->usuario_dato_1 = $myNamespace->{'value_' . $projectId . strtolower($formType) . $formNumber}[$key];
							} else {
								$field->usuario_dato_1 = null;
								$field->comentarios = null;
							}
							$field->aplicable = 0;
							$field->puntos = $myNamespace->{'data_' . $projectId . strtolower($formType) . $formNumber}[$key];
							$field->save();
							$nrColumnsCompleted++;
						}	
					}
						
					$tmp = $stepFormObject->getValue('comentarios');	
					if ($tmp != ''){							
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

					unset($myNamespace->{'aplicable_' . $projectId . strtolower($formType) . $formNumber});
					unset($myNamespace->{'data_' . $projectId . strtolower($formType) . $formNumber});
					unset($myNamespace->{'value_' . $projectId . strtolower($formType) . $formNumber});
					unset($myNamespace->{'total_pct' . $projectId});

                    Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->addMessage(
                        Zend_Registry::get('Zend_Translate')->translate('Se ha guardado el formulario.')
                    );
					$urlOptions = array('controller' => 'step'. $stepNumber, 'action' => 'edit' . strtolower($formType) . $formNumber, 'project_id' => $projectId);
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
			$stepFormObject->populate($data);			

		$view->{'form_step' . $stepNumber . '_'. strtolower($formType) . '_' . $formNumber} = $stepFormObject;		
	}

	public function direct($projectId, $stepNumber, $formType, $formNumber, array $fields, array $fieldsAllowed)
    {
        return $this->getProcessFormStep3($projectId, $stepNumber, $formType, $formNumber, $fields, $fieldsAllowed);
    }
}			
?>