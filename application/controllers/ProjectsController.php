<?php
/**
* List Projects Controller
*/
class ProjectsController extends Zend_Controller_Action
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
     * [evaluatedAction description]
     * @return [type] [description]
     */
    public function evaluatedAction()
    {
        // instantiate form filter projects
        $filterProjectsForm = new Form_FilterProjectsForm();        
        $project = new Model_Project();  
        if($this->getRequest()->isPost()) {
            if($filterProjectsForm->isValid($_POST)) {  
                $tmp = $filterProjectsForm->getValue('buscar_por_categoria');               
                if($tmp != '') {                    
                    $adapter = $project->findProjects(array('uso_principal_del_edificio' => $tmp));  
                } else {
                    $adapter = $project->findProjects();        
                }
            }
        } else {
            $adapter = $project->findProjects();            
        }               
        $paginator = new Zend_Paginator($adapter);                                  
        $paginator->setItemCountPerPage(4);
        // get the page number that is passed in the request.
        // if none is set then default to page 1.
        $page = $this->_request->getParam('page', 1);
        $paginator->setCurrentPageNumber($page);
        // pass the paginator to the view to render
        $this->view->paginator = $paginator;
        $this->view->form_filter_projects = $filterProjectsForm;
    }
}