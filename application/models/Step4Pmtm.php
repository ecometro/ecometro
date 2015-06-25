<?php
/**
* Class Model for s_4_pmtm table
*/
class Model_Step4Pmtm extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_4_pmtm';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step4');	
	protected $_referenceMap = array();

	/**
	 * [createStep4Pmtm create a new row in the s_4_pmtm table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep4Pmtm($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->step_4_id = $id;				
				// now fetch the id of the row you just created and return it
				$id = $row->save();
						
				// return the id of the inserted row
				return $id;	
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la entrada.'));
			}		
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear la entrada.'));
		}
	}	
}