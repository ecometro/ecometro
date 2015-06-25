<?php
/**
* Class Model for steps_1 table
*/
class Model_Step1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'steps_1';
	protected $_primary = 'id';	

	protected $_dependentTables = array('Model_Project');
	
	protected $_referenceMap = array(
		'Step1Form1' => array(
			'columns' => array('s_1_form_1_id'),
			'refTableClass' => 'Model_Step1Form1'
		)
	);

	/**
	 * [createStep1 create a new row in the steps_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep1($id)
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
	 * [updateStep1 update steps_1's row]
	 * @param  [type] $id           [description]
	 * @param  [type] $idStep1Form1 [description]
	 * @return [type]               [description]
	 */
	public function updateStep1($id, $idStep1Form1)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {			
				// set the row data
				$row->s_1_form_1_id = $idStep1Form1;			
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
	 * [findStep1byProjectId find steps_1 by project id]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findStep1byProjectId($id)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);
							
		$result = $row->findParentRow('Model_Step1Form1');
		
		// return resulted row
		return $result;												
	} 
	
	/**
	 * [isCompleteStep1Form check step1 form state]
	 * @param  [type]  $id    [description]
	 * @param  [type]  $count [description]
	 * @param  [type]  $type  [description]
	 * @return boolean        [description]
	 */
	public function isCompleteStep1Form($id, $count, $type)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('project_id = ?', $id);
		
		$row = $this->fetchRow($query);
										
		$result = $row->findParentRow('Model_Step1' . $type . $count);				
			
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
	 * [isCompleteStep1 set step1 state]
	 * @param  [type]  $id   [description]
	 * @param  [type]  $flag [description]
	 * @return boolean       [description]
	 */
	public function isCompleteStep1($id, $flag)
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
}