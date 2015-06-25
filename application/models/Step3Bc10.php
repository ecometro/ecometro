<?php
/**
* Class Model for s_3_bcs_10 table
*/
class Model_Step3Bc10 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_bcs_10';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Bc10Field1' => array(
			'columns' => array('bc_10_1_id'),
			'refTableClass' => 'Model_Step3Bc10Field1'
	 	),
	 	'Step3Bc10Field2' => array(
			'columns' => array('bc_10_2_id'),
			'refTableClass' => 'Model_Step3Bc10Field2'
	 	),
	 	'Step3Bc10Field3' => array(
			'columns' => array('bc_10_3_id'),
			'refTableClass' => 'Model_Step3Bc10Field3'
	 	)
	);
	
	/**
	 * [createStep3Bc10 create a new row in the s_3_bcs_10 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Bc10($id)
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
	 * [updateStep3Bc10 update table s_3_bcs_10's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Bc [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Bc10($id, $idStep3Bc, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {
				// set the row data					
				$row->{'bc_10_' . $count . '_id'} = $idStep3Bc;			
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
	 * [findFieldbyBc10Id find field number by s_3_bcs_10's id]
	 * @param  [type] $bc10Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyBc10Id($bc10Id, $count)
	{
		$result = $bc10Id->findParentRow('Model_Step3Bc10Field' . $count);

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