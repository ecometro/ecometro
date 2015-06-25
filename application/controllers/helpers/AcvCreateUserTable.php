<?php 

/**
 * Class Controller Helper for creating user table in order to hold info from the uploaded file
 * =hce_project_create_table() from H2C
 */
class Zend_Controller_Action_Helper_AcvCreateUserTable extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvCreateUserTable($db, $projectId) 
    {
		$table = 's_4' . '_project_' . $projectId; 
		$tableExists = true;

		try {
			$result = $db->describeTable($table); //throws exception
			if (empty($result)) $tableExists = 0;			
		} catch ( Exception $e ) {
			$tableExists = 0;
	    }

	    try {
			if (!$tableExists) {	    
				$sql = "
					CREATE TABLE $table (
						id bigint(20) unsigned NOT NULL auto_increment,
						material_code varchar(12) NOT NULL default '',
						material_name varchar(100) NOT NULL default '',
						material_amount float(10,3) NOT NULL default 0,
						material_unit varchar(10) NOT NULL default '',
						construction_unit_code varchar(12) NOT NULL default '',
						construction_unit_name varchar(100) NOT NULL default '',
						construction_unit_amount float(10,3) NOT NULL default 0,
						construction_unit_unit varchar(10) NOT NULL default '',
						section_code varchar(12) NOT NULL default '',
						section_name varchar(100) NOT NULL default '',
						subsection_code varchar(12) NOT NULL default '',
						subsection_name varchar(100) NOT NULL default '',
						emission float(10,5) NOT NULL default 0,
						emission_transport float(10,5) NOT NULL default 0,
						PRIMARY KEY  (id)
					);
					";						
				$db->query($sql);
			} else {
				$db->query( "TRUNCATE TABLE `$table`" );
			}
		} catch(Exception $e) {
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('Cannot create/empty table.'));
		}
	}

	public function direct($db, $projectId)
    {
        return $this->getAcvCreateUserTable($db, $projectId);
    }	
}				