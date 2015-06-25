<?php
/**
* Class Model for s_2_mps_12 table
*/
class Model_Step2Mp12 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_2_mps_12';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step2');	
	protected $_referenceMap = array(
		'Step2Mp12Field1' => array(
			'columns' => array('mp_12_1_id'),
			'refTableClass' => 'Model_Step2Mp12Field1'
	 	),
	 	'Step2Mp12Field2' => array(
			'columns' => array('mp_12_2_id'),
			'refTableClass' => 'Model_Step2Mp12Field2'
	 	),
	 	'Step2Mp12Field3' => array(
			'columns' => array('mp_12_3_id'),
			'refTableClass' => 'Model_Step2Mp12Field3'
	 	),
	 	'Step2Mp12Field4' => array(
			'columns' => array('mp_12_4_id'),
			'refTableClass' => 'Model_Step2Mp12Field4'
	 	),
	 	'Step2Mp12Field5' => array(
			'columns' => array('mp_12_5_id'),
			'refTableClass' => 'Model_Step2Mp12Field5'
	 	)
	);
	
	/**
	 * [createStep2Mp12 create a new row in the s_2_mps_12 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp12($id)
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
	 * [updateStep2Mp12 update table s_2_mps_12's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep2Mp [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep2Mp12($id, $idStep2Mp, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();		

		if($row) {	
			try {
				// set the row data					
				$row->{'mp_12_' . $count . '_id'} = $idStep2Mp;			
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
	 * [findFieldbyMp12Id find field number by s_2_mps_12's id]
	 * @param  [type] $mp12Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyMp12Id($mp12Id, $count)
	{
		$result = $mp12Id->findParentRow('Model_Step2Mp12Field' . $count);

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