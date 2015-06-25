<?php
/**
* Class Model for s_3_res_4 table
*/
class Model_Step3Re4 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_3_res_4';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3');
	
	protected $_referenceMap = array(
		'Step3Re4Field1' => array(
			'columns' => array('re_4_1_id'),
			'refTableClass' => 'Model_Step3Re4Field1'
	 	),
	 	'Step3Re4Field2' => array(
			'columns' => array('re_4_2_id'),
			'refTableClass' => 'Model_Step3Re4Field2'
	 	)
	);
	
	/**
	 * [createStep3Re4 create a new row in the s_3_res_4 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Re4($id)
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
	 * [updateStep3Re4 update table s_3_res_4's row]
	 * @param  [type] $id        [description]
	 * @param  [type] $idStep3Re [description]
	 * @param  [type] $count     [description]
	 * @return [type]            [description]
	 */
	public function updateStep3Re4($id, $idStep3Re, $count)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();	

		if($row) {
			try {	
				// set the row data					
				$row->{'re_4_' . $count . '_id'} = $idStep3Re;			
				// save the updated row
				$row->save();
				
				return true;

			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la ficha.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la ficha. No se ha encontrado.'));
		}						
	}

	/**
	 * [findFieldbyRe4Id find field number by s_3_res_4's id]
	 * @param  [type] $re4Id [description]
	 * @param  [type] $count [description]
	 * @return [type]        [description]
	 */
	public function findFieldbyRe4Id($re4Id, $count)
	{
		$result = $re4Id->findParentRow('Model_Step3Re4Field' . $count);
		
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
