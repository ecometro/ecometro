<?php
/**
* Class Model for s_3_bcs_7 table
*/
class Model_Step3Bc7 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_bcs_7';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Bc7Field1' => array(
			'columns' => array('bc_7_1_id'),
			'refTableClass' => 'Model_Step3Bc7Field1'
	 	),
	 	'Step3Bc7Field2' => array(
			'columns' => array('bc_7_2_id'),
			'refTableClass' => 'Model_Step3Bc7Field2'
	 	),
	 	'Step3Bc7Field3' => array(
			'columns' => array('bc_7_3_id'),
			'refTableClass' => 'Model_Step3Bc7Field3'
	 	),
	 	'Step3Bc7Field4' => array(
			'columns' => array('bc_7_4_id'),
			'refTableClass' => 'Model_Step3Bc7Field4'
	 	),
	 	'Step3Bc7Field5' => array(
			'columns' => array('bc_7_5_id'),
			'refTableClass' => 'Model_Step3Bc7Field5'
	 	),
	 	'Step3Bc7Field6' => array(
			'columns' => array('bc_7_6_id'),
			'refTableClass' => 'Model_Step3Bc7Field6'
	 	)
	);

	/**
	 * [createStep3Bc7 create a new row in the s_3_bcs_7 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Bc7($id)
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
	 * [updateStep3Bc7 update table s_3_bcs_7's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Bc [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Bc7($id, $idStep3Bc, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try	{
				// set the row data					
				$row->{'bc_7_' . $count . '_id'} = $idStep3Bc;			
				// save the updated row
				$row->save();		
					
				// return boolean row
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}					
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}
	}

	/**
	 * [findFieldbyBc7Id find field number by s_3_bcs_7's id]
	 * @param  [type] $bc7Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyBc7Id($bc7Id, $count)
	{
		$result = $bc7Id->findParentRow('Model_Step3Bc7Field' . $count);

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