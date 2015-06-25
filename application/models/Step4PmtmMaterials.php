<?php
/**
* Class Model for s_4_pmtm_materials table
*/
class Model_Step4PmtmMaterials extends Zend_Db_Table_Abstract
{
	
	protected $_name = 's_4_pmtm_materials';	
	protected $_primary = 'id';	
	protected $_dependentTables = array('Model_Step4Pmtm');	
	protected $_referenceMap = array();
	
	/**
	 * [createStep4PmtmMaterials create a new row in the s_4_pmtm_materials table]
	 * @param  [type] $id                 [description]
	 * @param  [type] $family_material_id [description]
	 * @param  [type] $family_product_id  [description]
	 * @param  [type] $product_id         [description]
	 * @return [type]                     [description]
	 */
	public function createStep4PmtmMaterials($id, $family_material_id = null, $family_product_id = null, $product_id = null)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set the row data					
				$row->family_material_id = $family_material_id;
				$row->family_product_id = $family_product_id;
				$row->product_id = $product_id;
				// set the row data
				$row->s_4_pmtm_id = $id;				
				// now fetch the id of the row you just created and return it
				$id = $row->save();

				// return the id of the inserted row
				return $id;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar la entrada.'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear la entrada.'));
		}
	}

	/**
	 * [updateStep4PmtmMaterials update table s_4_pmtm_materials's row by id]
	 * @param  [type] $id                 [description]
	 * @param  [type] $familyMaterialId [description]
	 * @param  [type] $familyProductId  [description]
	 * @param  [type] $productId         [description]
	 * @param  [type] $cantidad           [description]
	 * @return [type]                     [description]
	 */
	public function updateStep4PmtmMaterials($id, $familyMaterialId = null, $familyProductId = null, $productId = null, $cantidad = null)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {		
				// set the row data					
				$row->family_material_id = $familyMaterialId;
				$row->family_product_id = $familyProductId;
				$row->product_id = $productId;
				$row->cantidad = $cantidad;						
				// save the updated row
				$row->save();			

				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido actualizar la entrada.'));	
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar la entrada.'));
		}					
	}

	/**
	 * [deleteStep4PmtmMaterials delete table s_4_pmtm_materials's row by id]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteStep4PmtmMaterials($id)
	{
		$row = $this->find($id)->current();

		if($row)
			return $row->delete();
		else
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido borrar la entrada.'));			
	}

	/**
	 * [findPmtmMaterialsbyPmtmId find all rows by id]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findPmtmMaterialsbyPmtmId($id)
	{
		// find the row that matches the id
		$query = $this->select();
		$query->where('s_4_pmtm_id = ?', $id);

		$result = $this->fetchAll($query);
			
		return $result;														 
	}	
}