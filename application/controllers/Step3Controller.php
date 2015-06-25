<?php
/**
* Step 3 Controller
*/
class Step3Controller extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
	public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance();    	
    	$myNamespace = new Zend_Session_Namespace('myNamespace');
    	
        if (!$auth->hasIdentity()  || !array_key_exists($this->_request->getParam('project_id'), $myNamespace->projectsids)) {            
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
    	
    	if($this->_helper->FlashMessenger->hasMessages())
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    }
    
    /**
     * [aplicableAction description]
     * @return [type] [description]
     */
    public function aplicableAction()
    {
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();    	    	
    	
    	if($this->getRequest()->isPost()) {
    		$indexOfTheField = $this->getRequest()->getPost('indexOfTheField', null);
    		$idOfTheForm = $this->getRequest()->getPost('idOfTheForm', null);
    		$flagOfTheField = $this->getRequest()->getPost('flagOfTheField', null); 
    		$valueOfTheField = $this->getRequest()->getPost('valueOfTheField', null);   		
    	}    	

    	// set session data with form results and total
    	$myNamespace = new Zend_Session_Namespace('myNamespace');
    	// init form total result
    	$myNamespace->{'total_pct' . $this->project_id} = 0;
    	// calculate total result
	    if(count($myNamespace->{'data_' . $this->project_id . $idOfTheForm}) > 0) {
	    	foreach($myNamespace->{'data_' . $this->project_id . $idOfTheForm} as $field => $value)    			
	    		$myNamespace->{'total_pct' . $this->project_id} += $value;
	    		
	    }
    	// update aplicable
    	$myNamespace->{'aplicable_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $flagOfTheField;
    	
    	// update fields results array, value is set to the value entered by the user
    	$myNamespace->{'value_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $valueOfTheField;
    	
    	// if aplicable sum to total result, if not rest it
    	if($myNamespace->{'aplicable_' . $this->project_id . $idOfTheForm}[$indexOfTheField]) {
            if($myNamespace->{'comments_' . $this->project_id . $idOfTheForm}[$indexOfTheField]) {        		
    	    	$modelCalculus = new Model_Calculus();
    			$weightingFactor = $modelCalculus->getWeightingFactor(substr($idOfTheForm, 0, -1) . '_' . substr($idOfTheForm, -1) . '_' . $indexOfTheField);
    			$vectorField = array_shift(explode(':', $myNamespace->{'comments_' . $this->project_id . $idOfTheForm}[$indexOfTheField]));
    			$vectorValue = $modelCalculus->getVectorValue(substr($idOfTheForm, 0, -1) . '_' . substr($idOfTheForm, -1) . '_' . $indexOfTheField, $vectorField);
    			$resultValueOfTheField = $weightingFactor * $vectorValue;			
        		$myNamespace->{'total_pct' . $this->project_id} += $resultValueOfTheField;
        		$myNamespace->{'data_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $resultValueOfTheField;
            } else {
                $resultValueOfTheField = 0;                   
            }
    	} else {    	 	 
	    	if($myNamespace->{'comments_' . $this->project_id . $idOfTheForm}[$indexOfTheField]) {
	    		$modelCalculus = new Model_Calculus();
				$weightingFactor = $modelCalculus->getWeightingFactor(substr($idOfTheForm, 0, -1) . '_' . substr($idOfTheForm, -1) . '_' . $indexOfTheField);
				$vectorField = array_shift(explode(':', $myNamespace->{'comments_' . $this->project_id . $idOfTheForm}[$indexOfTheField]));
				$vectorValue = $modelCalculus->getVectorValue(substr($idOfTheForm, 0, -1) . '_' . substr($idOfTheForm, -1) . '_' . $indexOfTheField, $vectorField);
				$resultValueOfTheField = $weightingFactor * $vectorValue;
    			$myNamespace->{'total_pct' . $this->project_id} -= $resultValueOfTheField;
    			$myNamespace->{'data_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = 0;
    			$resultValueOfTheField = 0;
    		} else {
                $resultValueOfTheField = 0;
            }	
    	}	
    			
    	$json = array(
    		'indexOfTheField' => $indexOfTheField,
    		'flagOfTheField' => $flagOfTheField,
    		'valueOfTheField' => $resultValueOfTheField,
    		'total_pct' => $myNamespace->{'total_pct' . $this->project_id}					  				
    	);
		    	
    	header('Content-type: application/json');    	
    	echo Zend_Json::encode($json);        
    }
 
    /**
     * [calculusAction description]
     * @return [type] [description]
     */
    public function calculusAction()
    {    	
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();    	    	    	
    	    	
    	$this->_helper->checkValidField(3);
    } 

    /**
     * [commentsAction description]
     * @return [type] [description]
     */
    public function commentsAction()
    {
    	
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	
    	if($this->getRequest()->isPost()) {
    		
			$idOfTheForm = $this->getRequest()->getPost('idOfTheForm', null);
	    	$indexOfTheField = $this->getRequest()->getPost('indexOfTheField', null);
	    	$comments = $this->getRequest()->getPost('comments', null);	 	

	    	// instantiate model step3
	    	$step3Model = new Model_Step3();
	    	// find form by project's id		
			$result = $step3Model->findStep3byProjectId($this->project_id, substr($idOfTheForm, -1), ucfirst(substr($idOfTheForm, 0, -1)));
			// instantiate form model
			$formModelClass = 'Model_Step3' . ucfirst($idOfTheForm);            
			$formModelObject = new $formModelClass();
	    	$field = $formModelObject->{'findFieldby' . ucfirst($idOfTheForm) . 'Id'}($result, $indexOfTheField);		    	

	    	// get weighting factor
	    	$modelCalculus = new Model_Calculus();
			$weightingFactor = $modelCalculus->getWeightingFactor($field->id_calculus);
            
            $fieldComments = explode(':', $comments);            
			$vectorField = array_shift($fieldComments);

			$vectorValue = $modelCalculus->getVectorValue($field->id_calculus, $vectorField);
			$valueOfTheField = $weightingFactor * $vectorValue;

			// set session data with form comments, results and total
    		$myNamespace = new Zend_Session_Namespace('myNamespace');
    		
            // init form comments
    		$myNamespace->{'comments_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $comments;
    		
            // update fields results array
    		$myNamespace->{'data_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $valueOfTheField;
    		
            // init form total result and calculate total result
    		$myNamespace->{'total_pct' . $this->project_id} = 0;    	    	
    		if(count($myNamespace->{'data_' . $this->project_id . $idOfTheForm}) > 0) {
    			foreach($myNamespace->{'data_' . $this->project_id . $idOfTheForm} as $field => $value)    			
    				$myNamespace->{'total_pct' . $this->project_id} += $value;    			
    			}   
		}
		
    	$json = array(
    		'indexOfTheField' => $indexOfTheField,    				
    		'weightingFactor' => $weightingFactor, 
    		'vectorValue' => $vectorValue,
    		'valueOfTheField' => $valueOfTheField,
    		'total_pct' => $myNamespace->{'total_pct' . $this->project_id},
    		'comments' => $comments,  
    	);
		    	
    	header('Content-type: application/json');    	
    	echo Zend_Json::encode($json);
    }
    
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {        
        $step1Model = new Model_Step1();
        $result = $step1Model->findStep1byProjectId($this->project_id);
        $this->view->step1_f_1 = $result;
        $step3Model = new Model_Step3();        
        $modelCalculus = new Model_Calculus();
        $step5Model = new Model_Step5();
        // formularios que pertenecen a Step 3 
        $forms = array(
            array('Re', array('numForms' => $step3Model->getNumberOfColumns('re'))),
        	array('Bc', array('numForms' => $step3Model->getNumberOfColumns('bc'))),
        	array('Ga', array('numForms' => $step3Model->getNumberOfColumns('ga'))),
        	array('Bl', array('numForms' => $step3Model->getNumberOfColumns('bl'))),
        	array('Ge', array('numForms' => $step3Model->getNumberOfColumns('ge'))),
		);

       	/**************CALCULO GRÁFICO******************/       	
       	// results points array
       	$totalResults = $this->_helper->GraphData($step3Model, $modelCalculus, $result, $this->project_id, $forms);		
		$data = array($totalResults['Bl'][2], $totalResults['Ga'][2], $totalResults['Ge'][2], $totalResults['Re'][2], $totalResults['Bc'][2]);
		$this->_helper->generateGraph($this->account->username, $this->project_id, $data, 100, 100, 's', 10);
		$this->_helper->generateGraph($this->account->username, $this->project_id, $data, 200, 200, 'l', 16);
		$s_photo = $this->account->username . '_graph_' . $this->project_id . '_s.png';
		$l_photo = $this->account->username . '_graph_' . $this->project_id . '_l.png';
		// get provisional graphic        	
        $resultstep5 = $step5Model->findStep5byProjectId($this->project_id);         	
		$step5Model->updateStep5($resultstep5->id, $s_photo, $l_photo);	
		$this->view->l_photo = $resultstep5->l_photo;
		$this->view->data = $data;		
		/**************CALCULO GRÁFICO******************/		
 	  
        // averigua el estado de cada formulario	  
		foreach ($forms as $form)
			${'completeForms' . $form[0]} = $this->_helper->stateForm($this->project_id, 3, $form[1]['numForms'], $form[0]);
		
		if ($completeFormsRe && $completeFormsBc && $completeFormsGa && $completeFormsBl && $completeFormsGe)
       		$step3Model->isCompleteStep3($this->project_id, 1);
       	else 
       		$step3Model->isCompleteStep3($this->project_id, 0);        
    }

    /**
     * [editre1Action description]
     * @return [type] [description]
     */
	public function editre1Action()
	{
        $data = array(
            'numero_de_viviendas',
            'suelo_de_uso_pulbico',
            'volumen_edificado',
            'superficie_verde',
            'superficie_artificial',
            'superficie_de_uso_no_residencial',                                         
        );

        $mp1FieldsAllowed = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h');  
        $fieldsAllowed = array('mp1' => array('fields' => $mp1FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 1, $data, $fieldsAllowed);	    					
	}

	/**
	 * [editre2Action description]
	 * @return [type] [description]
	 */
	public function editre2Action()
	{								
        $data = array(
            'aplicacion_de_medidas_para_la_regeneracion',
            'descontaminar',
            'se_han_tratado_otros_riesgos',
            'suelo_ocupado',                    
        );

        $mp2FieldsAllowed = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h', 9 => 'i');    
        $fieldsAllowed = array('mp2' => array('fields' => $mp2FieldsAllowed, 'step' => 2));
		
        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 2, $data, $fieldsAllowed);       			    	    					
	}
	
	/**
	 * [editre3Action description]
	 * @return [type] [description]
	 */
	public function editre3Action()
	{	
        $data = array(
            'permeabilidad_del_suelo',
            'cargas_de_agua_pluvial_a_la_red',
            'erosion_del_suelo',                    
        );					
		
        $mp3FieldsAllowed = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g');    
        $fieldsAllowed = array('mp3' => array('fields' => $mp3FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 3, $data, $fieldsAllowed);       			    	    					
	}
	
	/**
	 * [editre4Action description]
	 * @return [type] [description]
	 */
	public function editre4Action()
	{						
        $data = array(
            'aportaciones_a_la_restauracion_del_habitat',
            'numero_de_especies_identificadas',                   
        );
        
        $mp4FieldsAllowed = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g');    
        $fieldsAllowed = array('mp4' => array('fields' => $mp4FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 4, $data, $fieldsAllowed);        	
	}
	
	/**
	 * [editre5Action description]
	 * @return [type] [description]
	 */
	public function editre5Action()
	{					
        $data = array(
            'aparcamiento_para_bicicletas',
            'accesibilidad',
            'aparcamiento_para_coches',
            'aparcamiento_para_coches_electricos',
            'aparcamiento_para_coches_compartidos',
            'demanda_energetica_transporte',                    
        );  

        $mp10FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h');    
        $fieldsAllowed = array('mp10' => array('fields' => $mp10FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 5, $data, $fieldsAllowed);						
	}
	
	/**
	 * [editre6Action description]
	 * @return [type] [description]
	 */
	public function editre6Action()
	{	
        $data = array(
            'indice_de_reflectancia_cubiertas_y_suelos',
            'equipos_emisores_de_calor',
            'area_verde_en_cubiertas_y_suelos',
            'obstruccion_solar_y_de_vientos',                    
        );					

        $mp5FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f'); 
        $fieldsAllowed = array('mp5' => array('fields' => $mp5FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 6, $data, $fieldsAllowed);					
	}
	
	/**
	 * [editre7Action description]
	 * @return [type] [description]
	 */
	public function editre7Action()
	{	
        $data = array(
            'emision_co2eq_medio_urbano',
            'emisiones_nox_medio_urbano',                   
        ); 
	   
        $mp6FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g');   
        $fieldsAllowed = array('mp6' => array('fields' => $mp6FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 7, $data, $fieldsAllowed);    				    	    					
	}
	
	/**
	 * [editre8Action description]
	 * @return [type] [description]
	 */
	public function editre8Action()
	{	
        $data = array(
            'emision_de_ruido',
            'emision_de_luz',                    
        ); 					

        $mp7FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c');   
        $fieldsAllowed = array('mp7' => array('fields' => $mp7FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 8, $data, $fieldsAllowed);					    	    					
	}
	
	/**
	 * [editre9Action description]
	 * @return [type] [description]
	 */
	public function editre9Action()
	{						
		$data = array(
            'alteraciones_geofisicas_radiacion_gamma',
            'campos_electricos_bf',
            'campos_electromagneticos_alta_frecuencia',
            'campos_magneticos_bf',
            'radioactividad_ambiental',
            'redes_geomagneticas',                    
        );

        $mp8FieldsAllowed = array (1 => 'a', 2 => 'b'); 
        $fieldsAllowed = array('mp8' => array('fields' => $mp8FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 9, $data, $fieldsAllowed);        
	}

    /**
     * [editre10Action description]
     * @return [type] [description]
     */
    public function editre10Action()
    {                       
        $data = array(
            'medidas_correctoras',                    
        ); 

        $mp9FieldsAllowed = array (1 => 'a', 2 => 'b'); 
        $fieldsAllowed = array('mp9' => array('fields' => $mp9FieldsAllowed, 'step' => 2));        

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 10, $data, $fieldsAllowed);                                                  
    }
	
	/**
	 * [editre11Action description]
	 * @return [type] [description]
	 */
	public function editre11Action()
	{				
        $data = array(
            'hay_espacio_disponible_para_reciclar_basuras',
            'hay_espacio_disponible_para_compostaje',                    
        );		

        $mp14FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c');
        $fieldsAllowed = array('mp14' => array('fields' => $mp14FieldsAllowed, 'step' => 2));  

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Re', 11, $data, $fieldsAllowed);					
	}
	
	/**
	 * [editbc1Action description]
	 * @return [type] [description]
	 */
	public function editbc1Action()
	{						
		$data = array(
            'calentamiento_global',
            'agotamiento_de_la_capa_de_ozoono',
            'acidificacion',
            'eutrofizacion',
            'creacion_de_ozono_fotoquimico',
            'agotamiento_de_recursos_abioticos_elementos',
            'agotamiento_de_recursos_abioticos_combustibles',
            'vida_util_del_edificio',                                
        ); 

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 1, $data, array());        			    	    					
	}
	
	/**
	 * [editbc2Action description]
	 * @return [type] [description]
	 */
	public function editbc2Action()
	{	
        $data = array(
            'cantidad_de_material_reutilizado',
            'cantidad_de_material_reciclado',
            'cantidad_de_material_virgen',
            'cantidad_de_material_renovable',                                
        );

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 2, $data, array());
	}
	
	/**
	 * [editbc3Action description]
	 * @return [type] [description]
	 */
	public function editbc3Action()
	{		
        $data = array(
            'distacia_media_de_recorrido_de_transporte',                    
        );				

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 3, $data, array());					    	    					
	}
	
	/**
	 * [editbc4Action description]
	 * @return [type] [description]
	 */
	public function editbc4Action()
	{	
        $data = array(
            'maderas',
            'petreos',
            'ceramicos',
            'plasticos',
            'metales',
            'materiales_compuestos',                    
        );

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 4, $data, array());					    	    					
	}
	
	/**
	 * [editbc5Action description]
	 * @return [type] [description]
	 */
	public function editbc5Action()
	{
        $data = array(
            'se_utilizan_refrigerantes',
            'odp_segun_el_tipo_de_refrigerante',                                     
            'gwp_segun_el_tipo_de_refrigerante',                    
        );					

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 5, $data, array());					    	    					
	}
	
	/**
	 * [editbc6Action description]
	 * @return [type] [description]
	 */
	public function editbc6Action()
	{	
        $data = array(
            'materiales_en_base_madera',
            'acabados_suelos',                                       
            'adhesivos_y_sellantes',
            'acabados_tabiqueria',
            'acabados_pinturas',            
        );  

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 6, $data, array());			    	    					
	}
	
	/**
	 * [editbc7Action description]
	 * @return [type] [description]
	 */
	public function editbc7Action()
	{				
        $data = array(
            'separacion_selectiva',
            'residuos_derivados_a_vertedero',                                        
            'residuos_separados',
            'residos_peligrosos',
            'movimiento_de_tierras',
            'transporte_a_vertedero',                    
        ); 
		
        $mp15FieldsAllowed = array (1 => 'a');  
        $fieldsAllowed = array('mp15' => array('fields' => $mp15FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 7, $data, $fieldsAllowed);			    	    					
	}
	
	/**
	 * [editbc8Action description]
	 * @return [type] [description]
	 */
	public function editbc8Action()
	{	
        $data = array(
            'consumo_de_energia_en_obra',
            'consumo_de_agua_en_obra',                                       
            'control_en_obra_de_la_calidad_del_aire_interior',                    
        ); 

        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');
        $mp12FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e');      
        $fieldsAllowed = array('mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2), 'mp12' => array('fields' => $mp12FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 8, $data, $fieldsAllowed);
	}
	
	/**
	 * [editbc9Action description]
	 * @return [type] [description]
	 */
	public function editbc9Action()
	{	
        $data = array(
            'contratacion_responsable',                    
        ); 

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 9, $data, array());			    	    					
	}
	
	/**
	 * [editbc10Action description]
	 * @return [type] [description]
	 */
	public function editbc10Action()
	{	
        $data = array(
            'facilidad_de_mantenimiento_y_limpieza',
            'facilidad_de_separacion_de_componentes',
            'vida_util_del_edificio',                    
        ); 

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bc', 10, $data, array());					    	    					
	}
	
	/**
	 * [editga1Action description]
	 * @return [type] [description]
	 */
	public function editga1Action()
	{	
        $data = array(
            'consumo_de_agua_potable_ducha',
            'consumo_de_agua_potable_cocina',
            'consumo_agua_potable_lavadora',
            'consumo_de_agua_potable_lavavajillas',
            'consumo_de_agua_potable_inodoro',
            'consumo_de_agua_potable_para_riego',                    
        );

        $mp12FieldsAllowed = array(1 => 'a', 2 => 'b');
        $mp13FieldsAllowed = array(2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e');         
        $fieldsAllowed = array('mp12' => array('fields' => $mp12FieldsAllowed, 'step' => 2), 'mp13' => array('fields' => $mp13FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ga', 1, $data, $fieldsAllowed);		
	}
	
	/**
	 * [editga2Action description]
	 * @return [type] [description]
	 */
	public function editga2Action()
	{	
        $data = array(
            'control_de_la_calidad_del_agua_de_suministro',
            'control_del_consumo_de_agua',
            'sistema_de_deteccion_de_fugas',                                                          
        ); 	

        $mp12FieldsAllowed = array(1 => 'a', 2 => 'b'); 
        $mp13FieldsAllowed = array(2 => 'b', 3 => 'c', 4 => 'd');
        $fieldsAllowed = array('mp12' => array('fields' => $mp12FieldsAllowed, 'step' => 2), 'mp13' => array('fields' => $mp13FieldsAllowed, 'step' => 2));
        
        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ga', 2, $data, $fieldsAllowed);			    	    					
	}
	
	/**
	 * [editga3Action description]
	 * @return [type] [description]
	 */
	public function editga3Action()
	{		
        $data = array(
            'agua_evacuada_a_la_red_local_domestica',
            'agua_evacuada_a_la_red_local_pluviales',                                                                                        
        );  
        
        $mp12FieldsAllowed = array(3 => 'c', 4 => 'd', 5 => 'e');
        $mp13FieldsAllowed = array(2 => 'b');
        $fieldsAllowed = array('mp12' => array('fields' => $mp12FieldsAllowed, 'step' => 2), 'mp13' => array('fields' => $mp13FieldsAllowed, 'step' => 2));    

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ga', 3, $data, $fieldsAllowed);					    	    					
	}
	
	/**
	 * [editga4Action description]
	 * @return [type] [description]
	 */
	public function editga4Action()
	{	
        $data = array(
            'control_de_depracion_in_situ',
            'control_de_calidad_de_agua_evacuada',                                               
        ); 

        $mp12FieldsAllowed = array(3 => 'c', 4 => 'd', 5 => 'e');   
        $mp13FieldsAllowed = array(2 => 'b'); 
        $fieldsAllowed = array('mp12' => array('fields' => $mp12FieldsAllowed, 'step' => 2), 'mp13' => array('fields' => $mp13FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ga', 4, $data, $fieldsAllowed);					    	    					
	}
	
	/**
	 * [editbl1Action description]
	 * @return [type] [description]
	 */
	public function editbl1Action()
	{					
        $data = array(
            'horas_fuera_de_la_zona_de_confort',                                                                 
        ); 

        $mp5FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f');     
        $fieldsAllowed = array('mp5' => array('fields' => $mp5FieldsAllowed, 'step' => 2));
        
        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bl', 1, $data, $fieldsAllowed);			    	    					
	}
	
	/**
	 * [editbl2Action description]
	 * @return [type] [description]
	 */
	public function editbl2Action()
	{		
        $data = array(
            'factor_luz_dia',
            'control_de_sistemas_de_sombreamiento',
            'acceso_solar_en_estancias_principales',                                             
            'linea_visual_profundidad',
            'confort_acustico_atenuacion_de_ruido',                    
        );
        
        $mp5FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f');     
        $mp7FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c');       
        $fieldsAllowed = array('mp5' => array('fields' => $mp5FieldsAllowed, 'step' => 2), 'mp7' => array('fields' => $mp7FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bl', 2, $data, $fieldsAllowed);	   				    	    					
	}
	
	/**
	 * [editbl3Action description]
	 * @return [type] [description]
	 */
	public function editbl3Action()
	{						
        $data = array(
            'ventilacion_cruzada',
            'sensores_de_co2',
            'control_de_las_zonas_de_admision',                                              
            'mantenimiento_y_limpieza',                                                              
        );     

        $mp6FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g');       
        $re7FieldsAllowed = array (1 => 'a', 2 => 'b');     
        $fieldsAllowed = array('mp6' => array('fields' => $mp6FieldsAllowed, 'step' => 2), 're7' => array('fields' => $re7FieldsAllowed, 'step' => 3));
        
        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bl', 3, $data, $fieldsAllowed);		
	}
	
	/**
	 * [editbl4Action description]
	 * @return [type] [description]
	 */
	public function editbl4Action()
	{	
        $data = array(
            'calificacion_demanda_de_calefaccion',
            'calificacion_demanda_de_refrigeracion',
            'demanda_de_acs',                                                
            'demanda_de_calefaccion',
            'demanda_de_refrigeracion',
            'demanda_de_acs_2',                                  
        );

        $mp5FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f');     
        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');        
        $fieldsAllowed = array('mp5' => array('fields' => $mp5FieldsAllowed, 'step' => 2), 'mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bl', 4, $data, $fieldsAllowed);			    	    					
	}
	
	/**
	 * [editbl5Action description]
	 * @return [type] [description]
	 */
	public function editbl5Action()
	{				
        $data = array(
            'demanda_para_iluminacion_interior',
            'demanda_para_iluminacion_exterior',
            'equipos_y_electrodomesticos_eficientes',                                                
            'espacio_para_tender_la_ropa',
            'ascensores_y_escaleras_mecanicas_eficientes',                                                   
        );

        $mp5FieldsAllowed = array (1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f');     
        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');        
        $fieldsAllowed = array('mp5' => array('fields' => $mp5FieldsAllowed, 'step' => 2), 'mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2));

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Bl', 5, $data, $fieldsAllowed);			    	    					
	}
	
	/**
	 * [editge1Action description]
	 * @return [type] [description]
	 */
	public function editge1Action()
	{	
        $data = array(
            'calificacion_energetica_emisiones_por_calefaccion',
            'calificacion_energetica_emisiones_por_refrigeracion',
            'calificacion_energetica_emisiones_por_acs',                                             
            'emisiones_por_calefaccion',
            'emisiones_por_refrigeracion',
            'emisiones_por_acs',                                                        
        ); 	

        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');
        $fieldsAllowed = array('mp11' => array('fields' => $mp11FieldsAllowed, 'step' => '2'));        		

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ge', 1, $data, $fieldsAllowed);					    	    					
	}
	
	/**
	 * [editge2Action description]
	 * @return [type] [description]
	 */
	public function editge2Action()
	{
        $data = array(
            'contrato_con_la_empresa_verde',
            'energia_aportada_a_la_red',                    
        );

        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');    
        $fieldsAllowed = array('mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2));					    	    					

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ge', 2, $data, $fieldsAllowed);                                                   
	}
	
	/**
	 * [editge3Action description]
	 * @return [type] [description]
	 */
	public function editge3Action()
	{	
        $data = array(
            'sistema_de_control_de_temperatura_por_zonas',
            'sistema_de_monitorizacion',
            'guia_de_uso_y_mantenimiento',                                                    
        ); 

        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');
        $fieldsAllowed = array('mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2));  

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ge', 3, $data, $fieldsAllowed);					    	    					
	}
	
	/**
	 * [editge4Action description]
	 * @return [type] [description]
	 */
	public function editge4Action()
	{		
        $data = array(
            'emisiones_nox_de_sistemas',                                                         
        );

        $mp11FieldsAllowed = array (1 => 'a', 2 => 'b');
        $fieldsAllowed = array('mp11' => array('fields' => $mp11FieldsAllowed, 'step' => 2));  

        $result = $this->_helper->processFormStep3($this->project_id, 3, 'Ge', 4, $data, $fieldsAllowed);					    	    					
	}
}