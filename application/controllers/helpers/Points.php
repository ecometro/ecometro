<?php
/**
 * Class Controller Helper for getting all field's points
 */
class Zend_Controller_Action_Helper_Points extends Zend_Controller_Action_Helper_Abstract
{	
    /**
     * Check for the resulted points of each form's field 
     * @param  object $object      [description]
     * @param  array $result      [description]
     * @param  string $type        [description]
     * @param  int $num         [description]
     * @param  int $totalfields [description]
     * @return array              [description]
     */
    public function getPoints($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields)
    
    {
    	// define array
    	$valueOfEachField = array();
    	$totalValueOfFields = 0;
    	
    	// iterate over all form's fields and retrieve array
		for ($count = 1; $count <= $totalNumberOfFields; $count++) {			
			// get each field
			$field = $formModelObject->{'findFieldby' . $formType . $formNumber . 'Id'}($result, $count);
			// push each field into an array			
            if($field->aplicable) {	
                $valueOfEachField[$count] = $field->puntos;
                $totalValueOfFields += $field->puntos;		
            } else {
                $valueOfEachField[$count] = 0;
            }    
		}

		// return the array of field's states
		return array('valueOfEachField' => $valueOfEachField, 'totalValueOfFields' => $totalValueOfFields);				
    }
    
    /**
     * Strategy pattern: call helper as broker method
     * @param  formModelObject $formModelObject      [description]
     * @param  array $result      [description]
     * @param  string $type        [description]
     * @param  int $formNumber         [description]
     * @param  int $totalNumberOfFields [description]
     * @return array              [description]
     */
    public function direct($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields)
    {
        return $this->getPoints($formModelObject, $result, $formType, $formNumber, $totalNumberOfFields);
    }
}
