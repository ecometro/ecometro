<?php
/**
* Class Model for mps_5_6 table
*/
class Model_Step2Mp5Field6 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'mps_5_6';	
	protected $_primary = 'id';		
	protected $_dependentTables = array('Model_Step2Mp5');
		
	/**
	 * [createStep2Mp5Field6 create a new row in the mps_5_6 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep2Mp5Field6($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();
		// set the row data
		$row->s_2_mp_5_id = $id;		
		// now fetch the id of the row you just created and return it
		$id = $row->save();
		
		// return the id of the inserted row
		return $id;			
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
