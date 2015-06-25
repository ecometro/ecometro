<?php
/**
* Class Model for s_3_res_9 table
*/
class Model_Step3Re9 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_res_9';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Re9Field1' => array(
			'columns' => array('re_9_1_id'),
			'refTableClass' => 'Model_Step3Re9Field1'
	 	),
	 	'Step3Re9Field2' => array(
			'columns' => array('re_9_2_id'),
			'refTableClass' => 'Model_Step3Re9Field2'
	 	),
	 	'Step3Re9Field3' => array(
			'columns' => array('re_9_3_id'),
			'refTableClass' => 'Model_Step3Re9Field3'
	 	),
	 	'Step3Re9Field4' => array(
			'columns' => array('re_9_4_id'),
			'refTableClass' => 'Model_Step3Re9Field4'
	 	),
	 	'Step3Re9Field5' => array(
			'columns' => array('re_9_5_id'),
			'refTableClass' => 'Model_Step3Re9Field5'
	 	),
	 	'Step3Re9Field6' => array(
			'columns' => array('re_9_6_id'),
			'refTableClass' => 'Model_Step3Re9Field6'
	 	)
	);

	/**
	 * [createStep3Re9 create a new row in the s_3_res_9 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Re9($id)
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
	 * [updateStep3Re9 update table s_3_res_9's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Re [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Re9($id, $idStep3Re, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {			
			try {
				// set the row data					
				$row->{'re_9_' . $count . '_id'} = $idStep3Re;			
				// save the updated row
				$row->save();
				
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}

		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}					
	}

	/**
	 * [findFieldbyRe9Id find field number by s_3_res_9's id]
	 * @param  [type] $re9Id [description]
	 * @param  [type] $count  [description]
	 * @return [type]         [description]
	 */
	public function findFieldbyRe9Id($re9Id, $count)
	{
		$result = $re9Id->findParentRow('Model_Step3Re9Field' . $count);

		// return resulted row
		return $result;												
	} 

	/**
	 * [getNumberOfColumns description]
	 * @return [type] [description]
	 */
	public function  getNumberOfColumns()
	{
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$dbName = $db->fetchOne('select DATABASE();');
		$sql = 'SHOW COLUMNS FROM ' .  $dbName . '.' . $this->_name . ';';
		$columns = $db->query($sql)->fetchAll(); 
		$count = 0;
		foreach($columns as $column) {
			foreach($column as $key => $value)				
				if($key == 'Field' && strpos($value, 're') !== false)
					$count++;
		}
		return $count;	 	
	}	
}