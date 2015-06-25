<?php
/**
* Index Controller
*/
class IndexController extends Zend_Controller_Action
{
	/**
     * [init description]
     * @return [type] [description]
     */
    public function init()
    {
        /* Initialize action controller here */ 
        $urlOptions = array('controller' => 'account', 'action' => 'index');
        $this->_helper->redirector->gotoRoute($urlOptions, 'accountRoute'); 
    }
    
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {        
    }
}