<?php
/**
* Step 5 Controller
*/
class Step5Controller extends Zend_Controller_Action
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
    	
        // get provisional graphic
        $step5Model = new Model_Step5();
        $resultstep5 = $step5Model->findStep5byProjectId($this->project_id); 
        $this->view->l_photo = $resultstep5->l_photo; 
        
    	if($this->_helper->FlashMessenger->hasMessages())
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    	    	
    }
    
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {    	    	
		$step3Model = new Model_Step3();
        $step5Model = new Model_Step5();
		$result = $step5Model->findStep5byProjectId($this->project_id);		
        
        // results points array
        // formularios que pertenecen a Step 3 
        $forms = array(
            array('Re', array('numForms' => $step3Model->getNumberOfColumns('re'))),
            array('Bc', array('numForms' => $step3Model->getNumberOfColumns('bc'))),
            array('Ga', array('numForms' => $step3Model->getNumberOfColumns('ga'))),
            array('Bl', array('numForms' => $step3Model->getNumberOfColumns('bl'))),
            array('Ge', array('numForms' => $step3Model->getNumberOfColumns('ge'))),
        );

        $step1Model = new Model_Step1();
        $resultStep1 = $step1Model->findStep1byProjectId($this->project_id);
        $totalResults = $this->_helper->GraphData(new Model_Step3(), new Model_Calculus(), $resultStep1, $this->project_id, $forms);
        $data = array($totalResults['Bl'][2], $totalResults['Ga'][2], $totalResults['Ge'][2], $totalResults['Re'][2], $totalResults['Bc'][2]);            
        
        $this->view->data = $data;		 	
    }
}