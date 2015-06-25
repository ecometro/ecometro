<?php
/**
* Class Model for s_1_forms_1 table
*/
class Model_Step1Form1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_1_forms_1';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step1');
	
	/**
	 * [createStep1Form1 create a new row in the s_1_forms_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep1Form1($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->step_1_id = $id;		
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
		$invalidColumns = array('id', 'photo', 'modified', 'completed', 'step_1_id');
		foreach($columns as $column) {
			foreach($column as $key => $value) {			
				if($key == 'Field' && !in_array($value, $invalidColumns))
					$count++;
			}	
		}		
		return $count;	 	
	}	
}