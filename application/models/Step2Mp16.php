<?php
/**
* Class Model for s_2_mps_16 table
*/
class Model_Step2Mp16 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_2_mps_16';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array (
		'Step2Mp16Field1' => array(
			'columns' => array('mp_16_1_id'),
			'refTableClass' => 'Model_Step2Mp16Field1'
	 	),
	 	'Step2Mp16Field2' => array(
			'columns' => array('mp_16_2_id'),
			'refTableClass' => 'Model_Step2Mp16Field2'
	 	),
	 	'Step2Mp16Field3' => array(
			'columns' => array('mp_16_3_id'),
			'refTableClass' => 'Model_Step2Mp16Field3'
	 	),
	 	'Step2Mp16Field4' => array(
			'columns' => array('mp_16_4_id'),
			'refTableClass' => 'Model_Step2Mp16Field4'
	 	),
	 	'Step2Mp16Field5' => array(
			'columns' => array('mp_16_5_id'),
			'refTableClass' => 'Model_Step2Mp16Field5'
	 	),
	 	'Step2Mp16Field6' => array(
			'columns' => array('mp_16_6_id'),
			'refTableClass' => 'Model_Step2Mp16Field6'
	 	),
	 	'Step2Mp16Field7' => array(
			'columns' => array('mp_16_7_id'),
			'refTableClass' => 'Model_Step2Mp16Field7'
	 	),
	 	'Step2Mp16Field8' => array(
			'columns' => array('mp_16_8_id'),
			'refTableClass' => 'Model_Step2Mp16Field8'
	 	)
	);
		
	/**
	 * [createStep2Mp16 create a new row in the s_2_mps_16 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp16($id)
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
	 * [updateStep2Mp16 update table s_2_mps_16's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp16($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {		
			try {
				// set the row data					
				$row->{'mp_16_' . $count . '_id'} = $idStep2Mp;			
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
	 * [findFieldbyMp16Id find field number by s_2_mps_16's id]
	 * @param  [type] $mp16Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyMp16Id($mp16Id, $count)
	{
		$result = $mp16Id->findParentRow('Model_Step2Mp16Field' . $count);

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