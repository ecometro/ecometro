<?php
/**
 * Class Controller Helper for getting all form's fields states
 */
class Zend_Controller_Action_Helper_FieldsData extends Zend_Controller_Action_Helper_Abstract
{
	
    /**
     * [getFieldsData description]
     * @param  [type] $projectId [description]
     * @param  array  $allowed   [description]
     * @return [type]            [description]
     */
    public function getFieldsData($projectId, array $allowed)    
    {        
        $fieldsData = array();        

    	foreach($allowed AS $keyform => $values) {   
                        
            $formType = ucfirst(substr($keyform, 0, -1));
            $fieldNumber = substr($keyform, -1);
            $stepModelClass = 'Model_Step' . $values['step'];
            $stepModelObject = new $stepModelClass();            
            ${'step' . $values['step'] . 'Project'} = $stepModelObject->{'findStep' . $values['step'] . 'byProjectId'}($projectId, $fieldNumber, $formType);      
            $object = 'Model_Step' . $values['step'] . $formType . $fieldNumber;
            ${'step' . $values['step'] . $formType . $fieldNumber . 'Model'} = new $object();                              

            foreach ($values['fields'] AS $key => $value) {                    
                    
                $object = 'Model_Step' . $values['step'] . $formType . $fieldNumber . 'Field' . $key; 
                ${'step'. $values['step'] . $formType . $fieldNumber .'Field' . $key} = new $object();
                $tableName = ${'step'. $values['step'] . $formType . $fieldNumber .'Field' . $key}->getTableName();
                $fieldUnit = ${'step'. $values['step'] . $formType . $fieldNumber .'Field' . $key}->getFieldComment();
                $fieldType = Zend_Controller_Action_HelperBroker::getStaticHelper('FieldType')->direct($values['step'], $formType . $fieldNumber, $key);

                $function = 'findFieldby' . $formType . $fieldNumber .'Id';
                                   
                if($fieldType == 'boolean') {
                    if(${'step' . $values['step'] . $formType . $fieldNumber . 'Model'}->$function(${'step' . $values['step'] . 'Project'}, $key)->usuario_dato_1 == 0 && ${'step' . $values['step'] . $formType . $fieldNumber . 'Model'}->$function(${'step' . $values['step'] . 'Project'}, $key)->usuario_dato_1 != null)
                        $data = 'No';           
                    elseif(${'step' . $values['step'] . $formType . $fieldNumber . 'Model'}->$function(${'step' . $values['step'] . 'Project'}, $key)->usuario_dato_1 == 1)
                        $data = 'Si';
                    else
                        $data = '';
                } elseif($fieldType == 'float') {
                    $filter_es = new Zend_Filter_NormalizedToLocalized();
                    $data = $filter_es->filter(${'step' . $values['step'] . $formType . $fieldNumber . 'Model'}->$function(${'step' . $values['step'] . 'Project'}, $key)->usuario_dato_1);                  
                } else
                    $data = ${'step' . $values['step'] . $formType . $fieldNumber . 'Model'}->$function(${'step' . $values['step'] . 'Project'}, $key)->usuario_dato_1;    
               
                $fieldsData[$keyform . $values['fields'][$key]] = array($tableName,  $data, $fieldUnit);                
            }

        }

        return $fieldsData;				
    }
        
    public function direct($projectId, $allowed)
    {
        return $this->getFieldsData($projectId, $allowed);
    }
}