<?php
/**
* Class Model for steps_5 table
*/
class Model_Step5 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'steps_5';
	protected $_primary = 'id';			

	protected $_dependentTables = array('Model_Project');
	
	/**
	 * [createStep5 create a new row in the steps_5 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep5($id)
	{		
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
	 * [updateStep5 update steps_5's row]
	 * @param  [type] $id      [description]
	 * @param  [type] $smallPhoto [description]
	 * @param  [type] $largePhoto [description]
	 * @return [type]          [description]
	 */
	public function updateStep5($id, $smallPhoto, $largePhoto)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {				
				// set the row data					
				$row->s_photo = $smallPhoto;
				// set the row data					
				$row->l_photo = $largePhoto;					
				// save the updated row
				$row->save();				
				
				return true;

			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar el paso.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar el paso.'));
		}								
	}

	/**
	 * [findStep5byProjectId find steps_5 by project id]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findStep5byProjectId($id)
	{		 
		$query = $this->select();		
		$query->where('project_id = ?', $id);	

		$row = $this->fetchRow($query);
										
		return $row;		
	}		
}