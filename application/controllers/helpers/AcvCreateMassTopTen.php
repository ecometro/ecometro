<?php 

/**
 * Class Controller Helper for creating user table in order to hold info from the uploaded file
 * =hce_project_create_table() from H2C
 */
class Zend_Controller_Action_Helper_AcvCreateMassTopTen extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvCreateMassTopTen($db, array $topten, $projectId) 
    {    	
		$table = 's_4' . '_mass_topten_' . $projectId; 
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
						subtype varchar(100) NOT NULL default '',
						kg varchar(100) NOT NULL default '',
						PRIMARY KEY  (id)
					);
					";						
				$db->query($sql);

			} else {				
				$db->query( "TRUNCATE TABLE `$table`" );				
			}

			foreach ( $topten as $subtype => $kg ) {	
				$data = array(
							'subtype' => utf8_encode($subtype),
							'kg' => utf8_encode($kg)
						);					
				$db->insert( $table, $data );
			}
		} catch(Exception $e) {
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('Cannot create/empty table.'));
		}
	}

	public function direct($db, $topten, $projectId)
    {
        return $this->getAcvCreateMassTopTen($db, $topten, $projectId);
    }	
}				