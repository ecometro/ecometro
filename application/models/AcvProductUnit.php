<?php
/**
* Class Model for acv_product_unit table
*/
class Model_AcvProductUnit extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_product_unit';
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_AcvProducts');

	/**
	 * [listUnits description]
	 * @return [type] [description]
	 */
	public function listUnits()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}
	
	/**
	 * [findUnitMeasureById description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findUnitMeasureById($id){
		
		$result = $this->find($id)->current()->toArray();
		
		if($result)
			return $result;
		else
			throw new Zend_Exception('No se han encontrado la unidad de medición.');
	}	
}