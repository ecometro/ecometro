<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_CheckAplicable extends Zend_Controller_Action_Helper_Abstract
{
	
    /**
     * [getCheckAplicable description]
     * @param  [type] $formModelObject           [description]
     * @param  [type] $result              [description]
     * @param  [type] $formType            [description]
     * @param  [type] $formNumber          [description]
     * @param  [type] $totalNumberOfFields [description]
     * @return [type]                      [description]
     */
    public function getCheckAplicable($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields)    
    {    	
    	$fields = array();    	
    	
    	// iterate over all form's fields and retrieve array
		for ($count = 1; $count <= $totalNumberOfFields; $count++) {			
			// get each field
			$field = $formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $count);
			// push each field into an array
			$fields[$count] = $field->aplicable;
		}

		// return the array of field's states
		return $fields;				
    }
    
    /**
     * [direct description]
     * @param  [type] $formModelObject           [description]
     * @param  [type] $result              [description]
     * @param  [type] $formType            [description]
     * @param  [type] $formNumber          [description]
     * @param  [type] $totalNumberOfFields [description]
     * @return [type]                      [description]
     */
    public function direct($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields)
    {
        return $this->getCheckAplicable($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields);
    }
}