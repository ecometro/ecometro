<?php
/**
* Class Model for s_3_bcs_8 table
*/
class Model_Step3Bc8 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_bcs_8';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Bc8Field1' => array(
			'columns' => array('bc_8_1_id'),
			'refTableClass' => 'Model_Step3Bc8Field1'
	 	),
	 	'Step3Bc8Field2' => array(
			'columns' => array('bc_8_2_id'),
			'refTableClass' => 'Model_Step3Bc8Field2'
	 	),
	 	'Step3Bc8Field3' => array(
			'columns' => array('bc_8_3_id'),
			'refTableClass' => 'Model_Step3Bc8Field3'
	 	)
	);
	
	/**
	 * [createStep3Bc8 create a new row in the s_3_bcs_8 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Bc8($id)
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
	 * [updateStep3Bc8 update table s_3_bcs_8's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Bc [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Bc8($id, $idStep3Bc, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();	

		if($row) {
			try {		
				// set the row data					
				$row->{'bc_8_' . $count . '_id'} = $idStep3Bc;			
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
	 * [findFieldbyBc8Id find field number by s_3_bcs_8's id]
	 * @param  [type] $bc8Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyBc8Id($bc8Id, $count)
	{
		$result = $bc8Id->findParentRow('Model_Step3Bc8Field' . $count);

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