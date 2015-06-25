<?php 

/**
 * Class Controller Helper for calculating emissions
 * =hce_form() step-3 from H2C
 */
class Zend_Controller_Action_Helper_AcvDisplayEmissions extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvDisplayEmissions($db, $projectId) 
    {
		
		try {	
			
			$table = 's_4' . '_mass_topten_' . $projectId;

			$sql_query = "
					SELECT
					subtype,
					kg FROM $table
				  ";

			$db->setFetchMode(Zend_Db::FETCH_OBJ);	  
			$topten = $db->fetchAssoc($sql_query);	  
			
			return $topten;

		} catch (Exception $e) {
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('Cannot query table.'));			
		}
	}
			

	public function direct($db, $projectId)
    {
        return $this->getAcvDisplayEmissions($db, $projectId);
    }
}