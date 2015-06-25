<?php
/**
* Class Model for s_2_mps_3 table
*/
class Model_Step2Mp3 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_2_mps_3';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array(
		'Step2Mp3Field1' => array(
			'columns' => array('mp_3_1_id'),
			'refTableClass' => 'Model_Step2Mp3Field1'
	 	),
	 	'Step2Mp3Field2' => array(
			'columns' => array('mp_3_2_id'),
			'refTableClass' => 'Model_Step2Mp3Field2'
	 	),
	 	'Step2Mp3Field3' => array(
			'columns' => array('mp_3_3_id'),
			'refTableClass' => 'Model_Step2Mp3Field3'
	 	),
	 	'Step2Mp3Field4' => array(
			'columns' => array('mp_3_4_id'),
			'refTableClass' => 'Model_Step2Mp3Field4'
	 	),
	 	'Step2Mp3Field5' => array(
			'columns' => array('mp_3_5_id'),
			'refTableClass' => 'Model_Step2Mp3Field5'
	 	),
	 	'Step2Mp3Field6' => array(
			'columns' => array('mp_3_6_id'),
			'refTableClass' => 'Model_Step2Mp3Field6'
	 	),
	 	'Step2Mp3Field7' => array(
			'columns' => array('mp_3_7_id'),
			'refTableClass' => 'Model_Step2Mp3Field7'
	 	)
	);
	
	/**
	 * [createStep2Mp3 create a new row in the s_2_mps_3 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp3($id)
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
	 * [updateStep2Mp3 update table s_2_mps_3's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp3($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();	

		if($row) {
			try {	
				// set the row data					
				$row->{'mp_3_' . $count . '_id'} = $idStep2Mp;			
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
	 * [findFieldbyMp3Id find field number by s_2_mps_3's id]
	 * @param  [type] $mp3Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyMp3Id($mp3Id, $count)
	{
		$result = $mp3Id->findParentRow('Model_Step2Mp3Field' . $count);

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