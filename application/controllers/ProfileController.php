<?php
/**
* Profile Controller
*/
class ProfileController extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
	public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {            
            // If they aren't, they can't logout, so that action should 
            // redirect to the login form
            $urlOptions = array('controller' => 'account', 'action' => 'index');
			$this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute');            
        } else {        	
        	$identity = $auth->getIdentity();
        	$this->identity = $identity; 
            if(isset($identity)) {
            	$account = new Model_Account();
            	$project = new Model_Project();
            	$result = $account->findOneByUsernameOrEmail($identity->username, null);
            	$this->account = $result;  
            	$adapter = $project->findProjectsByAccountId($this->account->id);            	
            	$paginator = new Zend_Paginator($adapter);            	          
				// show 10 bugs per page
				$paginator->setItemCountPerPage(Zend_Registry::get('config')->num->pages);
				// get the page number that is passed in the request.
				// if none is set then default to page 1.
				$page = $this->_request->getParam('page', 1);
				$paginator->setCurrentPageNumber($page);
				// pass the paginator to the view to render				
				// pasos que pertenecen al proyecto 
        		$steps = array(1, 2, 3);
        		// valid projects's ids
        		$projectsids = array();
        		foreach($paginator as $proj) {
					foreach ($steps as $step) {
						${'completeStep' . $step} = $project->isCompleteProjectStep($proj->id, $step);												 																				
					}	
									
					if ($completeStep1 == 'complete' && $completeStep2 == 'complete' && $completeStep3 == 'complete') {
       					$project->isCompleteProject($proj->id, 1);
       					$proj->completed = 1;
					} else { 
       					$project->isCompleteProject($proj->id, 0);
       					$proj->completed = 0;
					} 
					$projectsids[$proj->id] = true;           				            		
				}
				// store in session valid project's ids
				$myNamespace = new Zend_Session_Namespace('myNamespace');
				$myNamespace->projectsids = $projectsids;
				
				$this->view->paginator = $paginator;				
            }
        }
    }
    
    /**
     * [init description]
     * @return [type] [description]
     */
    public function init()
    {           	
    	// get controller name from referer
    	$referer = $this->getRequest()->getParam('params');
		
    	if($this->_helper->FlashMessenger->hasMessages()) {
    		$this->view->referer = $referer; 	
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    	}	
    }

    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {		
    	$myNamespace = new Zend_Session_Namespace('myNamespace');
    	$prefix = $this->identity->username;    	
		$myNamespace->id = uniqid($prefix, false);		
        $this->view->account = $this->account;                          
    }
    
    /**
     * [editAction description]
     * @return [type] [description]
     */
	public function editAction()
	{
		$accountModel = new Model_Account();

		$profileForm = new Form_ProfileForm();
		$profileForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'profile', "action" => "edit"), 'profileRoute'));
		$profileForm->setAttrib('enctype', 'multipart/form-data');
		$profileForm->setMethod('post');
		
		if(Zend_Auth::getInstance()->getIdentity()->role != 'administrator')
			$profileForm->removeElement('user_role');

		if($this->getRequest()->isPost()) {			
			if($profileForm->isValid($_POST)) {
				try {
					// set image
					if ($profileForm->getElement('user_photo_profile')->isUploaded()) {
						$extension = pathinfo($profileForm->getElement('user_photo_profile')->getValue(), PATHINFO_EXTENSION);
						$profileForm->getElement('user_photo_profile')->addFilter('Rename', array(
	        				'target' => $this->account->username . '.' . $extension,
	        				'overwrite' => true
    					)); 
						if ($profileForm->getElement('user_photo_profile')->receive()) {				 	        			
	        				$this->account->photo = $profileForm->getElement('user_photo_profile')->getValue();
	        				$this->account->save();
	    				}
					}							
				
					$this->account->email = $profileForm->getValue('user_email_profile');
					$this->account->firstname = $profileForm->getValue('user_firstname_profile');
					$this->account->lastname = $profileForm->getValue('user_lastname_profile');
					$this->account->company = $profileForm->getValue('user_company_profile');
					$this->account->city = $profileForm->getValue('user_city_profile');
					$this->account->province = $profileForm->getValue('user_province_profile');
					$this->account->country = $profileForm->getValue('user_country_profile');
					$this->account->web = $profileForm->getValue('user_web_profile');
				
					// set update date
					$date = new Zend_Date();			
					$this->account->updated = $date->toString('YYYY-MM-dd HH:mm:ss');
				
					$this->account->save();
				
					// comprobar nueva contraseña
					if($profileForm->getValue('user_nuevo_pswd') != '' || $profileForm->getValue('user_rp_nuevo_pswd') != '') {
						if($profileForm->getValue('user_nuevo_pswd') == $profileForm->getValue('user_rp_nuevo_pswd')) {							
							$accountModel->updatePasswordAccount($this->account->id, $profileForm->getValue('user_nuevo_pswd'));							
							// Set the flash message and redirect the user to the index page
							$this->_helper->flashMessenger->addMessage(
								Zend_Registry::get('Zend_Translate')->translate('Perfil actualizado.')
							);
						
							$urlOptions = array('controller' => 'profile', 'action' => 'index');
							$this->_helper->redirector->gotoRoute($urlOptions, 'profileRoute');							
						} else {											
							$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Las contraseñas no son identicas.'));						
						} 											
					} else {
						// set the flash message and redirect the user to the index page
						$this->_helper->flashMessenger->addMessage(
							Zend_Registry::get('Zend_Translate')->translate('Perfil actualizado.')
						);
						
						$urlOptions = array('controller' => 'profile', 'action' => 'index');
						$this->_helper->redirector->gotoRoute($urlOptions, 'profileRoute');
					}					
				} catch (Exception $e) {
						$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hemos encontrado un problema al actualizar su perfil.'));
				}			
			}
		} else {		
			$data = array(
				'user_username_profile' => $this->account->username,
				'user_email_profile' => $this->account->email, 				 
				'user_firstname_profile' => $this->account->firstname,
				'user_lastname_profile' => $this->account->lastname,
				'user_company_profile' => $this->account->company,
				'user_city_profile' => $this->account->city,
				'user_province_profile' => $this->account->province,
				'user_country_profile' => $this->account->country,
				'user_web_profile' => $this->account->web,
				'user_role' => $this->account->role, 
			);					
			$profileForm->populate($data);				
		}		
		$this->view->photo = $this->account->photo;	
		$this->view->form_profile = $profileForm;		
	}	
}