<?php
	abstract class Step3Abstract {

		/**
		 * [getNumberOfColumns description]
		 * @return [type] [description]
		 */
		public function  getNumberOfColumns($tbName)
		{
			$db = Zend_Db_Table_Abstract::getDefaultAdapter();
			$dbName = $db->fetchOne('select DATABASE();');
			$sql = 'SHOW COLUMNS FROM ' .  $dbName . '.' . $tbName . ';';
			$columns = $db->query($sql)->fetchAll(); 
			$count = 0;
			foreach($columns as $column) {
				foreach($column as $key => $value)				
					if($key == 'Field' && strpos($value, 're') !== false)
						$count++;
			}		
			return $count;	 	
		}	

		/**
		 * [getTableName description]
		 * @return [type] [description]
		 */
		public function getTableName($tbName)
		{
		 	$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		 	$sql = "SHOW TABLE STATUS LIKE '" . $tbName . "';";
		 	$result = $db->query($sql)->fetchObject();

		 	return ($result->Comment);	 	
		}
		
		/**
		 * [getFieldType description]
		 * @return [type] [description]
		 */
		public function getFieldType($tbName)
		{
			$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		 	$sql = "SHOW FIELDS FROM " . $tbName . " WHERE Field='" . 'usuario_dato_1' . "';";
		 	$result = $db->query($sql)->fetchObject();

		 	return ($result->Type);
		}	

		/**
		 * [getFieldComment description]
		 * @return [type] [description]
		 */
		public function getFieldComment($tbName)
		{
			$db = Zend_Db_Table_Abstract::getDefaultAdapter();		
			$dbName = $db->fetchOne("select DATABASE();");
		 	$sql = "SELECT column_comment FROM information_schema.columns WHERE table_schema = '" . $dbName . "' and  table_name = '" . $tbName . "' and column_name = '" . 'usuario_dato_1' . "';";
		 	$result = $db->query($sql)->fetchObject();
		 	 
		 	return ($result->column_comment);
		}
	}
?> 