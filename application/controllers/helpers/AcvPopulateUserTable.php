<?php 

/**
 * Class Controller Helper for populate user table with info from csv uploaded file
 * =hce_project_populate_table() from H2C 
 */
class Zend_Controller_Action_Helper_AcvPopulateUserTable extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvPopulateUserTable($db, $filename, $projectId) 
    {

    	$table = 's_4' . '_project_' . $projectId;
		// empty project table
		$db->query( "TRUNCATE TABLE `$table`" ); 

		$line_length = '4096'; // max line lengh (increase in case you have longer lines than 1024 characters)
		// open the data file
		if(!($fp = fopen($filename, 'r'))) {
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('File open failed.'));
		} else {	
			if ( $fp !== FALSE ) { // if the file exists and is readable	
				$table = 's_4' . '_project_' . $projectId; 		
				$line = 0;
				while (($fp_csv = fgetcsv($fp,$line_length, ',', '"')) !== FALSE ) { // begin main loop
					$material_code = utf8_encode($fp_csv[0]);
					if ( preg_match('/^[M,P,O][0-9][0-9]/', $material_code) == 1 ) {
						// preparing data to insert
						$material_amount = str_replace(',', '.', $fp_csv[3]);
						$material_amount = round($material_amount, 3);
						$construction_unit_amount = str_replace(',', '.', $fp_csv[7]);
						$construction_unit_amount = round($construction_unit_amount, 3);
						$data = array(
									//'id' => is autoincrement
									'material_code' => $material_code,
									'material_name' => utf8_encode($fp_csv[2]),
									'material_amount' => utf8_encode($material_amount),
									'material_unit' => utf8_encode($fp_csv[1]),
									'construction_unit_code' => utf8_encode($fp_csv[4]),
									'construction_unit_name' => utf8_encode($fp_csv[6]),
									'construction_unit_amount' => utf8_encode($construction_unit_amount),
									'construction_unit_unit' => utf8_encode($fp_csv[5]),
									'section_code' => utf8_encode($fp_csv[10]),
									'section_name' => utf8_encode($fp_csv[11]),
									'subsection_code' => utf8_encode($fp_csv[8]),
									'subsection_name' => utf8_encode($fp_csv[9])
								);
						/* create row */ $db->insert( $table, $data );					
					} // end if not valid line
					$line++;
				} // end main loop
				fclose($fp);
			}
		}
	}

	public function direct($db, $filename, $projectId)
    {
        return $this->getAcvPopulateUserTable($db, $filename, $projectId);
    }
}