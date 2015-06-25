<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_CheckValidField extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * [getCheckValidField description]
     * @param  [type] $stepNumber [description]
     * @return [type]             [description]
     */
    public function getCheckValidField($stepNumber)    
    {                  
        if($this->getActionController()->getRequest()->isPost()) {            
    
            $idOfTheForm = $this->getRequest()->getPost('idOfTheForm', null);
            $indexOfTheField = $this->getRequest()->getPost('indexOfTheField', null);
            $valueOfTheField = $this->getRequest()->getPost('valueOfTheField', null);
                        
            $stepFormClass = 'Form_Step'. $stepNumber . ucfirst($idOfTheForm) .  'Form';               
            $stepForm = new $stepFormClass();
                         
            $valid = $stepForm->isValidPartial($this->getRequest()->getPost('idOfTheField', null));

            if(!$valid)
                $valid = $stepForm->getMessages();
        }                               
                            
        $json = array(                   
            'valid' => $valid,                    
        );
                        
        header('Content-type: application/json');       
        echo Zend_Json::encode($json);
    }

    /**
     * [direct description]
     * @param  [type] $stepNumber [description]
     * @return [type]             [description]
     */
    public function direct($stepNumber)
    {
        return $this->getCheckValidField($stepNumber);
    }
}
?>