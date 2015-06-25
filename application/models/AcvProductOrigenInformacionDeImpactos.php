<?php
/**
* Class Model for acv_product_origen_informacion_de_impactos table
*/
class Model_AcvProductOrigenInformacionDeImpactos extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_product_origen_informacion_de_impactos';
	protected $_primary = 'id';

	/**
	 * [listOrigenInformacionDeImpactos description]
	 * @return [type] [description]
	 */
	public function listOrigenInformacionDeImpactos()
	{
		$query = $this->select();
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}	
}