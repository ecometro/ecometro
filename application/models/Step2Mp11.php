<?php
/**
* Class Model for s_2_mps_11 table
*/
class Model_Step2Mp11 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_2_mps_11';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array (
		'Step2Mp11Field1' => array(
			'columns' => array('mp_11_1_id'),
			'refTableClass' => 'Model_Step2Mp11Field1'
	 	),
	 	'Step2Mp11Field2' => array(
			'columns' => array('mp_11_2_id'),
			'refTableClass' => 'Model_Step2Mp11Field2'
	 	)
	);

	/**
	 * [createStep2Mp11 create a new row in the s_2_mps_11 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp11($id)
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
	 * [updateStep2Mp11 update table s_2_mps_11's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp11($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {			
				// set the row data					
				$row->{'mp_11_' . $count . '_id'} = $idStep2Mp;			
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
	 * [findFieldbyMp11Id find field number by s_2_mps_11's id]
	 * @param  [type] $mp11Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyMp11Id($mp11Id, $count)
	{
		$result = $mp11Id->findParentRow('Model_Step2Mp11Field' . $count);

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