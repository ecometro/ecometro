<?php
/**
 * Class Controller Helper for getting all field's points
 */
class Zend_Controller_Action_Helper_GraphData extends Zend_Controller_Action_Helper_Abstract
{	
    /**
     * [getGraphData description]
     * @param  [type] $step3Model    [description]
     * @param  [type] $modelCalculus [description]
     * @param  [type] $result        [description]
     * @param  [type] $projectId    [description]
     * @param  array  $forms         [description]
     * @return [type]                [description]
     */
    public function getGraphData($step3Model, $modelCalculus, $result, $projectId, array $forms)
    
    {   
    	foreach ($forms as $form) {   

            $totalPoints = 0;
            $maxPoints = 0;            

            for ($count = 1; $count <= $form[1]['numForms']; $count++) {
                
                // instantiate form model
                $formModelClass = 'Model_Step3' . $form[0] . $count;
                $formModelObject = new $formModelClass();
                $nrColumnsTotal = $formModelObject->getNumberOfColumns(strtolower($form[0]));
                
                // find form by project's id     
                $result = $step3Model->findStep3byProjectId($projectId, $count, $form[0]);                
                $points = Zend_Controller_Action_HelperBroker::getStaticHelper('Points')->direct($formModelObject, $result, $form[0], $count, $nrColumnsTotal);
                              
                $calculus = $modelCalculus->getFactAndMax(strtolower($form[0]) . '_' . $count, $nrColumnsTotal);                                    
                $totalPoints += $points['totalValueOfFields'];                
                
                for($j = 0; $j <= count($calculus['maximumPoints'])-1; $j++) {           
                    if(is_array($calculus['vectorPoints'][$j]))
                        $maxPoints += $calculus['weightingFactor'][$j] * $calculus['vectorPoints'][$j]['v5'];                  
                }
            }
                        
            $totalResults[$form[0]] = array($maxPoints, $totalPoints, round($totalPoints * 10/$maxPoints, 2));                                              
        }

        return $totalResults;				
    }
    
    /**
     * [direct description]
     * @param  [type] $forms [description]
     * @return [type]        [description]
     */
    public function direct($step3Model, $modelCalculus, $result, $projectId, $forms)
    {
        return $this->getGraphData($step3Model, $modelCalculus, $result, $projectId, $forms);
    }
}
