<?php
/**
* Class Model for s_2_mps_1 table
*/
class Model_Step2Mp1 extends Zend_Db_Table_Abstract
{	
	protected $_name = 's_2_mps_1';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array (
		'Step2Mp1Field1' => array(
			'columns' => array('mp_1_1_id'),
			'refTableClass' => 'Model_Step2Mp1Field1'
	 	),
	 	'Step2Mp1Field2' => array(
			'columns' => array('mp_1_2_id'),
			'refTableClass' => 'Model_Step2Mp1Field2'
	 	),
	 	'Step2Mp1Field3' => array(
			'columns' => array('mp_1_3_id'),
			'refTableClass' => 'Model_Step2Mp1Field3'
	 	),
	 	'Step2Mp1Field4' => array(
			'columns' => array('mp_1_4_id'),
			'refTableClass' => 'Model_Step2Mp1Field4'
	 	),
	 	'Step2Mp1Field5' => array(
			'columns' => array('mp_1_5_id'),
			'refTableClass' => 'Model_Step2Mp1Field5'
	 	),
	 	'Step2Mp1Field6' => array(
			'columns' => array('mp_1_6_id'),
			'refTableClass' => 'Model_Step2Mp1Field6'
	 	),
	 	'Step2Mp1Field7' => array(
			'columns' => array('mp_1_7_id'),
			'refTableClass' => 'Model_Step2Mp1Field7'
	 	),
	 	'Step2Mp1Field8' => array(
			'columns' => array('mp_1_8_id'),
			'refTableClass' => 'Model_Step2Mp1Field8'
	 	)
	);
	
	/**
	 * [createStep2Mp1 create a new row in the s_2_mps_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp1($id)
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
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear la ficha.'));
		}			
	}

	/**
	 * [updateStep2Mp1 update table s_2_mps_1's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp1($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();		

		if($row) {
			try {
				// set the row data					
				$row->{'mp_1_' . $count . '_id'} = $idStep2Mp;			
				// save the updated row
				$row->save();		
					
				// return boolean true
				return true;
			} catch(Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la ficha.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la ficha. No se ha encontrado la ficha.'));
		}					
	}

	/**
	 * [findFieldbyMp1Id find field number by s_2_mps_1's id]
	 * @param  [type] $mp1Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyMp1Id($mp1Id, $count)
	{
		$result = $mp1Id->findParentRow('Model_Step2Mp1Field' . $count);

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