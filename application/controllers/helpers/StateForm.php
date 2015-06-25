<?php
/**
 * Documentation Block Here
 */
class Zend_Controller_Action_Helper_StateForm extends Zend_Controller_Action_Helper_Abstract
{
		
    /**
     * [getStateForm description]
     * @param  [type] $projectId         [description]
     * @param  [type] $stepNumber        [description]
     * @param  [type] $totalNumerOfForms [description]
     * @param  [type] $formType          [description]
     * @return [type]                    [description]
     */
    public function getStateForm($projectId, $stepNumber, $totalNumerOfForms, $formType)    
    {
    	// number of completed forms
		$countCompleted = 0;
		
    	$stepModelClass = 'Model_Step' . $stepNumber;
    	
    	$stepModelObject = new $stepModelClass();    	
    	
    	for($count = 1; $count <= $totalNumerOfForms; $count++) {				
			$objectView = strtolower($formType) . $count . 'class';	

			$stateForm = $stepModelObject->{'isCompleteStep' . $stepNumber . 'Form'}($projectId, $count, $formType);
						
			Zend_Layout::getMvcInstance()->getView()->$objectView = $stateForm; 												
				
			if($stateForm == 'complete')
				$countCompleted++;
		}

		if ($countCompleted == $totalNumerOfForms)
			return true;		
		else 
			return false;				
    }
    
    /**
     * [direct description]
     * @param  [type] $projectId         [description]
     * @param  [type] $stepNumber        [description]
     * @param  [type] $totalNumerOfForms [description]
     * @param  [type] $formType          [description]
     * @return [type]                    [description]
     */
    public function direct($projectId, $stepNumber, $totalNumerOfForms, $formType)
    {
        return $this->getStateForm($projectId, $stepNumber, $totalNumerOfForms, $formType);
    }
}