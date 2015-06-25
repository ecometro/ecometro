<?php
/**
* Class Model for steps_3 table
*/
class Model_Step3 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'steps_3';
	protected $_primary = 'id';	
	
	protected $_dependentTables = array('Model_Project');
	
	protected $_referenceMap = array(
		'Step3Re1' => array(
			'columns' => array('s_3_re_1_id'),
			'refTableClass' => 'Model_Step3Re1'
	 	),
	 	'Step3Re2' => array(
			'columns' => array('s_3_re_2_id'),
			'refTableClass' => 'Model_Step3Re2'
	 	),
	 	'Step3Re3' => array(
			'columns' => array('s_3_re_3_id'),
			'refTableClass' => 'Model_Step3Re3'
	 	),
	 	'Step3Re4' => array(
			'columns' => array('s_3_re_4_id'),
			'refTableClass' => 'Model_Step3Re4'
	 	),
	 	'Step3Re5' => array(
			'columns' => array('s_3_re_5_id'),
			'refTableClass' => 'Model_Step3Re5'
	 	),
	 	'Step3Re6' => array(
			'columns' => array('s_3_re_6_id'),
			'refTableClass' => 'Model_Step3Re6'
	 	),
	 	'Step3Re7' => array(
			'columns' => array('s_3_re_7_id'),
			'refTableClass' => 'Model_Step3Re7'
	 	),
	 	'Step3Re8' => array(
			'columns' => array('s_3_re_8_id'),
			'refTableClass' => 'Model_Step3Re8'
	 	),
	 	'Step3Re9' => array(
			'columns' => array('s_3_re_9_id'),
			'refTableClass' => 'Model_Step3Re9'
	 	),
	 	'Step3Re10' => array(
			'columns' => array('s_3_re_10_id'),
			'refTableClass' => 'Model_Step3Re10'
	 	),
	 	'Step3Re11' => array(
			'columns' => array('s_3_re_11_id'),
			'refTableClass' => 'Model_Step3Re11'
	 	),
	 	'Step3Bc1' => array(
			'columns' => array('s_3_bc_1_id'),
			'refTableClass' => 'Model_Step3Bc1'
	 	),
	 	'Step3Bc2' => array(
			'columns' => array('s_3_bc_2_id'),
			'refTableClass' => 'Model_Step3Bc2'
	 	),
	 	'Step3Bc3' => array(
			'columns' => array('s_3_bc_3_id'),
			'refTableClass' => 'Model_Step3Bc3'
	 	),
	 	'Step3Bc4' => array(
			'columns' => array('s_3_bc_4_id'),
			'refTableClass' => 'Model_Step3Bc4'
	 	),
	 	'Step3Bc5' => array(
			'columns' => array('s_3_bc_5_id'),
			'refTableClass' => 'Model_Step3Bc5'
	 	),
	 	'Step3Bc6' => array(
			'columns' => array('s_3_bc_6_id'),
			'refTableClass' => 'Model_Step3Bc6'
	 	),
	 	'Step3Bc7' => array(
			'columns' => array('s_3_bc_7_id'),
			'refTableClass' => 'Model_Step3Bc7'
	 	),
	 	'Step3Bc8' => array(
			'columns' => array('s_3_bc_8_id'),
			'refTableClass' => 'Model_Step3Bc8'
	 	),
	 	'Step3Bc9' => array(
			'columns' => array('s_3_bc_9_id'),
			'refTableClass' => 'Model_Step3Bc9'
	 	),
	 	'Step3Bc10' => array(
			'columns' => array('s_3_bc_10_id'),
			'refTableClass' => 'Model_Step3Bc10'
	 	),
	 	'Step3Ga1' => array(
			'columns' => array('s_3_ga_1_id'),
			'refTableClass' => 'Model_Step3Ga1'
	 	),
	 	'Step3Ga2' => array(
			'columns' => array('s_3_ga_2_id'),
			'refTableClass' => 'Model_Step3Ga2'
	 	),
	 	'Step3Ga3' => array(
			'columns' => array('s_3_ga_3_id'),
			'refTableClass' => 'Model_Step3Ga3'
	 	),
	 	'Step3Ga4' => array(
			'columns' => array('s_3_ga_4_id'),
			'refTableClass' => 'Model_Step3Ga4'
	 	),
	 	'Step3Bl1' => array(
			'columns' => array('s_3_bl_1_id'),
			'refTableClass' => 'Model_Step3Bl1'
	 	),
	 	'Step3Bl2' => array(
			'columns' => array('s_3_bl_2_id'),
			'refTableClass' => 'Model_Step3Bl2'
	 	),
	 	'Step3Bl3' => array(
			'columns' => array('s_3_bl_3_id'),
			'refTableClass' => 'Model_Step3Bl3'
	 	),
	 	'Step3Bl4' => array(
			'columns' => array('s_3_bl_4_id'),
			'refTableClass' => 'Model_Step3Bl4'
	 	),
	 	'Step3Bl5' => array(
			'columns' => array('s_3_bl_5_id'),
			'refTableClass' => 'Model_Step3Bl5'
	 	),
	 	'Step3Ge1' => array(
			'columns' => array('s_3_ge_1_id'),
			'refTableClass' => 'Model_Step3Ge1'
	 	),
	 	'Step3Ge2' => array(
			'columns' => array('s_3_ge_2_id'),
			'refTableClass' => 'Model_Step3Ge2'
	 	),
	 	'Step3Ge3' => array(
			'columns' => array('s_3_ge_3_id'),
			'refTableClass' => 'Model_Step3Ge3'
	 	),
	 	'Step3Ge4' => array(
			'columns' => array('s_3_ge_4_id'),
			'refTableClass' => 'Model_Step3Ge4'
	 	)
	);

	/**
	 * [createStep3 create a new row in the steps_3 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3($id)
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
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la ficha.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la ficha.'));
		}			
	}

	/**
	 * [updateStep3 update steps_3's row]
	 * @param  [type] $id      [description]
	 * @param  [type] $idStep3 [description]
	 * @param  [type] $count   [description]
	 * @param  [type] $type    [description]
	 * @return [type]          [description]
	 */
	public function updateStep3($id, $idStep3, $count, $type)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {
				// set the row data					
				$row->{'s_3_'. $type .'_' . $count . '_id'} = $idStep3;			
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
	 * [findStep3byProjectId find steps_3 by project id]
	 * @param  [type] $id    [description]
	 * @param  [type] $count [description]
	 * @param  [type] $type  [description]
	 * @return [type]        [description]
	 */
	public function findStep3byProjectId($id, $count, $type)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);							
		$result = $row->findParentRow('Model_Step3' . $type . $count);
		
		// return resulted row
		return $result;														 
	} 
	
	/**
	 * [isCompleteStep3Form check step3 form state]
	 * @param  [type]  $id    [description]
	 * @param  [type]  $count [description]
	 * @param  [type]  $type  [description]
	 * @return boolean        [description]
	 */
	public function isCompleteStep3Form($id, $count, $type)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);										
		$result = $row->findParentRow('Model_Step3'. $type . $count);				
			
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
	 * [isCompleteStep3 set step3 state]
	 * @param  [type]  $id   [description]
	 * @param  [type]  $flag [description]
	 * @return boolean       [description]
	 */
	public function isCompleteStep3($id, $flag)
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
	public function getNumberOfColumns($formPrefix)
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