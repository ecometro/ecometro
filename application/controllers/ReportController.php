<?php
/**
* Report Controller
*/
class ReportController extends Zend_Controller_Action
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
    	$this->project_id = $this->_request->getParam('project_id');    	
    	$this->view->project_id = $this->project_id; 
        // initialize action controller here    	
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
     * [downloadAction description]
     * @return [type] [description]
     */
    public function downloadAction()
    {    	
        // download action
        try {        	
    	  // create PDF
    	  $pdf = new Zend_Pdf();    	  
    	  // create A4 page
    	  $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);    	  
    	  // define font resource
    	  $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);    	  
    	  // set font for page
    	  // write text to page
    	  $page->setFont($font, 24)
    	       ->drawText('Ecómetro', 0, 841.9, 'UTF-8')
    	       ->drawText('Informe', 72, 620, 'UTF-8');    	  
    	  // add page to document
    	  $pdf->pages[] = $page;    	  
    	  // save as file
    	  $pdf->save('example.pdf');
    	  echo 'SUCCESS: Document saved!';	  
		} catch (Zend_Pdf_Exception $e) {
		  die ('PDF error: ' . $e->getMessage());  
		} catch (Exception $e) {
		  die ('Application error: ' . $e->getMessage());    
		}         
    }    
}