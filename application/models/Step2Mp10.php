<?php
/**
* Class Model for s_2_mps_10 table
*/
class Model_Step2Mp10 extends Zend_Db_Table_Abstract
{	
	protected $_name = 's_2_mps_10';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array (
		'Step2Mp10Field1' => array(
			'columns' => array('mp_10_1_id'),
			'refTableClass' => 'Model_Step2Mp10Field1'
	 	),
	 	'Step2Mp10Field2' => array(
			'columns' => array('mp_10_2_id'),
			'refTableClass' => 'Model_Step2Mp10Field2'
	 	),
	 	'Step2Mp10Field3' => array(
			'columns' => array('mp_10_3_id'),
			'refTableClass' => 'Model_Step2Mp10Field3'
	 	),
	 	'Step2Mp10Field4' => array(
			'columns' => array('mp_10_4_id'),
			'refTableClass' => 'Model_Step2Mp10Field4'
	 	),
	 	'Step2Mp10Field5' => array(
			'columns' => array('mp_10_5_id'),
			'refTableClass' => 'Model_Step2Mp10Field5'
	 	),
	 	'Step2Mp10Field6' => array(
			'columns' => array('mp_10_6_id'),
			'refTableClass' => 'Model_Step2Mp10Field6'
	 	),
	 	'Step2Mp10Field7' => array(
			'columns' => array('mp_10_7_id'),
			'refTableClass' => 'Model_Step2Mp10Field7'
	 	),
	 	'Step2Mp10Field8' => array(
			'columns' => array('mp_10_8_id'),
			'refTableClass' => 'Model_Step2Mp10Field8'
	 	)
	);
	
	/**
	 * [createStep2Mp10 create a new row in the s_2_mps_10 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp10($id)
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
	 * [updateStep2Mp10 update table s_2_mps_10's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp10($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {	
			try {		
				// set the row data					
				$row->{'mp_10_' . $count . '_id'} = $idStep2Mp;			
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
	 * [findFieldbyMp10Id find field number by s_2_mps_10's id]
	 * @param  [type] $mp10Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyMp10Id($mp10Id, $count)
	{
		$result = $mp10Id->findParentRow('Model_Step2Mp10Field' . $count);

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