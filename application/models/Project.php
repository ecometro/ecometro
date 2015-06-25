<?php
/**
* Class Model for projects table
*/
class Model_Project extends Zend_Db_Table_Abstract
{	
	protected $_name = 'projects';
	protected $_primary = 'id';	
	
	protected $_referenceMap = array(
		'Step1' => array(
			'columns' => array('step_1_id'),
			'refTableClass' => 'Model_Step1'
		),
	 	'Step2' => array(
			'columns' => array('step_2_id'),
			'refTableClass' => 'Model_Step2'
		),
	 	'Step3' => array(
			'columns' => array('step_3_id'),
			'refTableClass' => 'Model_Step3'
		),
	 	'Step5' => array(
			'columns' => array('step_5_id'),
			'refTableClass' => 'Model_Step5'
		)
	);
	
	/**
	 * [createProject description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function createProject($id)
	{
		// create a new row in the projects table
		$row = $this->createRow();

		if($row) {
			try {
				// set creation date		
				$date = new Zend_Date();
				$row->created = $date->toString('YYYY-MM-dd HH:mm:ss');
				// set the row data
				$row->account_id = $id;						
				// now fetch the id of the row you just created and return it
				$id = $row->save();										
					
				// return the id of the inserted row
				return $id;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el proyecto.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido crear el proyecto.'));
		}			
	}
	
	/**
	 * [updateProject description]
	 * @param  [type] $id      [description]
	 * @param  [type] $idStep1 [description]
	 * @param  [type] $idStep2 [description]
	 * @param  [type] $idStep3 [description]
	 * @param  [type] $idStep5 [description]
	 * @return [type]          [description]
	 */
	public function updateProject($id, $idStep1, $idStep2, $idStep3, $idStep5)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) {
			try {			
				// set the row data
				$row->step_1_id = $idStep1;
				$row->step_2_id = $idStep2;
				$row->step_3_id = $idStep3;
				$row->step_5_id = $idStep5;			
				// save the updated row
				$row->save();

				// return boolean true
				return true;
			} catch (Zend_Exception $e) {
				throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido guardar el proyecto.'));
			}
		} else {
			throw new Zend_Exception(Zend_Registry::get('Zend_Translate')->translate('No se ha podido encontrar el proyecto.'));
		}								
	}

	/**
	 * [deleteProject description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function deleteProject($id)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();

		if($row) { 
			$query = $this->select()->setIntegrityCheck(false);
			$query->distinct();
			$query->from('projects');
			$query->join('steps_1', 'steps_1.project_id = projects.id', array());
			$query->join('s_1_forms_1', 's_1_forms_1.step_1_id = steps_1.id', array('nombre_del_proyecto' => 'nombre_del_proyecto', 'breve_descripcion' => 'breve_descripcion', 'photo' => 'photo'));
			$query->join('steps_5', 'steps_5.project_id = projects.id', array('s_photo' => 's_photo', 'l_photo' => 'l_photo'));		 
			$query->where('projects.id =' . $id);
			$project = $this->fetchRow($query);		
							 
			unlink(realpath(dirname(__FILE__) . '/../../') . '/public/skins/ecometro/img/projects/' . $project->photo);			
			unlink(realpath(dirname(__FILE__) . '/../../') . '/public/skins/ecometro/img/graphs/' . $project->s_photo);
			unlink(realpath(dirname(__FILE__) . '/../../') . '/public/skins/ecometro/img/graphs/' . $project->l_photo);
			$row->delete();

			// return boolean true
			return true;
		} else {			
			throw new Zend_Exception('No se ha podido borrar el proyecto.');
		}
	}				

	/**
	 * [findProjectsByAccountId description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findProjectsByAccountId($id)
	{
		// find the row that matches the id
		$query = $this->select()->setIntegrityCheck(false);
		$query->distinct();
		$query->from('projects');
		$query->join('steps_1', 'steps_1.project_id = projects.id', array());
		$query->join('s_1_forms_1', 's_1_forms_1.step_1_id = steps_1.id', array('nombre_del_proyecto' => 'nombre_del_proyecto', 'breve_descripcion' => 'breve_descripcion', 'photo' => 'photo'));
		$query->join('steps_5', 'steps_5.project_id = projects.id', array('s_photo' => 's_photo'));		 
		$query->where('projects.account_id =' . $id);
		$query->order('projects.created DESC');
		
		// create a new instance of the paginator adapter and return it
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($query);
		
		// return variable $adapter
		return $adapter;		
	} 
	
	/**
	 * [findProjects description]
	 * @param  array  $filters   [description]
	 * @param  [type] $sortField [description]
	 * @return [type]            [description]
	 */
	public function findProjects($filters = array(), $sortField = null)
	{
		// find the row that matches the id
		$query = $this->select()->setIntegrityCheck(false);
		$query->distinct();
		$query->from('projects');
		$query->join('steps_1', 'steps_1.project_id = projects.id', array());
		$query->join('s_1_forms_1', 's_1_forms_1.step_1_id = steps_1.id', array('nombre_del_proyecto' => 'nombre_del_proyecto', 'uso_principal_del_edificio' => 'uso_principal_del_edificio', 'lugar' => 'lugar', 'breve_descripcion' => 'breve_descripcion', 'photo' => 'photo'));
		$query->join('steps_5', 'steps_5.project_id = projects.id', array('s_photo' => 's_photo'));		 
		// add any filters which are set
		if(count($filters) > 0) {
			foreach ($filters as $field => $filter) {
				$query->where($field . ' = ?', $filter);
			}
		}
		$query->where('projects.public = 1');
		$query->order('projects.created DESC');		

		// create a new instance of the paginator adapter and return it
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($query);
		
		// return variable $adapter
		return $adapter;		
	} 
	
	/**
	 * [editPublicProject description]
	 * @param  [type] $id     [description]
	 * @param  [type] $public [description]
	 * @return [type]         [description]
	 */
	public function editPublicProject($id, $public)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();		
		$row->public = $public;
		$row->save();

		// return boolean true
		return true;		
	}

	/**
	 * [isCompleteProjectStep description]
	 * @param  [type]  $id    [description]
	 * @param  [type]  $count [description]
	 * @return boolean        [description]
	 */
	public function isCompleteProjectStep($id, $count)
	{				
		$row = $this->find($id)->current();					
					
		$result = $row->findParentRow('Model_Step' . $count);				
			
		if($result->completed)
			$class = 'complete';			
		else	
			$class = 'sinempezar';

		// return variable $class
		return $class;
	}	
	
	/**
	 * [isCompleteProject description]
	 * @param  [type]  $id   [description]
	 * @param  [type]  $flag [description]
	 * @return boolean       [description]
	 */
	public function isCompleteProject($id, $flag)
	{				
		$row = $this->find($id)->current();					

		if($flag) {
			$row->completed = 1;
			$row->save();
		} else {			
			$row->completed = 0;
			$row->save();
		}																
	}		
}