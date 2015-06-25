<?php
/**
* Class Model for s_3_ges_1 table
*/
class Model_Step3Ge1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_ges_1';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Ge1Field1' => array(
			'columns' => array('ge_1_1_id'),
			'refTableClass' => 'Model_Step3Ge1Field1'
	 	),
	 	'Step3Ge1Field2' => array(
			'columns' => array('ge_1_2_id'),
			'refTableClass' => 'Model_Step3Ge1Field2'
	 	),
	 	'Step3Ge1Field3' => array(
			'columns' => array('ge_1_3_id'),
			'refTableClass' => 'Model_Step3Ge1Field3'
	 	),
	 	'Step3Ge1Field4' => array(
			'columns' => array('ge_1_4_id'),
			'refTableClass' => 'Model_Step3Ge1Field4'
	 	),
	 	'Step3Ge1Field5' => array(
			'columns' => array('ge_1_5_id'),
			'refTableClass' => 'Model_Step3Ge1Field5'
	 	),
	 	'Step3Ge1Field6' => array(
			'columns' => array('ge_1_6_id'),
			'refTableClass' => 'Model_Step3Ge1Field6'
	 	)
	);
	
	/**
	 * [createStep3Ge1 create a new row in the s_3_ges_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Ge1($id)
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
	 * [updateStep3Ge1 update table s_3_ges_1's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Ge [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Ge1($id, $idStep3Ge, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {		
				// set the row data					
				$row->{'ge_1_' . $count . '_id'} = $idStep3Ge;			
				// save the updated row
				$row->save();
					
				// return boolean true
				return true;
			}  catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}								
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}
	}

	/**
	 * [findFieldbyGe1Id find field number by s_3_ges_1's id]
	 * @param  [type] $ge1Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyGe1Id($ge1Id, $count)
	{
		$result = $ge1Id->findParentRow('Model_Step3Ge1Field' . $count);

		// return the resulted row
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