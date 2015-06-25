<?php
/**
* Class Model for mps_10_5 table
*/
class Model_Step2Mp10Field5 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'mps_10_5';	
	protected $_primary = 'id';		
	protected $_dependentTables = array('Model_Step2Mp10');

	/**
	 * [createStep2Mp10Field5 create a new row in the mps_10_5 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp10Field5($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->s_2_mp_10_id = $id;		
				// now fetch the id of the row you just created and return it
				$id = $row->save();
				
				// return the id of the inserted row
				return $id;	
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el campo.'));	
			}	
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el campo.'));
		}	
	}

	/**
	 * [getTableName description]
	 * @return [type] [description]
	 */
	public function getTableName()
	{
	 	$db = Zend_Db_Table_Abstract::getDefaultAdapter();
	 	$sql = "SHOW TABLE STATUS LIKE '" . $this->_name . "';";
	 	$result = $db->query($sql)->fetchObject(); 

	 	return ($result->Comment);	 	
	} 
	
	/**
	 * [getFieldType description]
	 * @return [type] [description]
	 */
	public function getFieldType()
	{
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
	 	$sql = "SHOW FIELDS FROM " . $this->_name . " WHERE Field='" . 'usuario_dato_1' . "';";
	 	$result = $db->query($sql)->fetchObject(); 

	 	return ($result->Type);
	}	

	/**
	 * [getFieldComment description]
	 * @return [type] [description]
	 */
	public function getFieldComment()
	{
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();		
		$dbName = $db->fetchOne("select DATABASE();");
	 	$sql = "SELECT column_comment FROM information_schema.columns WHERE table_schema = '" . $dbName . "' and  table_name = '" . $this->_name . "' and column_name = '" . 'usuario_dato_1' . "';";
	 	$result = $db->query($sql)->fetchObject(); 

	 	return ($result->column_comment);
	}
}
