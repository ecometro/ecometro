<?php
/**
* Class Model for steps_4 table
*/
class Model_Step4 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'steps_4';
	protected $_primary = 'id';		
	protected $_referenceMap = array(
		'Step4Pmtm' => array(
			'columns' => array('s_4_pmtm_id'),
			'refTableClass' => 'Model_Step4Pmtm'
	 	)		
	);

	/**
	 * [createStep4 create a new row in the steps_4 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep4($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->project_id = $id;				
				// now fetch the id of the row you just created and return it
				$id = $row->save();

				// return the id of the inserted row
				return $id;	
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el paso.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el paso.'));
		}		
	}

	/**
	 * [updateStep4 update steps_4's row]
	 * @param  [type] $id      [description]
	 * @param  [type] $idStep4 [description]
	 * @param  [type] $type    [description]
	 * @return [type]          [description]
	 */
	public function updateStep4($id, $idStep4, $type)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {		
				// set the row data					
				$row->{'s_4_'. $type . '_id'} = $idStep4;			
				// save the updated row
				$row->save();		

				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el paso.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar el paso.'));
		}					
	}
	 
	/**
	 * [findStep4byProjectId find steps_4 by project id]
	 * @param  [type] $id   [description]
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function findStep4byProjectId($id, $type)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
				
		$row = $this->fetchRow($query);							
		$result = $row->findParentRow('Model_Step4' . $type);	
			
		// return resulted row
		return $result;														 
	}	
}