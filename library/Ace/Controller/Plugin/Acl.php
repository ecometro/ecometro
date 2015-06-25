<?php
class Ace_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		// set up acl
		$acl = new Zend_Acl();
			
		// add the roles
		$acl->addRole(new Zend_Acl_Role('guest'));
		$acl->addRole(new Zend_Acl_Role('user'), 'guest');
		$acl->addRole(new Zend_Acl_Role('administrator'), 'user');
		
		// add the resources
		$acl->add(new Zend_Acl_Resource('cookie'));
		$acl->add(new Zend_Acl_Resource('account'));
		$acl->add(new Zend_Acl_Resource('bug'));
		$acl->add(new Zend_Acl_Resource('error'));		
		$acl->add(new Zend_Acl_Resource('index'));		
		$acl->add(new Zend_Acl_Resource('profile'));
		$acl->add(new Zend_Acl_Resource('project'));
		$acl->add(new Zend_Acl_Resource('projects'));
		$acl->add(new Zend_Acl_Resource('report'));
		//$acl->add(new Zend_Acl_Resource('sessionexpired'));
		$acl->add(new Zend_Acl_Resource('step1'));
		$acl->add(new Zend_Acl_Resource('step2'));
		$acl->add(new Zend_Acl_Resource('step3'));
		$acl->add(new Zend_Acl_Resource('step4'));
		$acl->add(new Zend_Acl_Resource('step5'));
		$acl->add(new Zend_Acl_Resource('admin'));
		$acl->add(new Zend_Acl_Resource('logs'));		
		
		// set up the access rules
		// administrators can do anything
		$acl->allow('user', null);		
		$acl->deny('user', 'admin');
		$acl->deny('user', 'account', array('list'));
		$acl->allow('administrator', null);
		$acl->allow('administrator', 'admin');
		$acl->allow('administrator', 'account', array('list'));		
		$acl->allow('guest', 'projects', array('evaluated'));
		$acl->allow('guest', 'cookie', array('index'));
				
		// fetch the current user
		$auth = Zend_Auth::getInstance();
		
		if($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
		} else {
			$role = 'guest';
		}
		
		$controller = $request->controller;
		$action = $request->action;
		
		if (!$acl->has($controller)) {
		    // action/resource does not exist in ACL		    
		    $request->setControllerName('error');
		    $request->setActionName('notfound');
		} else {		
			if (!$acl->isAllowed($role, $controller, $action)) {
				
				if ($role == 'guest') {
					
						if($controller == 'admin') {
							$request->setControllerName('admin');
							$request->setActionName('login');
						}
						
						elseif($controller == 'index') {
							$request->setControllerName('index');
							$request->setActionName('index');
						}
						
						elseif($controller == 'account' && $action == 'register'){
							$request->setControllerName('account');
							$request->setActionName('register');
						}
						
						elseif($controller == 'account' && $action == 'confirm'){
							$request->setControllerName('account');
							$request->setActionName('confirm');
						}
						
						elseif($controller == 'account' && $action == 'lostpswd'){
							$request->setControllerName('account');
							$request->setActionName('lostpswd');
						}
						
						elseif($controller == 'account' && $action == 'recoverpswd'){
							$request->setControllerName('account');
							$request->setActionName('recoverpswd');
						}
						
						elseif($controller == 'account' && $action == 'lostuser'){
							$request->setControllerName('account');
							$request->setActionName('lostuser');
						}

						elseif($controller == 'account' && $action == 'sessionexpired'){
							$request->setControllerName('account');
							$request->setActionName('sessionexpired');
						}						
						
					} else {
						$request->setControllerName('error');
						$request->setActionName('noauth');
					}			
			}
		}								
	}	
}
?>