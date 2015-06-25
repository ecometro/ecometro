<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_FieldsUnits extends Zend_Controller_Action_Helper_Abstract
{
	
    /**
     * [getFieldsUnits description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $totalFields [description]
     * @return [type]              [description]
     */
    public function getFieldsUnits($stepNumber, $formType, $totalFields)    
    {    	
    	$units = array();    	    	
    	
    	for($count = 1; $count <= $totalFields; $count++) {            
            $fieldModelClass = 'Model_Step' . $stepNumber . $formType . 'Field' . $count;
            $fieldModelObject = new $fieldModelClass(); 
            $units[$count] = $fieldModelObject->getFieldComment();
        }
    	       	    	
		// return the array of field's states
		return $units;				
    }
    
    /**
     * [direct description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $totalFields [description]
     * @return [type]              [description]
     */
    public function direct($stepNumber, $formType, $totalFields)
    {
        return $this->getFieldsUnits($stepNumber, $formType, $totalFields);
    }
}