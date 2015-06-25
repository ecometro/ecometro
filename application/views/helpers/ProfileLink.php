<?php 
/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Zend_View_Helper_ProfileLink
{   
	 
	public $view;

    /**
     * [setView description]
     * @param Zend_View_Interface $view [description]
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
    
    /**
     * [profileLink description]
     * @return [type] [description]
     */
    public function profileLink()
    {
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
                	
        	$identity = $auth->getIdentity();                    	
        	        	
            $profiletext = '<li class="pull-right active last"><a href="' . $this->view->url(array('controller' => 'profile', 'action' => 'index'), 'profileRoute') . '">' . Zend_Registry::get('Zend_Translate')->translate('Ir a página de usuario') . '</a></li>';
            $profiletext .= '<li class="pull-right"><a href="' . $this->view->url(array('controller' => 'account', 'action' => 'logout'), 'accountRoute') . '">' . Zend_Registry::get('Zend_Translate')->translate('Abandonar sesión') . '</a></a></li>';
            $profiletext .= '<li class="pull-right"><a href="#">' . Zend_Registry::get('Zend_Translate')->translate('Has iniciado sesión como ') . '<strong>' . $identity->username . '</strong></a></li>';
            if($identity->role == 'administrator')
            	$profiletext .= '<li class="pull-right"><a href="' . $this->view->url(array('controller' => 'admin', 'action' => 'index'), 'adminRoute') . '">' . Zend_Registry::get('Zend_Translate')->translate('Admin') . '</strong></a></li>';

            return  $profiletext;
        }   
        return '<li class="pull-right active last"><a href="' . $this->view->url(array('controller' => 'account', 'action' => 'login'), 'accountRoute') . '">' . Zend_Registry::get('Zend_Translate')->translate('Iniciar sesión') . '</a></li>' . '<li class="pull-right"><a href="'. $this->view->url(array('controller' => 'account', 'action' => 'register'), 'accountRoute') . '">' . Zend_Registry::get('Zend_Translate')->translate('Registrarse') . '</a></li>';     
    }
}