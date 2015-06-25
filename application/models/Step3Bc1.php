<?php
/**
* Class Model for s_3_bcs_1 table
*/
class Model_Step3Bc1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_bcs_1';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Bc1Field1' => array(
			'columns' => array('bc_1_1_id'),
			'refTableClass' => 'Model_Step3Bc1Field1'
	 	),
	 	'Step3Bc1Field2' => array(
			'columns' => array('bc_1_2_id'),
			'refTableClass' => 'Model_Step3Bc1Field2'
	 	),
	 	'Step3Bc1Field3' => array(
			'columns' => array('bc_1_3_id'),
			'refTableClass' => 'Model_Step3Bc1Field3'
	 	),
	 	'Step3Bc1Field4' => array(
			'columns' => array('bc_1_4_id'),
			'refTableClass' => 'Model_Step3Bc1Field4'
	 	),
	 	'Step3Bc1Field5' => array(
			'columns' => array('bc_1_5_id'),
			'refTableClass' => 'Model_Step3Bc1Field5'
	 	),
	 	'Step3Bc1Field6' => array(
			'columns' => array('bc_1_6_id'),
			'refTableClass' => 'Model_Step3Bc1Field6'
	 	),
	 	'Step3Bc1Field7' => array(
			'columns' => array('bc_1_7_id'),
			'refTableClass' => 'Model_Step3Bc1Field7'
	 	),
	 	'Step3Bc1Field8' => array(
			'columns' => array('bc_1_8_id'),
			'refTableClass' => 'Model_Step3Bc1Field8'
	 	),
	 	'Step3Bc1Field9' => array(
			'columns' => array('bc_1_9_id'),
			'refTableClass' => 'Model_Step3Bc1Field9'
	 	),
	 	'Step3Bc1Field10' => array(
			'columns' => array('bc_1_10_id'),
			'refTableClass' => 'Model_Step3Bc1Field10'
	 	)
	);

	/**
	 * [createStep3Bc1 create a new row in the s_3_bcs_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Bc1($id)
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
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}	
	}

	/**
	 * [updateStep3Bc1 update table s_3_bcs_1's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Bc [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Bc1($id, $idStep3Bc, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {		
			try {
				// set the row data					
				$row->{'bc_1_' . $count . '_id'} = $idStep3Bc;			
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
	 * [findFieldbyBc1Id find field number by s_3_bcs_1's id]
	 * @param  [type] $bc1Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyBc1Id($bc1Id, $count)
	{
		$result = $bc1Id->findParentRow('Model_Step3Bc1Field' . $count);

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