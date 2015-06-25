<?php
/**
* Step 1 Controller
*/
class Step1Controller extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
	public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance();    	
    	$myNamespace = new Zend_Session_Namespace('myNamespace');		 
    	
        if (!$auth->hasIdentity() || !array_key_exists($this->_request->getParam('project_id'), $myNamespace->projectsids)) {            
            // If they aren't, they can't logout, so that action should 
            // redirect to the login form
            $urlOptions = array('controller' => 'account', 'action' => 'index');
			$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');            
        } else {        	
        	$identity = $auth->getIdentity();
            if(isset($identity)) {
            	$account = new Model_Account();
            	$result = $account->findOneByUsernameOrEmail($identity->username, null);
            	$this->account = $result;             	
            }
        }
    }
    
    /**
     * [init description]
     * @return [type] [description]
     */
    public function init()
    {
    	$this->project_id = $this->_request->getParam('project_id');    	
    	$this->view->project_id = $this->project_id; 
        // Initialize action controller here
    	if($this->_helper->FlashMessenger->hasMessages())
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    }
	
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {    	
        // index action         
    }

    /**
     * [editAction description]
     * @return [type] [description]
     */
	public function editAction()
	{	
		$step1Form1Model = new Model_Step1Form1();							
		// form 1 total fields      			
		$nrColumnsTotal = $step1Form1Model->getNumberOfColumns();		
		// form 1 total fields completed
		$nrColumnsCompleted = 0;
		// instantiate model step1					
		$step1Model = new Model_Step1();
		// instantiate form 1 step1
		$step1F1Form = new Form_Step1F1Form();		
		// filter to convert float values from aa,bb to aa.bb 
		$filter_en = new Zend_Filter_LocalizedToNormalized();
		// filter to convert float values from aa.bb to aa,bb
		$filter_es = new Zend_Filter_NormalizedToLocalized();
		// find step 1 by project's id		
		$result = $step1Model->findStep1byProjectId($this->project_id);
					
		if($this->getRequest()->isPost()) {
			if($step1F1Form->isValid($_POST)) {					
				
				$result->modified = 1;
				
				// set image
				if ($step1F1Form->getElement('photo')->isUploaded()) {						
					$extension = pathinfo($step1F1Form->getElement('photo')->getValue(), PATHINFO_EXTENSION);
					$step1F1Form->getElement('photo')->addFilter('Rename', array(
	        			'target' => $this->account->username . '_project_' . $this->project_id . '.' . $extension,
	        			'overwrite' => true
	    			)); 
					if ($step1F1Form->getElement('photo')->receive()) {					 	        			
		        		$result->photo = $step1F1Form->getElement('photo')->getValue();
		        		$result->save();
		    		}
				}
				
				$tmp = $step1F1Form->getValue('nombre_del_proyecto');
				if(isset($tmp)) {
					if($tmp != '') {
						$result->nombre_del_proyecto = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->nombre_del_proyecto = null;
						$result->save();
					}							
						
				}
				$tmp = $step1F1Form->getValue('fase_del_proyecto');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->fase_del_proyecto = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->fase_del_proyecto = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('lugar');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->lugar = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->lugar = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('latitud');
				if(isset($tmp)) {	
					if($tmp != '') {
						$result->latitud = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->latitud = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('longitud');
				if(isset($tmp)) {
					if($tmp != '') { 	
						$result->longitud = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->longitud = null;
						$result->save();							
					}
				}
				$tmp = $step1F1Form->getValue('uso_principal_del_edificio');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->uso_principal_del_edificio = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->uso_principal_del_edificio = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('tipo_de_proyecto');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->tipo_de_proyecto = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->tipo_de_proyecto = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('breve_descripcion');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->breve_descripcion = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->breve_descripcion = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('no_de_ocupantes');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->no_de_ocupantes = $tmp;
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->no_de_ocupantes = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('superficie_de_parcela');
				if(isset($tmp)) {
					if($tmp != '') {					
						$result->superficie_de_parcela = $filter_en->filter($tmp);
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->superficie_de_parcela = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('superficie_ocupada');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->superficie_ocupada = $filter_en->filter($tmp);
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->superficie_ocupada = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('superficie_edificada');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->superficie_edificada = $filter_en->filter($tmp);
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->superficie_edificada = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('volumen_edificado');
				if(isset($tmp)) {
					if($tmp != '') {								
						$result->volumen_edificado =  $filter_en->filter($tmp);
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->volumen_edificado = null;
						$result->save();
					}
				}
				$tmp = $step1F1Form->getValue('superficie_cubierta');
				if(isset($tmp)) {
					if($tmp != '') {	
						$result->superficie_cubierta =  $filter_en->filter($tmp);
						$result->save();
						$nrColumnsCompleted++;
					} else {
						$result->superficie_cubierta = null;
						$result->save();
					}
				}
					
				if($nrColumnsCompleted == $nrColumnsTotal) {
					$result->completed = 1;
					$result->save();
				} else {
					$result->completed = 0;
					$result->save();
				}	
								
			    // step1's number of forms 
			    $numForms = 1;
			    $completeForms = $this->_helper->stateForm($this->project_id, 1, $numForms, 'Form');
			    if($completeForms)
			        	$step1Model->isCompleteStep1($this->project_id, 1);
			        else	
			        	$step1Model->isCompleteStep1($this->project_id, 0);
        	
				$urlOptions = array('controller' => 'step2', 'action' => 'index', 'project_id' => $this->project_id);
				$this->_helper->redirector->gotoRoute($urlOptions, 'step2Route');							
				} else {
					$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hay errores en el formulario. Por favor, revise los campos.'));
				}
			} else {													
				$data = array(
					'nombre_del_proyecto' => $result->nombre_del_proyecto,
					'fase_del_proyecto' => $result->fase_del_proyecto,
					'lugar' => $result->lugar,
					'latitud' => $result->latitud,
					'longitud' => $result->longitud,
					'uso_principal_del_edificio' => $result->uso_principal_del_edificio,
					'tipo_de_proyecto' => $result->tipo_de_proyecto,
					'breve_descripcion' => $result->breve_descripcion,
					'no_de_ocupantes' => $result->no_de_ocupantes,
					'superficie_de_parcela' => $filter_es->filter($result->superficie_de_parcela),
					'superficie_ocupada' => $filter_es->filter($result->superficie_ocupada),
					'superficie_edificada' => $filter_es->filter($result->superficie_edificada),
					'volumen_edificado' => $filter_es->filter($result->volumen_edificado),
					'superficie_cubierta' => $filter_es->filter($result->superficie_cubierta),				
				); 												
				$step1F1Form->populate($data);											
			}
		$this->view->photo = $result->photo;	
		$this->view->form_step1_f_1 = $step1F1Form;			
	}
}