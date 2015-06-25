<?php
/**
* Class Model for s_2_mps_9 table
*/
class Model_Step2Mp9 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_2_mps_9';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step2');
	
	protected $_referenceMap = array(
		'Step2Mp9Field1' => array(
			'columns' => array('mp_9_1_id'),
			'refTableClass' => 'Model_Step2Mp9Field1'
	 	),
	 	'Step2Mp9Field2' => array(
			'columns' => array('mp_9_2_id'),
			'refTableClass' => 'Model_Step2Mp9Field2'
	 	)
	);

	/**
	 * [createStep2Mp9 create a new row in the s_2_mps_9 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp9($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->step_2_id = $id;		
				// now fetch the id of the row you just created and return it
				$id = $row->save();
					
				// return the id of the inserted row
				return $id;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}		
	 }
	
	/**
	 * [updateStep2Mp9 update table s_2_mps_9's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp9($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {		
				// set the row data					
				$row->{'mp_9_' . $count . '_id'} = $idStep2Mp;			
				// save the updated row
				$row->save();
					
				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}					
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}
	 }

	/**
	 * [findFieldbyMp9Id find field number by s_2_mps_9's id]
	 * @param  [type] $mp9Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyMp9Id($mp9Id, $count)
	{
		$result = $mp9Id->findParentRow('Model_Step2Mp9Field' . $count);

		// return resulted row
		return $result;												
	}

	/**
	 * [getNumberOfColumns description]
	 * @return [type] [description]
	 */
	public function  getNumberOfColumns($formPrefix)
	{
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$dbName = $db->fetchOne('select DATABASE();');
		$sql = 'SHOW COLUMNS FROM ' .  $dbName . '.' . $this->_name . ';';
		$columns = $db->query($sql)->fetchAll(); 
		$count = 0;
		foreach($columns as $column) {
			foreach($column as $key => $value) {				
				if($key == 'Field' && substr($value, 0, 2) == $formPrefix)
					$count++;
			}	
		}
		return $count;	 	
	} 	 
}