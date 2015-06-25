<?php
/**
* Bug Controller
*/
class BugController extends Zend_Controller_Action
{
	/**
	 * [init description]
	 * @return [type] [description]
	 */
    public function init()
    {
        /* Initialize action controller here */
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
     * [createAction description]
     * @return [type] [description]
     */
    public function createAction()
    {
        // action body
    }
	
    /**
     * [submitAction description]
     * @return [type] [description]
     */
    public function submitAction()
    {
		$bugReportForm = new Form_BugReportForm();		
		$bugReportForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'bug', "action"=>"submit"), 'bugRoute'));
		$bugReportForm->setMethod('post');

		if ($this->getRequest()->isPost()) {
			if ($bugReportForm->isValid($_POST)) {
				// just dump the data for now
				// $data = $bugReportForm->getValues();
				// process the data
				$bugModel = new Model_Bug();
				// if the form is valid then create the new bug
				$result = $bugModel->createBug(
					$bugReportForm->getValue('name'),
					$bugReportForm->getValue('email'),					
					$bugReportForm->getValue('subject'),
					$bugReportForm->getValue('description')	
				);
				// if the createBug method returns a result
				// then the bug was successfully created
				if($result) {
					// redirect to bug controller confirm action
        			$urlOptions = array('controller' => 'bug', 'action' => 'confirm');
					$this->_helper->redirector->gotoRoute($urlOptions, 'bugRoute');					
				}				
			}
		}
		$this->view->form = $bugReportForm;		
    }

    /**
     * [confirmAction description]
     * @return [type] [description]
     */
    public function confirmAction()
    {
        // action body
    }

    /**
     * [listAction description]
     * @return [type] [description]
     */
    public function listAction()
    {    	
		// get the filter form
		$listToolsForm = new Form_BugReportListToolsForm();
		$listToolsForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'bug', "action"=>"list"), 'bugRoute'));	
		$listToolsForm->setMethod('post');
		$this->view->listToolsForm = $listToolsForm;
		
		// set the sort and filter criteria. you need to update this to use the request,
		// as these values can come in from the form post or a url parameter
		$sort = $this->_request->getParam('sort', null);
		$filterField = $this->_request->getParam('filter_field', null);
		$filterValue = $this->_request->getParam('filter');
		
		if(!empty($filterField)) {
			$filter[$filterField] = $filterValue;
		} else {
			$filter = null;
		}
		// now you need to manually set these controls values
		$listToolsForm->getElement('sort')->setValue($sort);
		$listToolsForm->getElement('filter_field')->setValue($filterField);
		$listToolsForm->getElement('filter')->setValue($filterValue);
		// fetch the bug paginator adapter
		$bugModels = new Model_Bug();
		$adapter = $bugModels->fetchPaginatorAdapter($filter, $sort);
		$paginator = new Zend_Paginator($adapter);
		// show 10 bugs per page
		$paginator->setItemCountPerPage(4);
		// get the page number that is passed in the request.
		// if none is set then default to page 1.
		$page = $this->_request->getParam('page', 1);
		$paginator->setCurrentPageNumber($page);
		// pass the paginator to the view to render
		$this->view->paginator = $paginator;    			    
    }

    /**
     * [editAction description]
     * @return [type] [description]
     */
    public function editAction()
    {
        $bugModel = new Model_Bug();
		$bugReportForm = new Form_BugReportForm();
		$bugReportForm->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'bug', "action"=>"edit"), 'bugRoute'));
		$bugReportForm->setMethod('post');

		if($this->getRequest()->isPost()) {
			if($bugReportForm->isValid($_POST)) {
				$bugModel = new Model_Bug();
				
				// if the form is valid then update the bug
				$result = $bugModel->updateBug(
					$bugReportForm->getValue('id'),
					$bugReportForm->getValue('name'),
					$bugReportForm->getValue('email'),
					$bugReportForm->getValue('subject'),					
					$bugReportForm->getValue('description')
				);

				$urlOptions = array('controller' => 'bug', 'action' => 'list');
				$this->_helper->redirector->gotoRoute($urlOptions, 'bugRoute');		
			}
		} else {
			
			$id = $this->_request->getParam('id');
			$bug = $bugModel->find($id)->current();
			$bugReportForm->populate($bug->toArray());
			// format the date field
			$bugReportForm->getElement('date')->setValue(date('m-d-Y', $bug->date));

		}
		
		$this->view->form = $bugReportForm;    	
    }

    /**
     * [deleteAction description]
     * @return [type] [description]
     */
    public function deleteAction()
    {
        // action body
        $bugModel = new Model_Bug();
		$id = $this->_request->getParam('id');
		$bugModel->deleteBug($id);
		$urlOptions = array('controller' => 'bug', 'action' => 'list');
		$this->_helper->redirector->gotoRoute($urlOptions, 'bugRoute'); 	
    }
}