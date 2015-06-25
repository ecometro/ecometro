<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_FieldType extends Zend_Controller_Action_Helper_Abstract
{
	
    /**
     * [getFieldType description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $fieldNumber [description]
     * @return [type]              [description]
     */
    public function getFieldType($stepNumber, $formType, $fieldNumber)
    
    {    	           
        $fieldModelClass = 'Model_Step' . $stepNumber . $formType . 'Field' . $fieldNumber;
        $fieldModelObject = new $fieldModelClass(); 
        $fieldType = $fieldModelObject->getFieldType();        
        
        if(strpos($fieldType, 'float') !== false)            	       	    			
            return 'float';				
        elseif(strpos($fieldType, 'tinyint') !== false)
            return 'boolean';
        else
            return 'other';
    }
    
    /**
     * [direct description]
     * @param  [type] $stepNumber  [description]
     * @param  [type] $formType    [description]
     * @param  [type] $fieldNumber [description]
     * @return [type]              [description]
     */
    public function direct($stepNumber, $formType, $fieldNumber)
    {
        return $this->getFieldType($stepNumber, $formType, $fieldNumber);
    }
}