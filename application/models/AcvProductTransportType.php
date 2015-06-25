<?php
/**
* Class Model for acv_product_transport_type table
*/
class Model_AcvProductTransportType extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_product_transport_type';
	protected $_primary = 'id';

	/**
	 * [listTransportType description]
	 * @return [type] [description]
	 */
	public function listTransportType()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}
	
	/**
	 * [findDetailsTransportType description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findDetailsTransportType($id)
	{
		$result = $this->find($id)->current()->toArray();
		
		if($result)
			return $result;	
		else 
			throw new Zend_Exception('No se han encontrado los detalles del transporte.');
	}	
}