<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_CheckFieldType extends Zend_Controller_Action_Helper_Abstract
{
	
    /**
     * [getCheckFieldType description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $fieldNumber [description]
     * @param  string $compareType [description]
     * @return [type]              [description]
     */
    public function getCheckFieldType($stepNumber, $formType, $fieldNumber, $compareType = 'float')    
    {    	           
        $fieldModelClass = 'Model_Step' . $stepNumber . $formType . 'Field' . $fieldNumber;
        $fieldModelObject = new $fieldModelClass(); 
        $fieldType = $fieldModelObject->getFieldType();
        
        if(strpos($fieldType, $compareType) !== false)            	       	    			
            return true;				
        else
            return false;
    }
    
    /**
     * [direct description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $fieldNumber [description]
     * @param  string $compareType [description]
     * @return [type]              [description]
     */
    public function direct($stepNumber, $formType, $fieldNumber, $compareType = 'float')
    {
        return $this->getCheckFieldType($stepNumber, $formType, $fieldNumber, $compareType);
    }
}