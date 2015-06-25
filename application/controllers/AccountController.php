<?php
/**
* Account Controller
*/
class AccountController extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
    public function preDispatch()
    {

        if (Zend_Auth::getInstance()->hasIdentity()) { 
        	$auth = Zend_Auth::getInstance()->getIdentity();
            // if the user is logged in, we don't want to show the login form;
            // however, the logout action should still be available
            if ('logout' != $this->getRequest()->getActionName() && 'administrator' != $auth->role) {
            	// redirect to profile controller index action
        		$urlOptions = array('controller' => 'profile', 'action' => 'index');
				$this->_helper->redirector->gotoRoute($urlOptions, 'profileRoute');                      
            } elseif('administrator' != $auth->role && 'register' == $this->getRequest()->getActionName()){
            	// redirect to profile controller index action
        		$urlOptions = array('controller' => 'account', 'action' => 'register');
				$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');
            }           
        } else {
            // if they aren't, they can't logout, so that action should 
            // redirect to the login form
            if ('logout' == $this->getRequest()->getActionName()) {            	
            	// redirect to account controller index action
        		$urlOptions = array('controller' => 'account', 'action' => 'index');
				$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');                
            }
        }
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
				array('username' , 'firstname' , 'lastname', 'role')
			));			
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
    	
        // login form
        $loginForm = new Form_LoginForm();	
        $loginForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', 'action' => 'login'), 'accountRoute'));	
		$loginForm->setMethod('post');
		$this->view->form_login = $loginForm;
    	
    	// register form
        $registerForm = new Form_RegisterForm();
        $registerForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', 'action' => 'register'), 'accountRoute'));		
		$registerForm->setMethod('post');
		$this->view->form_register = $registerForm;
    }
	
	public function sessionexpiredAction(){
		
	}

    /**
     * [registerAction description]
     * @return [type] [description]
     */
    public function registerAction()
    {
        
        $registerForm = new Form_RegisterForm();
        $registerForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', 'action' => 'register'), 'accountRoute'));        
		$registerForm->setMethod('post');
        
		if ($this->getRequest()->isPost()) {
			
			if ($registerForm->isValid($_POST)) {
				
				if($this->_request->getPost('user_pswd_register') == $this->_request->getPost('user_rp_pswd_register')) {

					$accountModel = new Model_Account();
					$result = $accountModel->findOneByUsernameOrEmail($registerForm->getValue('user_register'),$registerForm->getValue('user_email_register'));					

					if(!count($result)){
						try {															
							// if the form is valid then create the new account
							$result = $accountModel->createAccount(
								$registerForm->getValue('user_register'),
								$registerForm->getValue('user_email_register'),
								$registerForm->getValue('user_pswd_register'),
								$this->_helper->generateID()
							);
							// if the createAccount method returns a result
							// then the account was successfully created												
							$mail = new Zend_Mail('utf-8');				
							$mail->setFrom(Zend_Registry::get('config')->email->support, 'Ecómetro');
							$account = $accountModel->find($result)->current();
							$mail->addTo($account->email, "{$account->username}");
							$mail->setSubject('Ecómetro: Confirma tu cuenta');
							$baseurl = Zend_Layout::getMvcInstance()->getView()->serverUrl();							
							include '_email_confirm_email_address_' . Zend_Registry::get('Zend_Translate')->getLocale() . '.phtml';
							$mail->setBodyText($email);
							$mail->send();
							$this->_helper->flashMessenger->addMessage(
								Zend_Registry::get('Zend_Translate')->translate('Estás registrado. Comprueba tu correo para confirmar la cuenta')
							);
							$urlOptions = array('controller' => 'account', 'action' => 'login');
							$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');														
						} catch(Exception $e) {
							$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al crear su cuenta.'));
						}						
					} else {
						$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Este usuario o email ya existe.'));
					}					
				} else {
					$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Las contraseñas no son identicas.'));
				}				
			}
		}
		$this->view->form_register = $registerForm;
    }
	
    /**
     * [loginAction description]
     * @return [type] [description]
     */
    public function loginAction()
    {
        
        $loginForm = new Form_LoginForm();
        $loginForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', 'action' => 'login'), 'accountRoute'));        
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
        			$urlOptions = array('controller' => 'profile', 'action' => 'index');
					$this->_helper->redirector->gotoRoute($urlOptions, 'profileRoute');        		
        		} else {
        			$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('El usuario o la contraseña no es correcta.'));
        		}
        	} 
        }        

        $this->view->form_login = $loginForm; 
    }
	
    /**
     * [confirmAction description]
     * @return [type] [description]
     */
    public function confirmAction()
    {    	        
        $key = $this->_request->getParam('key');

        if($key != '') {

        	$accountModel = new Model_Account();
			$result = $accountModel->findOneByRecovery($key);

			if(count($result)) {
				try {
					// account found, confirm and reset recovery attribute
					$result->confirmed = 1;
					$result->recovery = '';
					$result->save();
					// set the flash message and redirect the user to the login page
					$this->_helper->flashMessenger->addMessage(
						Zend_Registry::get('Zend_Translate')->translate('Cuenta confirmada')
					);				
					$urlOptions = array('controller' => 'account', 'action' => 'login');
					$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');				
				} catch (Exception $e) {
					$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al confirmar su cuenta.'));
				}								
			} else {
				$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Cuenta no confirmada'));				
			}
        }
    }

    /**
     * [logoutAction description]
     * @return [type] [description]
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->flashMessenger->addMessage(
			Zend_Registry::get('Zend_Translate')->translate('Has cerrado la sesión.')
		);
		$urlOptions = array('controller' => 'account', 'action' => 'index');
		$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');        
    }

    /**
     * [lostpswdAction description]
     * @return [type] [description]
     */
    public function lostpswdAction()
    {        
        $lostPswdForm = new Form_LostPswdForm();
        $lostPswdForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', "action" => "lostpswd"), 'accountRoute'));        
		$lostPswdForm->setMethod('post');
        
        if($this->getRequest()->isPost()) {        	
        	if($lostPswdForm->isValid($this->_request->getPost())) {   

        			$accountModel = new Model_Account();        			
					$account = $accountModel->findOneByEmail($lostPswdForm->getValue('user_email_lost'));										

					if(count($account)){
						try {											
							$account->recovery = $this->_helper->generateID();
							$account->save();
							$mail = new Zend_Mail('utf-8');				
							$mail->setFrom(Zend_Registry::get('config')->email->support, 'Ecómetro');							
							$mail->addTo($account->email, "{$account->username}");
							$mail->setSubject('Ecómetro: Generar Nueva Contraseña');
							$baseurl = Zend_Layout::getMvcInstance()->getView()->serverUrl();
							include '_email_lost_password_' . Zend_Registry::get('Zend_Translate')->getLocale() . '.phtml';
							$mail->setBodyText($email);
							$mail->send();
							$this->_helper->flashMessenger->addMessage(
								Zend_Registry::get('Zend_Translate')->translate('Comprueba su correo para seguir las instrucciones')
							);
							$urlOptions = array('controller' => 'account', 'action' => 'login');
							$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');
						} catch (Exception $e) {
							$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al confirmar su cuenta.'));
						}															
					} else {
						$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Este email no existe.'));
					}        			
        	}    	
        }        
        $this->view->form_lost_pswd = $lostPswdForm; 
    }
	
    /**
     * [recoverpswdAction description]
     * @return [type] [description]
     */
    public function recoverpswdAction()
    {
    	$key = $this->_request->getParam('key');
    	
    	if($key != '') {    		

    		$accountModel = new Model_Account();
			$account = $accountModel->findOneByRecovery($key);

			if(count($account)) {
				try {
					// account found, confirm and reset recovery attribute
					$password = substr($this->_helper->generateID(), 0, 8);
					$account->confirmed = 1;
					$account->password = md5($password);				
					$account->recovery = '';
					$account->save();
					$mail = new Zend_Mail('utf-8');				
					$mail->setFrom(Zend_Registry::get('config')->email->support, 'Ecómetro');							
					$mail->addTo($account->email, "{$account->username}");
					$mail->setSubject('Ecómetro: Su nueva contraseña');
					$baseurl = Zend_Layout::getMvcInstance()->getView()->serverUrl();
					include "_email_recover_password_" . Zend_Registry::get('Zend_Translate')->getLocale() . '.phtml';
					$mail->setBodyText($email);
					$mail->send();
					$this->_helper->flashMessenger->addMessage(
						Zend_Registry::get('Zend_Translate')->translate('Se ha generado otra contraseña. Comprueba su correo.')
					);
					$urlOptions = array('controller' => 'account', 'action' => 'login');
					$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');
				} catch (Exception $e) {
					$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al confirmar su cuenta.'));
				}									
			} else {
				$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('La clave no se ha podido recuperar.'));								
			}    		
    	}
    }
    
	/**
	 * [lostuserAction description]
	 * @return [type] [description]
	 */
    public function lostuserAction()
    {    	 
        $lostUserForm = new Form_LostUserForm();
        $lostUserForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', "action" => "lostuser"), 'accountRoute'));        
		$lostUserForm->setMethod('post');
        
        if($this->getRequest()->isPost()) {        	
        	if($lostUserForm->isValid($this->_request->getPost())) {    

        			$accountModel = new Model_Account();        			
					$account = $accountModel->findOneByEmail($lostUserForm->getValue('user_email_lost'));										

					if(count($account)) {
						try {																							
							$mail = new Zend_Mail('utf-8');				
							$mail->setFrom(Zend_Registry::get('config')->email->support, 'Ecómetro');							
							$mail->addTo($account->email, "{$account->username}");
							$mail->setSubject('Ecómetro: Nombre de usuario');
							$baseurl = Zend_Layout::getMvcInstance()->getView()->serverUrl();
							include '_email_lost_user_' . Zend_Registry::get('Zend_Translate')->getLocale() . '.phtml';
							$mail->setBodyText($email);
							$mail->send();
							$this->_helper->flashMessenger->addMessage(
								Zend_Registry::get('Zend_Translate')->translate('Comprueba su correo para ver su usuario')
							);
							$urlOptions = array('controller' => 'account', 'action' => 'login');
							$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');												
						} catch (Exception $e) {
							$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('No se ha podido enviar el correo.'));
						}
					} else {
						$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Este email no existe.'));
					}        			
        	}        	
        }        
        $this->view->form_lost_user = $lostUserForm; 
    }

    /**
     * [listAction description]
     * @return [type] [description]
     */
    public function listAction()
    {
    	$adapter = Model_Account::getAccounts();
    	$paginator = new Zend_Paginator($adapter);
		// show 10 bugs per page
		$paginator->setItemCountPerPage(20);
		// get the page number that is passed in the request.
		// if none is set then default to page 1.
		$page = $this->_request->getParam('page', 1);
		$paginator->setCurrentPageNumber($page);
    	if($paginator->count() > 0) {    		
    		$this->view->paginator = $paginator;
    	} else {
    		$this->view->paginator = null;
    	}
    }

    /**
     * [updateAction description]
     * @return [type] [description]
     */
    public function updateAction()
    {
    	$profileForm = new Form_ProfileForm();

    	if(Zend_Auth::getInstance()->getIdentity()->role != 'administrator')
			$profileForm->removeElement('role');

    	$profileForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'account', "action" => "update"), 'accountIdRoute'));
		$profileForm->setAttrib('enctype', 'multipart/form-data');
		$profileForm->setMethod('post');
    	
    	$id = $this->_request->getParam('id');    	
    	$accountModel = new Model_Account();
    	$currentUser = $accountModel->find($id)->current(); 
    	$this->view->errors = array();

    	if($this->getRequest()->isPost()) {			
			if($profileForm->isValid($_POST)) {
				try {
					// set image
					if ($profileForm->getElement('user_photo_profile')->isUploaded()) {
						$extension = pathinfo($profileForm->getElement('user_photo_profile')->getValue(), PATHINFO_EXTENSION);
						$profileForm->getElement('user_photo_profile')->addFilter('Rename', array(
	        				'target' => $currentUser->username . '.' . $extension,
	        				'overwrite' => true
    					)); 
						if ($profileForm->getElement('user_photo_profile')->receive()) {				 	        			
	        				$photo = $profileForm->getElement('user_photo_profile')->getValue();	        				
	    				}
					} else 
						$photo = '';					
										
					$accountModel->updateAccount(
						$currentUser->id,						
						$profileForm->getValue('user_firstname_profile'), 
						$profileForm->getValue('user_lastname_profile'), 
						$profileForm->getValue('user_company_profile'), 
						$profileForm->getValue('user_city_profile'), 
						$profileForm->getValue('user_province_profile'), 
						$profileForm->getValue('user_country_profile'), 
						$profileForm->getValue('user_web_profile'),
						$profileForm->getValue('user_role'), 
						$photo);
				
					// comprobar nueva contraseña
					if($profileForm->getValue('user_nuevo_pswd') != '' || $profileForm->getValue('user_rp_nuevo_pswd') != '') {
						if($profileForm->getValue('user_nuevo_pswd') == $profileForm->getValue('user_rp_nuevo_pswd')) {							
							$accountModel->updatePasswordAccount($currentUser->id, $profileForm->getValue('user_nuevo_pswd'));							
						} else {											
							array_push($this->view->errors, Zend_Registry::get('Zend_Translate')->translate('Las contraseñas no son identicas.'));						
						} 											
					} 				
					
					// comprobar correo electrónico
					$result = $accountModel->checkUniqueEmailAccount($currentUser->id, $profileForm->getValue('user_email_profile'));
					if(empty($result))
						$accountModel->updateEmailAccount($currentUser->id, $profileForm->getValue('user_email_profile'));							
					else {						
						array_push($this->view->errors, Zend_Registry::get('Zend_Translate')->translate('El correo ya existe.'));						
					}

					if(!count($this->view->errors)) {
						// set the flash message and redirect the user to the index page
						$this->_helper->flashMessenger->addMessage(
							Zend_Registry::get('Zend_Translate')->translate('Perfil actualizado.')
						);
						
						$urlOptions = array('controller' => 'account', 'action' => 'update', 'id' => $currentUser->id);
						$this->_helper->redirector->gotoRoute($urlOptions, 'accountIdRoute');
					}					
				} catch (Exception $e) {
						array_push($this->view->errors, Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al actualizar su cuenta.'));
				}			
			}
		} else {		
			$data = array( 			
				'user_username_profile' => $currentUser->username,	 
				'user_email_profile' => $currentUser->email,	 
				'user_firstname_profile' => $currentUser->firstname,
				'user_lastname_profile' => $currentUser->lastname,
				'user_company_profile' => $currentUser->company,
				'user_city_profile' => $currentUser->city,
				'user_province_profile' => $currentUser->province,
				'user_country_profile' => $currentUser->country,
				'user_web_profile' => $currentUser->web,
				'user_role' => $currentUser->role,
			);					
			$profileForm->populate($data);				
		}							
		
 		$this->view->photo = $currentUser->photo;	
		$this->view->form_profile = $profileForm;
    }

    /**
     * [deleteAction description]
     * @return [type] [description]
     */
    public function deleteAction()
	{
		$id = $this->_request->getParam('id');
		$accountModel = new Model_Account();
		$this->view->errors = array();

		try {
			$accountModel->deleteAccount($id);			
			// set the flash message and redirect the user to the index page
			$this->_helper->flashMessenger->addMessage(
				Zend_Registry::get('Zend_Translate')->translate('Perfil actualizado.')
			);

			$urlOptions = array('controller' => 'account', 'action' => 'list');
			$this->_helper->redirector->gotoRoute($urlOptions, 'accountListRoute');			

		} catch (Exception $e) {
			array_push($this->view->errors, Zend_Registry::get('Zend_Translate')->translate('No se ha podido borrar el usuario.'));
		}		
	}
}