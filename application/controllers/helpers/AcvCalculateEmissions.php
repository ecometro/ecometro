<?php 

/**
 * Class Controller Helper for calculating emissions
 * =hce_project_calculate_emissions() from H2C
 */
class Zend_Controller_Action_Helper_AcvCalculateEmissions extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvCalculateEmissions($db, $projectId) 
    {
    	try {
			$cfield_prefix = '_hce_project_';
			$building_total_emission = array();
			$building_total_emission['value'] = 0;
			$table_p = 's_4' . '_project_' . $projectId;
			$table_m = 's_4' . '_materials';
			$table_e = 's_4' . '_emissions';
			$emission_type = 'intrinsic';
			if ( $emission_type == 'intrinsic' ) {
				$col_to_update = 'emission';
				$building_total_emission['key'] = 'emission_total';
				$sql_query = "
				SELECT
				  p.id,
				  p.material_amount,
				  m.material_mass,
				  m.component_1,
				  m.component_1_mass,
				  m.dap_factor,
				  e.emission_factor
				FROM $table_p p
				LEFT JOIN $table_m m
				  ON p.material_code = m.material_code
				LEFT JOIN $table_e e
				  ON m.component_1 = e.subtype
				WHERE p.material_amount != 0
				  AND m.component_1_mass != 0
			UNION ALL
				SELECT
				  p.id,
				  p.material_amount,
				  m.material_mass,
				  m.component_2,
				  m.component_2_mass,
				  m.dap_factor,
				  e.emission_factor
				FROM $table_p p
				LEFT JOIN $table_m m
				  ON p.material_code = m.material_code
				LEFT JOIN $table_e e
				  ON m.component_2 = e.subtype
				WHERE p.material_amount != 0
				  AND m.component_2_mass != 0
			UNION ALL
				SELECT
				  p.id,
				  p.material_amount,
				  m.material_mass,
				  m.component_3,
				  m.component_3_mass,
				  m.dap_factor,
				  e.emission_factor
				FROM $table_p p
				LEFT JOIN $table_m m
				  ON p.material_code = m.material_code
				LEFT JOIN $table_e e
				  ON m.component_3 = e.subtype
				WHERE p.material_amount != 0
				  AND m.component_3_mass != 0
			";

			}				
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$query_results = $db->fetchAssoc($sql_query);
			
			$count = 0;
			$emissions = array();
			$weight = array();
			$building_total_weight = 0;
			foreach ( $query_results as $material ) {
				$count++;
				$material_id = $material['id'];

				if ( $emission_type == 'intrinsic' ) { // if intrinsic emissions
					// emission maths
					if ( !array_key_exists($material_id, $emissions) ) {
						$emissions[$material_id][] = $material['material_amount'] * $material['material_mass'] * $material['dap_factor'];
					}
					$this_weight = $material['material_amount'] * $material['component_1_mass'];
					$emissions[$material_id][] = $this_weight * $material['emission_factor'];

					// total weight of building
					$building_total_weight += $this_weight;

					// weight of subtypes array
					if ( !array_key_exists($material['component_1'], $weight) ) {
						$weight[$material['component_1']] = $material['material_amount'] * $material['component_1_mass'];
					} else {
						$weight[$material['component_1']] += $material['material_amount'] * $material['component_1_mass'];
					}
					
				}
			}
			
			if ( $emission_type == 'intrinsic' ) {
				// sort subtypes: heaviest to lightest
				arsort($weight);
				// select top ten
				$weight_topten = array_slice($weight, 0, 10, true);
				
				if($weight_topten)
					Zend_Controller_Action_HelperBroker::getStaticHelper('AcvCreateMassTopTen')->direct($db, $weight_topten, $projectId);
										
				// save total weight of building
				//update_post_meta($project_id, $cfield_prefix.'mass_total', $building_total_weight);
			}

			$update_cases = array();
			$update_where = array();
			$update_ids = array();
			foreach ( $emissions as $id => $emission ) {
				if ( $emission[0] == 0 ) { // if there is no DAP, then take three subtypes
					if ( !array_key_exists(2,$emission) ) { $emission[2] = 0; }
					if ( !array_key_exists(3,$emission) ) { $emission[3] = 0; }
					$material_emission = ( $emission[1] + $emission[2] + $emission[3] );

				} else { /* if there is DAP, then ignore three subtypes */ $material_emission = $emission[0]; }

				if ( $material_emission != 0 ) {
					array_push($update_cases, "WHEN " . $id . " THEN '" . $material_emission . "'");
					array_push($update_where, '%s');
					array_push($update_ids, $id);

					// total emission of building
					$building_total_emission['value'] += $material_emission;
				}
			}
			$update_cases = implode(" ", $update_cases);
			$update_where = implode(", ", $update_where);
			$update_ids = implode(", ", $update_ids);
			$query_update = "
				UPDATE $table_p
				SET $col_to_update = CASE id
				  $update_cases
				  END
				WHERE id IN ($update_ids)
			";
			
			$db->query( $query_update );

			// save total emissions of building: intrinsic or transport
			//update_post_meta($project_id, $cfield_prefix.$building_total_emission['key'], $building_total_emission['value']);			
		} catch(Exception $e) {
			throw new Exception(Zend_Registry::get('Zend_Translate')->translate('Database problems in calculating emissions.'));
		}
	}

	public function direct($db, $projectId)
    {
        return $this->getAcvCalculateEmissions($db, $projectId);
    }
}