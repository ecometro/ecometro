<?php
/**
* Project Controller
*/
class ProjectController extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
	public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {            
            // if they aren't, they can't logout, so that action should 
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
        /* initialize action controller here */    	    		
    }

    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {
        /* body index action */         
    }
    
    /**
     * [createAction description]
     * @return [type] [description]
     */
	public function createAction()
	{		
		// número actividades del proceso
		$numeroActividades = 60;
		$porcentajeActividad = round(100 / $numeroActividades, 2);		
		// session object
		$myNamespace = new Zend_Session_Namespace('myNamespace');
		// crear el log.txt del proyecto
		$logfile = "logs/" . "log{$myNamespace->id}.txt";		
		// actualizar el log.txt del proyecto
		file_put_contents($logfile, $porcentajeActividad . "#" . "Crear Proyecto...,<br />", LOCK_EX);					    
		// project model
		$projectModel = new Model_Project();
		// step1 model
		$step1Model = new Model_Step1();
		// step1form1 model
		$step1Form1Model = new Model_Step1Form1();
		// step2 model
		$step2Model = new Model_Step2();		
		// número de formularios que pertenecen a Step 2 
        $numberOfFormsStep2 = $step2Model->getNumberOfColumns('mp');        
        // step3 model
		$step3Model = new Model_Step3();
		// número de formularios que pertenecen a Step 3 
        $numberOfFormsStep3Re = $step3Model->getNumberOfColumns('re');        
        $numberOfFormsStep3Bc = $step3Model->getNumberOfColumns('bc');
        $numberOfFormsStep3Ga = $step3Model->getNumberOfColumns('ga');        
        $numberOfFormsStep3Bl = $step3Model->getNumberOfColumns('bl');
        $numberOfFormsStep3Ge = $step3Model->getNumberOfColumns('ge');		
         // step4 model
		$step4Model = new Model_Step4();
        // step5 model
		$step5Model = new Model_Step5();				
		 
		try {
			// create a new project and retrieve the project's id
			$resultProject = $projectModel->createProject($this->account->id);
			/********************* STEP 1 ********************************/
			// create a new step1 and retreive the step1's id
			$resultStep1 = $step1Model->createStep1($resultProject);
			// create  anew form1 and retrieve the form1's id
			$resultStep1Form1 = $step1Form1Model->createStep1Form1($resultStep1);
			// actualizar step1 con el id del form1
			$step1Model->updateStep1($resultStep1, $resultStep1Form1);			
			// crear y actualizar el log.txt del proyecto
			file_put_contents($logfile, $porcentajeActividad * 2 . '#' . 'Crear Paso 1...<br />', LOCK_EX);					
			/********************* STEP 2 ********************************/
			// create a new step2 and retreive the step2's id
			$resultStep2 = $step2Model->createStep2($resultProject);
			file_put_contents($logfile, $porcentajeActividad * 3 . '#' . 'Crear Paso 2...<br />', LOCK_EX);					
			$this->_helper->createStep($step2Model, $resultStep2, 2, $numberOfFormsStep2, 'Mp', $logfile, $porcentajeActividad, 4);			
			/********************* STEP 3 ********************************/
			// create a new step3 and retreive the step3's id
			$resultStep3 = $step3Model->createStep3($resultProject);
			file_put_contents($logfile, $porcentajeActividad * 20 . '#' . 'Crear Paso 3...<br />', LOCK_EX);
			/********************* STEP 3 RE ********************************/
			$this->_helper->createStep($step3Model, $resultStep3, 3, $numberOfFormsStep3Re, 'Re', $logfile, $porcentajeActividad, 21);			
			/********************* STEP 3 BC ********************************/	
			$this->_helper->createStep($step3Model, $resultStep3, 3, $numberOfFormsStep3Bc, 'Bc', $logfile, $porcentajeActividad, 32);			
			/********************* STEP 3 GA ********************************/	
			$this->_helper->createStep($step3Model, $resultStep3, 3, $numberOfFormsStep3Ga, 'Ga', $logfile, $porcentajeActividad, 43);			
			/********************* STEP 3 BL ********************************/	
			$this->_helper->createStep($step3Model, $resultStep3, 3, $numberOfFormsStep3Bl, 'Bl', $logfile, $porcentajeActividad, 47);			
			/********************* STEP 3 GE ********************************/	
			$this->_helper->createStep($step3Model, $resultStep3, 3, $numberOfFormsStep3Ge, 'Ge', $logfile, $porcentajeActividad, 52);			
			/********************* FIN STEP 3 ********************************/
			/********************* STEP 4 ********************************/
			// create a new step4 and retreive the step4's id
			$resultStep4 = $step4Model->createStep4($resultProject);
			// crear y actualizar el log.txt del proyecto
			file_put_contents($logfile, $porcentajeActividad * 57 . '#' . 'Crear Paso 4...<br />', LOCK_EX);
			$step4PmtmModel = new Model_Step4Pmtm();
			// crear una nueva etapa de producción de materiales
			$resultStep4pmtm = $step4PmtmModel->createStep4Pmtm($resultStep4);
			// actualizar el paso 4 con el id de la etapa de producción de materiales
			$step4Model->updateStep4($resultStep4, $resultStep4pmtm, 'pmtm'); 
			file_put_contents($logfile, $porcentajeActividad * 58 . '#' . 'Crear Etapa de producción de materiales...<br />', LOCK_EX);					
			/********************* FIN STEP 4 ********************************/
			/********************* STEP 5 ********************************/
			// create a new step5 and retreive the step5's id
			$resultStep5 = $step5Model->createStep5($resultProject);						
			// crear y actualizar el log.txt del proyecto
			file_put_contents($logfile, $porcentajeActividad * 59 . '#' . 'Crear Paso 5...<br />', LOCK_EX);
						
			$data = array(0, 0, 0, 0, 0);
			$this->_helper->generateGraph($this->account->username, $resultProject, $data, 100, 100, 's', 10);
			$this->_helper->generateGraph($this->account->username, $resultProject, $data, 200, 200, 'l', 16);
			$s_photo = $this->account->username . '_graph_' . $resultProject . '_s.png';
			$l_photo = $this->account->username . '_graph_' . $resultProject . '_l.png';
			
			$step5Model->updateStep5($resultStep5, $s_photo, $l_photo);		
			file_put_contents($logfile, $porcentajeActividad * 60 . '#' . 'Crear Gráfico...<br />', LOCK_EX);
			/********************* FIN STEP 5 ********************************/
			
			// empty log file and delete it			
			file_put_contents($logfile, '');
			unlink($logfile);			
			
			// actualizar project con el id del step1 y el id del step2
			$projectModel->updateProject($resultProject, $resultStep1, $resultStep2, $resultStep3, $resultStep5);
						
			// save project id in session
			$myNamespace->projectsids[$resultProject] = true;
			
			// redirect to step1 controller index action
        	$urlOptions = array('controller' => 'step1', 'action' => 'edit', 'project_id' => $resultProject);
			$this->_helper->redirector->gotoRoute($urlOptions, 'step1Route');
		} catch (Exception $e) {				
			$this->view->errors = array($e->getMessage());
		}	 
	}

	/**
	 * [deleteAction description]
	 * @return [type] [description]
	 */
	public function deleteAction()
    {        
        $projectModel = new Model_Project();
		$project_id = $this->_request->getParam('project_id');
		$projectModel->deleteProject($project_id);
		// set the flash message and redirect the user to the index page
		$this->_helper->flashMessenger->addMessage(
			Zend_Registry::get('Zend_Translate')->translate('Proyecto borrado.')
		);
		$urlOptions = array('controller' => 'profile', 'action' => 'index', 'params' => 'project');
		$this->_helper->redirector->gotoRoute($urlOptions, 'profileListRoute'); 	
    }
    
    /**
     * [editpublicAction description]
     * @return [type] [description]
     */
	public function editpublicAction()
    {        
        $projectModel = new Model_Project();
		$project_id = $this->_request->getParam('project_id');
		$public = $this->_request->getParam('public');
		$projectModel->editPublicProject($project_id, $public);		
		// set the flash message and redirect the user to the index page
		$this->_helper->flashMessenger->addMessage(
			Zend_Registry::get('Zend_Translate')->translate('Proyecto publicado.')
		);
		$urlOptions = array('controller' => 'profile', 'action' => 'index', 'params' => 'project');
		$this->_helper->redirector->gotoRoute($urlOptions, 'profileListRoute'); 	
    }
}