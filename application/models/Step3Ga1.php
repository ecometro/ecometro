<?php
/**
* Class Model for s_3_gas_1 table
*/
class Model_Step3Ga1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_gas_1';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Ga1Field1' => array(
			'columns' => array('ga_1_1_id'),
			'refTableClass' => 'Model_Step3Ga1Field1'
	 	),
	 	'Step3Ga1Field2' => array(
			'columns' => array('ga_1_2_id'),
			'refTableClass' => 'Model_Step3Ga1Field2'
	 	),
	 	'Step3Ga1Field3' => array(
			'columns' => array('ga_1_3_id'),
			'refTableClass' => 'Model_Step3Ga1Field3'
	 	),
	 	'Step3Ga1Field4' => array(
			'columns' => array('ga_1_4_id'),
			'refTableClass' => 'Model_Step3Ga1Field4'
	 	),
	 	'Step3Ga1Field5' => array(
			'columns' => array('ga_1_5_id'),
			'refTableClass' => 'Model_Step3Ga1Field5'
	 	),
	 	'Step3Ga1Field6' => array(
			'columns' => array('ga_1_6_id'),
			'refTableClass' => 'Model_Step3Ga1Field6'
	 	)
	);

	/**
	 * [createStep3Ga1 create a new row in the s_3_gas_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Ga1($id)
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
	 * [updateStep3Ga1 update table s_3_gas_1's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Ga [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Ga1($id, $idStep3Ga, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();	

		if($row) {
			try	 {
				// set the row data					
				$row->{'ga_1_' . $count . '_id'} = $idStep3Ga;			
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
	 * [findFieldbyGa1Id find field number by s_3_gas_1's id]
	 * @param  [type] $ga1Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyGa1Id($ga1Id, $count)
	{
		$result = $ga1Id->findParentRow('Model_Step3Ga1Field' . $count);

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