<?php
/**
* Class Model for ges_1_1 table
*/
class Model_Step3Ge1Field1 extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'ges_1_1';	
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Step3Ge1');
	
	/**
	 * [createStep3Ge1Field1 create a new row in the ges_1_1 table]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createStep3Ge1Field1($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data
				$row->s_3_ge_1_id = $id;		
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