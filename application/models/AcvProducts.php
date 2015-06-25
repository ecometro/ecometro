<?php
/**
* Class Model for acv_products table
*/
class Model_AcvProducts extends Zend_Db_Table_Abstract
{	
	protected $_name = 'acv_products';
	protected $_primary = 'id';	
	protected $_referenceMap = array(
		'AcvProductUnit' => array(
			'columns' => array('id_product_unit'),
			'refTableClass' => 'Model_AcvProductUnit'
		)
	);
	
	/**
	 * [createProduct description]
	 * @param  [type] $producto                                         [description]
	 * @param  [type] $fabricante                                       [description]
	 * @param  [type] $origen_del_producto                              [description]
	 * @param  [type] $familia_de_productos_materiales                  [description]
	 * @param  [type] $familia_de_productos                             [description]
	 * @param  [type] $informacion_adicional                            [description]
	 * @param  [type] $cantidad                                         [description]
	 * @param  [type] $unidad                                           [description]
	 * @param  [type] $densidad                                         [description]
	 * @param  [type] $espesor                                          [description]
	 * @param  [type] $vida_util                                        [description]
	 * @param  [type] $emplazamiento_fabricante                         [description]
	 * @param  [type] $distancia_distribuidor                           [description]
	 * @param  [type] $tipo_de_transporte                               [description]
	 * @param  [type] $potencial_de_acidificacion                       [description]
	 * @param  [type] $potencial_de_eutrofizacion                       [description]
	 * @param  [type] $potencial_de_calentamiento_global                [description]
	 * @param  [type] $potencial_de_agotamiento_de_capa_de_ozono        [description]
	 * @param  [type] $potencial_de_formacion_de_oxidantes_fotoquimicos [description]
	 * @param  [type] $agotamiento_de_recursos_abioticos                [description]
	 * @param  [type] $consumo_de_energia_primaria_total                [description]
	 * @param  [type] $origen_informacion_de_impactos                   [description]
	 * @param  [type] $comentarios                                      [description]
	 * @return [type]                                                   [description]
	 */
	public function createProduct($producto, $fabricante, $origen_del_producto, $familia_de_productos_materiales, $familia_de_productos, $informacion_adicional, $cantidad, $unidad, $densidad, $espesor, $vida_util, $emplazamiento_fabricante, $distancia_distribuidor, $tipo_de_transporte, $potencial_de_acidificacion, $potencial_de_eutrofizacion, $potencial_de_calentamiento_global, $potencial_de_agotamiento_de_capa_de_ozono, $potencial_de_formacion_de_oxidantes_fotoquimicos, $agotamiento_de_recursos_abioticos, $consumo_de_energia_primaria_total, $origen_informacion_de_impactos, $comentarios)
	{
		// create a new row in the projects table
		$row = $this->createRow();
		
		if($row) {
			try {
				// set the row data					
				$row->producto = $producto;
				$row->fabricante = $fabricante;
				$row->id_product_origin = $origen_del_producto;
				$row->id_family_product = $familia_de_productos;
				$row->informacion_adicional = $informacion_adicional;
				$row->cantidad = $cantidad;
				$row->id_product_unit = $unidad;
				$row->densidad = $densidad;
				$row->espesor = $espesor;
				$row->vida_util_producto = $vida_util;
				$row->id_emplazamiento_fabricante = $emplazamiento_fabricante;
				$row->distancia_distribuidor = $distancia_distribuidor;
				$row->id_transport_type = $tipo_de_transporte;
				$row->potencial_de_acidificacion = $potencial_de_acidificacion;
				$row->potencial_de_eutrofizacion = $potencial_de_eutrofizacion;
				$row->potencial_de_calentamiento_global = $potencial_de_calentamiento_global;
				$row->potencial_de_agotamiento_de_capa_de_ozono = $potencial_de_agotamiento_de_capa_de_ozono;
				$row->potencial_de_formacion_de_oxidantes_fotoquimicos = $potencial_de_formacion_de_oxidantes_fotoquimicos;
				$row->agotamiento_de_recursos_abioticos = $agotamiento_de_recursos_abioticos;
				$row->consumo_de_energia_primaria_total = $consumo_de_energia_primaria_total;
				$row->id_origen_informacion_de_impactos = $origen_informacion_de_impactos;
				$row->comentarios = $comentarios;
				
				// now fetch the id of the row you just created and return it
				$id = $row->save();				
				// return the id of the inserted row
				return $id;

			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el producto.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el producto.'));
		}			
	 }
	
	/**
	 * [listProducts description]
	 * @return [type] [description]
	 */
	public function listProducts()
	{
		$query = $this->select();
		$results = $this->fetchAll($query);
		
		return $results;
	}
	
	/**
	 * [findProducts description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findProducts($id)
	{
		$query = $this->select();
		$query->where('id_family_product = ?', $id);
		$results = $this->fetchAll($query)->toArray();
		
		return $results;
	}
	
	/**
	 * [findDetailsProduct description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findDetailsProduct($id)
	{
		// find the row that matches the id
		$query = $this->select()->setIntegrityCheck(false);
		$query->distinct();
		$query->from('acv_products');
		$query->join('acv_product_unit', 'acv_products.id_product_unit = acv_product_unit.id', array('acv_product_unit.product_unit'));				 
		$query->join('acv_product_origin', 'acv_products.id_product_origin = acv_product_origin.id', array('acv_product_origin.product_origin'));
		$query->join('acv_product_emplazamiento_fabricante', 'acv_products.id_emplazamiento_fabricante = acv_product_emplazamiento_fabricante.id', array('acv_product_emplazamiento_fabricante.emplazamiento_fabricante'));
		$query->join('acv_product_transport_type', 'acv_products.id_transport_type = acv_product_transport_type.id', array('acv_product_transport_type.transport_type'));
		$query->where('acv_products.id = ?', $id);
				
		$result = $this->fetchAll($query)->toArray();
		
		return $result;
				
	}
	
	/**
	 * [findNameProductById description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findNameProductById($id){
		
		$result = $this->find($id)->current()->toArray();
		if($result)
			return $result;
		else
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar el nombre del producto.'));
	}	
}