<?php
/**
* Class Model for calculus table
*/
class Model_Calculus extends Zend_Db_Table_Abstract
{	
	protected $_name = 'calculus';	
	protected $_primary = 'id';				
	
	/**
	 * [getFactAndMax description]
	 * @param  [type] $id              [description]
	 * @param  [type] $nrColumnsTotal [description]
	 * @return [type]                  [description]
	 */
	public function getFactAndMax($id, $nrColumnsTotal)
	{
		$weightingFactor = array();
		$maximumPoints = array();
		$vectorPoints = array();
		$vector = array();
		
		for ($count = 1; $count <= $nrColumnsTotal; $count++) {
			
			$idField = $id . '_' . $count;						
			 
			$query = $this->select();
			$query->where('id_field = ?', $idField);
			$result = $this->fetchRow($query); 
			
			array_push($weightingFactor, $result['factor_de_ponderacion']);
			array_push($maximumPoints, $result['maximo_posible']);

			$isNull = 0;

			for($j = 1; $j <= 5; $j++) {
				$vector['v'. $j] = $result['v' . $j]; 
				if($vector['v'. $j] == null)
					$isNull++;
			}			

			if($isNull == 5)
				array_push($vectorPoints, 'No se valora');
			else
				array_push($vectorPoints, $vector);
		}		
		
		return array('weightingFactor' => $weightingFactor, 'maximumPoints' => $maximumPoints, 'vectorPoints' => $vectorPoints); 		
	}

	/**
	 * [getWeightingFactor description]
	 * @param  [type] $idCalculus [description]
	 * @return [type]             [description]
	 */
	public function getWeightingFactor($idCalculus)
	{ 
		$query = $this->select();
		$query->where('id_field = ?', $idCalculus);
		$result = $this->fetchRow($query)->toArray(); 

		return $result['factor_de_ponderacion'];
	}

	/**
	 * [getVectorValue description]
	 * @param  [type] $idCalculus [description]
	 * @param  [type] $idVector   [description]
	 * @return [type]             [description]
	 */
	public function getVectorValue($idCalculus, $idVector)
	{
		$query = $this->select();
		$query->where('id_field = ?', $idCalculus);
		$result = $this->fetchRow($query)->toArray(); 

		return $result['v' . $idVector];
	}
}