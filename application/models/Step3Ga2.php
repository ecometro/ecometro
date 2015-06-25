<?php
/**
* Class Model for s_3_gas_2 table
*/
class Model_Step3Ga2 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_gas_2';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Ga2Field1' => array(
			'columns' => array('ga_2_1_id'),
			'refTableClass' => 'Model_Step3Ga2Field1'
	 	),
	 	'Step3Ga2Field2' => array(
			'columns' => array('ga_2_2_id'),
			'refTableClass' => 'Model_Step3Ga2Field2'
	 	),
	 	'Step3Ga2Field3' => array(
			'columns' => array('ga_2_3_id'),
			'refTableClass' => 'Model_Step3Ga2Field3'
	 	)
	);
	
	/**
	 * [createStep3Ga2 create a new row in the s_3_gas_2 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Ga2($id)
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
	 * [updateStep3Ga2 update table s_3_gas_2's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Ga [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Ga2($id, $idStep3Ga, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {			
				// set the row data					
				$row->{'ga_2_' . $count . '_id'} = $idStep3Ga;			
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
	 * [findFieldbyGa2Id find field number by s_3_gas_2's id]
	 * @param  [type] $ga2Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyGa2Id($ga2Id, $count)
	{
		$result = $ga2Id->findParentRow('Model_Step3Ga2Field' . $count);

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