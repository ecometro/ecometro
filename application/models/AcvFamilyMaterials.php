<?php
/**
* Class Model for acv_family_materials table
*/
class Model_AcvFamilyMaterials extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_family_materials';	
	protected $_primary = 'id';
		
	/**
	 * [listFamilyMaterials description]
	 * @return [type] [description]
	 */
	public function listFamilyMaterials()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}	
}