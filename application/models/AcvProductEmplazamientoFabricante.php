<?php
/**
* Class Model for acv_product_emplazamiento_fabricante table
*/
class Model_AcvProductEmplazamientoFabricante extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_product_emplazamiento_fabricante';
	protected $_primary = 'id';

	/**
	 * [listEmplazamientoFabricante description]
	 * @return [type] [description]
	 */
	public function listEmplazamientoFabricante()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}
	
	/**
	 * [findDetailsEmplazamientoFabricante description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findDetailsEmplazamientoFabricante($id)
	{
		$result = $this->find($id)->current()->toArray();
		
		return $result;
	}	
}