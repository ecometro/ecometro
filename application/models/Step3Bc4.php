<?php
/**
* Class Model for s_3_bcs_4 table
*/
class Model_Step3Bc4 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_bcs_4';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Bc4Field1' => array(
			'columns' => array('bc_4_1_id'),
			'refTableClass' => 'Model_Step3Bc4Field1'
	 	),
	 	'Step3Bc4Field2' => array(
			'columns' => array('bc_4_2_id'),
			'refTableClass' => 'Model_Step3Bc4Field2'
	 	),
	 	'Step3Bc4Field3' => array(
			'columns' => array('bc_4_3_id'),
			'refTableClass' => 'Model_Step3Bc4Field3'
	 	),
	 	'Step3Bc4Field4' => array(
			'columns' => array('bc_4_4_id'),
			'refTableClass' => 'Model_Step3Bc4Field4'
	 	),
	 	'Step3Bc4Field5' => array(
			'columns' => array('bc_4_5_id'),
			'refTableClass' => 'Model_Step3Bc4Field5'
	 	),
	 	'Step3Bc4Field6' => array(
			'columns' => array('bc_4_6_id'),
			'refTableClass' => 'Model_Step3Bc4Field6'
	 	)
	);

	/**
	 * [createStep3Bc4 create a new row in the s_3_bcs_4 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Bc4($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->step_3_id = $id;		
				// now fetch the id of the row you just created and return it
				$id = $row->save();
				
				// return the id of the inserted row
				return $id;	
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}	
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear la ficha.'));
		}	
	 }

	/**
	 * [updateStep3Bc4 update table s_3_bcs_4's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Bc [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Bc4($id, $idStep3Bc, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {	
			try {	
				// set the row data					
				$row->{'bc_4_' . $count . '_id'} = $idStep3Bc;			
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
	 * [findFieldbyBc4Id find field number by s_3_bcs_4's id]
	 * @param  [type] $bc4Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyBc4Id($bc4Id, $count)
	{
		$result = $bc4Id->findParentRow('Model_Step3Bc4Field' . $count);

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
			foreach($column as $key => $value)				
				if($key == 'Field' && strpos($value, $formPrefix) !== false)
					$count++;
		}
		return $count;	 	
	}	
}