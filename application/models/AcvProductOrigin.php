<?php
/**
* Class Model for acv_products table
*/
class Model_AcvProductOrigin extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_product_origin';
	protected $_primary = 'id';

	/**
	 * [listProductOrigin description]
	 * @return [type] [description]
	 */
	public function listProductOrigin()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}
	
	/**
	 * [findDetailsProductOrigin description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findDetailsProductOrigin($id)
	{
		$result = $this->find($id)->current()->toArray();
		
		return $result;
	}	
}