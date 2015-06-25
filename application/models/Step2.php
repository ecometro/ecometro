<?php
/**
* Class Model for steps_2 table
*/
class Model_Step2 extends Zend_Db_Table_Abstract
{	
	protected $_name = 'steps_2';
	protected $_primary = 'id';

	protected $_dependentTables = array('Model_Project');
			
	protected $_referenceMap = array (
		'Step2Mp1' => array(
			'columns' => array('s_2_mp_1_id'),
			'refTableClass' => 'Model_Step2Mp1'
	 	),
	 	'Step2Mp2' => array(
			'columns' => array('s_2_mp_2_id'),
			'refTableClass' => 'Model_Step2Mp2'
	 	),
	 	'Step2Mp3' => array(
			'columns' => array('s_2_mp_3_id'),
			'refTableClass' => 'Model_Step2Mp3'
	 	),
	 	'Step2Mp4' => array(
			'columns' => array('s_2_mp_4_id'),
			'refTableClass' => 'Model_Step2Mp4'
	 	),
	 	'Step2Mp5' => array(
			'columns' => array('s_2_mp_5_id'),
			'refTableClass' => 'Model_Step2Mp5'
	 	),
	 	'Step2Mp6' => array(
			'columns' => array('s_2_mp_6_id'),
			'refTableClass' => 'Model_Step2Mp6'
	 	),
	 	'Step2Mp7' => array(
			'columns' => array('s_2_mp_7_id'),
			'refTableClass' => 'Model_Step2Mp7'
	 	),
	 	'Step2Mp8' => array(
			'columns' => array('s_2_mp_8_id'),
			'refTableClass' => 'Model_Step2Mp8'
	 	),
	 	'Step2Mp9' => array(
			'columns' => array('s_2_mp_9_id'),
			'refTableClass' => 'Model_Step2Mp9'
	 	),
	 	'Step2Mp10' => array(
			'columns' => array('s_2_mp_10_id'),
			'refTableClass' => 'Model_Step2Mp10'
	 	),
	 	'Step2Mp11' => array(
			'columns' => array('s_2_mp_11_id'),
			'refTableClass' => 'Model_Step2Mp11'
	 	),
	 	'Step2Mp12' => array(
			'columns' => array('s_2_mp_12_id'),
			'refTableClass' => 'Model_Step2Mp12'
	 	),
	 	'Step2Mp13' => array(
			'columns' => array('s_2_mp_13_id'),
			'refTableClass' => 'Model_Step2Mp13'
	 	),
	 	'Step2Mp14' => array(
			'columns' => array('s_2_mp_14_id'),
			'refTableClass' => 'Model_Step2Mp14'
	 	),
	 	'Step2Mp15' => array(
			'columns' => array('s_2_mp_15_id'),
			'refTableClass' => 'Model_Step2Mp15'
	 	),
	 	'Step2Mp16' => array(
			'columns' => array('s_2_mp_16_id'),
			'refTableClass' => 'Model_Step2Mp16'
	 	)
	);
	
	/**
	 * [createStep2 create a new row in the steps_2 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->project_id = $id;										
				// now fetch the id of the row you just created and return it
				$id = $row->save();
					
				// return the id of the inserted row
				return $id;	
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el paso.'));	
			}		
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el paso.'));
		}	
	}
	
	/**
	 * [updateStep2 update steps_2's row]
	 * @param  [type] $id      [description]
	 * @param  [type] $idStep2 [description]
	 * @param  [type] $count   [description]
	 * @param  [type] $type    [description]
	 * @return [type]          [description]
	 */
	public function updateStep2($id, $idStep2, $count, $type)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {			
				// set the row data					
				$row->{'s_2_' . $type . '_' . $count . '_id'} = $idStep2;			
				// save the updated row
				$row->save();
					
				// return boolean true	
				return true;
			} catch(Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el paso.'));
			}	
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el paso. No se ha encontrado el paso.'));
		}						
	}

	/**
	 * [findStep2byProjectId find steps_2 by project id]
	 * @param  [type] $id    [description]
	 * @param  [type] $count [description]
	 * @param  [type] $type  [description]
	 * @return [type]        [description]
	 */
	public function findStep2byProjectId($id, $count, $type)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);		
					
		$result = $row->findParentRow('Model_Step2' . $type . $count);		
		
		// return resulted row
		return $result;												
	} 
	
	/**
	 * [isCompleteStep2Form check step2 form state]
	 * @param  [type]  $id    [description]
	 * @param  [type]  $count [description]
	 * @param  [type]  $type  [description]
	 * @return boolean        [description]
	 */
	public function isCompleteStep2Form($id, $count, $type)
	{		
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);			
					
		$result = $row->findParentRow('Model_Step2' . $type . $count);				
			
		if($result->completed)
			$class = 'complete';
		elseif($result->modified)
			$class = 'incomplete';
		else	
			$class = 'sinempezar';

		// return variable $class
		return $class;
	} 
	
	/**
	 * [isCompleteStep2 set step2 state]
	 * @param  [type]  $id   [description]
	 * @param  [type]  $flag [description]
	 * @return boolean       [description]
	 */
	public function isCompleteStep2($id, $flag)
	{		
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);			

		if($flag) {
			$row->completed = 1;
			$row->save();
		} else {			
			$row->completed = 0;
			$row->save();
		}
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
				if($key == 'Field' && substr($value, 4, 2) == $formPrefix)
					$count++;
			}	
		}		
		return $count;	  	
	}	
}