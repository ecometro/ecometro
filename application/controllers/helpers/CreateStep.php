<?php
/**
 * Documentation Block Here
 */
class Zend_Controller_Action_Helper_CreateStep extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Creates one step
     * @param  int $stepModelObject           [description]
     * @param  int $resultStep          [description]
     * @param  int $model               [description]
     * @param  int $numberOfForms            [description]
     * @param  string $type                [description]
     * @param  string $logfile             [description]
     * @param  [type] $porcentajeActividad [description]
     * @param  [type] $incremento          [description]
     * @return void                      [description]
     */
    public function getCreateStep($stepModelObject, $resultStep, $model, $numberOfForms, $type, $logfile, $porcentajeActividad, $incremento)    
    {  	
    	/********************* STEP ********************************/    		
		// step2mp1 model
		for($count = 1; $count <= $numberOfForms; $count++) {

			$object_model = 'Model_Step' . $model .  $type . $count;				
				
			${'step'. $model . $type .  $count . 'Model'} = new $object_model();

			// create  a new mp1 and retrieve the mp1's id
			$object_function = 'createStep' . $model . $type . $count;
				 
			${'resultstep' . $model . strtolower($type) . $count} = ${'step' . $model . $type . $count . 'Model'}->$object_function($resultStep);			
				
			for($field = 1; $field <= ${'step'. $model . $type .  $count . 'Model'}->getNumberOfColumns(strtolower($type)); $field++) {
				$object_field = 'Model_Step'. $model . $type . $count . 'Field' . $field;
				${'step' . $model . $type . $count . 'Field' . $field} = new $object_field();
				// create a new mp1 field and retrieve the mp1 field's id
				$object_function = 'createStep'. $model . $type . $count . 'Field' . $field; 
				${'resultstep'. $model . strtolower($type) . $count . 'field' . $field} = ${'step' . $model . $type . $count . 'Field' . $field}->$object_function(${'resultstep' . $model . strtolower($type) . $count});
				$object_function = 'updateStep' . $model . $type . $count;
				${'step' . $model . $type . $count . 'Model'}->$object_function(${'resultstep' . $model . strtolower($type) . $count}, ${'resultstep' . $model . strtolower($type) . $count . 'field' . $field}, $field);				
			}
				
			// crear y actualizar el log.txt del proyecto
			file_put_contents($logfile, $porcentajeActividad * ($incremento + $count) . "#" . "Crear " . strtolower($type) . " {$count}...<br />", LOCK_EX);				
			// actualizar step2 con el id del mp1
			$object_function = 'updateStep' . $model;
			$stepModelObject->$object_function($resultStep, ${'resultstep' . $model . strtolower($type) . $count}, $count, strtolower($type));
			// crear y actualizar el log.txt del proyecto							
		}						
		/********************* FIN STEP ********************************/	
    }
    
    /**
     * Strategy pattern: call helper as broker method
     * @param  int $stepModelObject           [description]
     * @param  int $resultStep          [description]
     * @param  int $model               [description]
     * @param  int $numberOfForms            [description]
     * @param  string $type                [description]
     * @param  string $logfile             [description]
     * @param  [type] $porcentajeActividad [description]
     * @param  [type] $incremento          [description]
     * @return void                      [description]
     */
    public function direct($stepModelObject, $resultStep, $model, $numberOfForms, $type, $logfile, $porcentajeActividad, $incremento)
    {
        return $this->getCreateStep($stepModelObject, $resultStep, $model, $numberOfForms, $type, $logfile, $porcentajeActividad, $incremento);
    }
}