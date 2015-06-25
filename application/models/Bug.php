<?php
/**
* Class Model for bugs table
*/
class Model_Bug extends Zend_Db_Table_Abstract
{
	protected $_name = 'bugs';
		
	/**
	 * [createBug description]
	 * @param  [type] $name        [description]
	 * @param  [type] $email       [description]
	 * @param  [type] $date        [description]
	 * @param  [type] $subject     [description]
	 * @param  [type] $message [description]
	 * @param  [type] $priority    [description]
	 * @param  [type] $status      [description]
	 * @return [type]              [description]
	 */
	public function createBug($name, $email, $date, $subject, $message)
	{
		// create a new row in the bugs table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->name = $name;
				$row->email = $email;
				$dateObject = new Zend_Date($date);
				$row->date = $dateObject->get(Zend_Date::TIMESTAMP);
				$row->subject = $subject;
				$row->message = $message;			
				// now fetch the id of the row you just created and return it
				$id = $row->save();
					
				// return the id of the inserted row
				return $id;
			} catch(Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la entrada.'));		
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear la entrada.'));	
		}			
	}
		
	/**
	 * [fetchPaginatorAdapter description]
	 * @param  array  $filters   [description]
	 * @param  [type] $sortField [description]
	 * @return [type]            [description]
	 */
	public function fetchPaginatorAdapter ($filters = array(), $sortField = null)
	{
		$select = $this->select();
		// add any filters which are set
		if(count($filters) > 0) {
			foreach ($filters as $field => $filter) {
				$select->where($field . ' = ?', $filter);
			}
		}
		// add the sort field is it is set
		if(null != $sortField) {
			$select->order($sortField);
		}
						
		// create a new instance of the paginator adapter and return it
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		
		// return variable $adapter
		return $adapter;			
	}
		
	/**
	 * [updateBug description]
	 * @param  [type] $id          [description]
	 * @param  [type] $name        [description]
	 * @param  [type] $email       [description]
	 * @param  [type] $date        [description]
	 * @param  [type] $subject         [description]
	 * @param  [type] $message [description]
	 * @param  [type] $priority    [description]
	 * @param  [type] $status      [description]
	 * @return [type]              [description]
	 */
	public function updateBug($id, $name, $email, $date, $subject, $message)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		
		if($row) {
			try {
				// set the row data
				$row->name = $name;
				$row->email = $email;
				$d = new Zend_Date($date);
				$row->date = $d->get(Zend_Date::TIMESTAMP);
				$row->subject = $subject;
				$row->message = $message;	
				// save the updated row
				$row->save();
					
				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la entrada.'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la entrada. No se ha encontrado.'));	
		}
	}
		
	/**
	 * [deleteBug description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteBug($id)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		
		if($row) {		
			return $row->delete();			
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido borrar la entrada. No se ha encontrado.'));		
		}
	}		
}