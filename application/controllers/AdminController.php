<?php
/**
* Admin Controller
*/
class AdminController extends Zend_Controller_Action
{
	
	/**
     * [preDispatch description]
     * @return [type] [description]
     */
    public function preDispatch()
    {        
    }
    	
	/**
     * [_authenticate description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected function _authenticate($data)
    {
		$db = Zend_Db_Table::getDefaultAdapter();
		$authAdapter = new Zend_Auth_Adapter_DbTable($db);
		
		$authAdapter->setTableName('accounts');
		$authAdapter->setIdentityColumn('username');
		$authAdapter->setCredentialColumn('password');
		$authAdapter->setCredentialTreatment('MD5(?) and confirmed = 1');
		
		$authAdapter->setIdentity($data['user_login']);
		$authAdapter->setCredential($data['user_pswd_login']);
		
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		
		if($result->isValid()) {			
			// store the username, first and last names of the user
			$auth = Zend_Auth::getInstance();
			$storage = $auth->getStorage();
			$storage->write($authAdapter->getResultRowObject(
			array('username' , 'firstname' , 'lastname', 'role')));			
			return true;
		} else {
			return false;
		}
    }
	
    /**
     * [init description]
     * @return [type] [description]
     */
    public function init()
    {    					        
    	if($this->_helper->FlashMessenger->hasMessages())
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    }
	
	
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {
        // action body
    }
    
	/**
     * [loginAction description]
     * @return [type] [description]
     */
    public function loginAction()
    {        
        $loginForm = new Form_LoginForm();
        $loginForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'admin', "action" => "login"), 'adminRoute'));        
		$loginForm->setMethod('post');
        
        // has the login form been posted?
        if($this->getRequest()->isPost()) {
        	// if the submitted data is valid, attempt to authenticate the user
        	if($loginForm->isValid($this->_request->getPost())) {
        		// did the user successfully login?
        		if($this->_authenticate($this->_request->getPost())) {        			
        			// generate the flash message and redirect the user
        			$this->_helper->flashMessenger->addMessage(
        				Zend_Registry::get('Zend_Translate')->translate('Has iniciado la sesión.')
        			);
        			// redirect to profile controller index action
        			$urlOptions = array('controller' => 'admin', 'action' => 'index');
					$this->_helper->redirector->gotoRoute($urlOptions, 'adminRoute');        			
        		} else {
        			$this->view->errors = array(
        				array(Zend_Registry::get('Zend_Translate')->translate('No se ha podido iniciar sesión. El usuario o la contraseña es incorrecto.'))
        			);
        		}
        	} 
        }        
        $this->view->form_login = $loginForm; 
    }	    
}