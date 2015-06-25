<?php
/**
* Step 2 Controller
*/
class Step2Controller extends Zend_Controller_Action
{
	/**
	 * [preDispatch description]
	 * @return [type] [description]
	 */
	public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance();    	
    	$myNamespace = new Zend_Session_Namespace('myNamespace');
    	
        if (!$auth->hasIdentity() || (!array_key_exists($this->_request->getParam('project_id'), $myNamespace->projectsids))) {            
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
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();    	    	
    	
    	// get post parameters
    	if($this->getRequest()->isPost()) {
    		$indexOfTheField = $this->getRequest()->getPost('indexOfTheField', null);
    		$idOfTheForm = $this->getRequest()->getPost('idOfTheForm', null);
    		$flagOfTheField = $this->getRequest()->getPost('flagOfTheField', null);     		   		
    		$valueOfTheField = $this->getRequest()->getPost('valueOfTheField', null);   		
    	}
    	
    	// set session data with form results and total
    	$myNamespace = new Zend_Session_Namespace('myNamespace');
    	
    	// update aplicable
    	$myNamespace->{'aplicable_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $flagOfTheField;    	    	    
    			
    	// update fields results array, value is set to the value entered by the user
    	$myNamespace->{'value_' . $this->project_id . $idOfTheForm}[$indexOfTheField] = $valueOfTheField;

    	// send back array of user input
    	$json = array(
    		'indexOfTheField' => $indexOfTheField,
    		'flagOfTheField' => $flagOfTheField,    				   				    					
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
    	    	
    	$this->_helper->checkValidField(2);
    } 
    /**
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {
        // index action  
        $step1Model = new Model_Step1();
        $result = $step1Model->findStep1byProjectId($this->project_id);
        $this->view->step1_f_1 = $result;
        $step2Model = new Model_Step2();
        // step2's number of forms  
        $numberOfMpForms = $step2Model->getNumberOfColumns('mp');
        $completeFormsMp = $this->_helper->stateForm($this->project_id, 2, $numberOfMpForms, 'Mp');
        if($completeFormsMp)
        	$step2Model->isCompleteStep2($this->project_id, 1);
        else	
        	$step2Model->isCompleteStep2($this->project_id, 0);        	
    }

    /**
     * [editmp1Action description]
     * @return [type] [description]
     */
	public function editmp1Action()
	{						
		$data = array(
			'densidad_de_habitantes',
			'densidad_de_viviendas',
			'superficie_urbana',
			'volumen_edificado',
			'area_verde_urbana',
			'superficie_de_uso_no_residencial',
			'numero_de_actividades_diferentes',
			'superficie_artificial',				
		);

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 1, $data);
	}
	
	/**
	 * [editmp2Action description]
	 * @return [type] [description]
	 */
	public function editmp2Action()
	{								
		$data = array(
			'categorizacion_urbana_siose',
			'ocupacion_del_suelo_corine_2000',
			'ocupacion_del_suelo_corine_2006',
			'cambios_significativos_en_la_ocupacion_del_suelo',
			'hay_indicios_de_contaminacion_del_suelo',
			'riesgo_de_erosion_potencial_del_suelo',
			'riesgo_potencial_significativo_de_inundacion',
			'zona_inundable_probabilidad',
			'algun_otro_riesgo_o_valor_ambiental_relevante',					
		); 

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 2, $data);									    	    					
	}
	
	/**
	 * [editmp3Action description]
	 * @return [type] [description]
	 */
	public function editmp3Action()
	{								
		$data = array(
			'evapotranspiracion_real',
			'evapotranspiracion_potencial',
			'humedad_del_suelo',
			'escorrentias_zonas_vulnerables',
			'escorrentias_zonas_sensibles',
			'escorrentias_zona_de_captacion_de_zona_sensible',
			'permeabilidad',											
		);

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 3, $data);		
	}
	
	/**
	 * [editmp4Action description]
	 * @return [type] [description]
	 */
	public function editmp4Action()
	{								
		$data = array(
			'naturaleza_riqueza_de_especies_fauna_y_flora',
			'naturaleza_numero_de_especies_identificadas',
			'ecosistemas_tipo_de_paisaje_inventario_nacional_inp',
			'ecosistemas_habitat',
			'agricultura_cultivos_sobrecarga',
			'agricultura_cultivos_uso',
			'naturaleza_espacio_protegido_o_de_interes',									
		); 	

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 4, $data);							    	    					
	}
	
	/**
	 * [editmp5Action description]
	 * @return [type] [description]
	 */
	public function editmp5Action()
	{				
		$data = array(
			'horas_fuera_de_la_zona_de_confort',
			'radiacion_solar_directa_horizontal',
			'obstruccion_solar_y_de_vientos',
			'isla_de_calor_indice_de_reflectancia_medio_local',
			'isla_de_calor_numero_de_equipos_emisores_de_calor',
			'isla_de_calor_area_verde',				
		); 

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 5, $data);				
	}
	
	/**
	 * [editmp6Action description]
	 * @return [type] [description]
	 */
	public function editmp6Action()
	{						
		$data = array(
			'so2_numero_de_dias_que_se_supera_el_limite',
			'co_numero_de_dias_que_se_supera_el_limite',
			'nox_numero_de_dias_que_se_supera_el_limite',
			'o3_numero_de_dias_que_se_supera_el_limite',
			'pm10_numero_de_dias_que_se_supera_el_limite',
			'localizacion_de_fuentes_de_contaminacion_cercanas',
			'olores',				
		); 	
		
		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 6, $data);				
	}
	
	/**
	 * [editmp7Action description]
	 * @return [type] [description]
	 */
	public function editmp7Action()
	{				
		$data = array(
			'ruido_aereo_ambiental_diurno',
			'ruid_aereo_ambiental_nocturno',
			'contaminacion_luminica',				
		);

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 7, $data);							    	    				
	}
	
	/**
	 * [editmp8Action description]
	 * @return [type] [description]
	 */
	public function editmp8Action()
	{						
		$data = array(
			'campos_estaticos',
			'radiaciones_naturales',
			'baja_frecuencia_campo_magnetico',
			'baja_frecuencia_campo_electrico',
			'alta_frecuencia',																						
		); 

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 8, $data);		
	}
	
	/**
	 * [editmp9Action description]
	 * @return [type] [description]
	 */
	public function editmp9Action()
	{						
		$data = array(
			'radiacion_ambiental',
			'gas_radon',																						
		);
		
		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 9, $data);					    	    					
	}
	
	/**
	 * [editmp10Action description]
	 * @return [type] [description]
	 */
	public function editmp10Action()
	{						
		$data = array(
			'distancia_a_parada_de_metro_travia',
			'distancia_a_parada_de_tren',
			'distancia_a_parada_de_autobus',
			'metros_lineales_de_viario',
			'metros_l_de_viario_para_peatones_y_bicicletas',
			'superficie_vial_aparcamiento_zona_peatonal_sin_vegetacion',
			'sup_de_viario_para_peatones_y_bicicletas',
			'capacidad_de_aparcamiento',																						
		); 
		
		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 10, $data);
	}
	
	/**
	 * [editmp11Action description]
	 * @return [type] [description]
	 */
	public function editmp11Action()
	{						
		$data = array(
			'es_posible_aportar_energia_electrica_a_la_red',
			'otras_redes_locales',																						
		);

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 11, $data);					    	    					
	}
	
	/**
	 * [editmp12Action description]
	 * @return [type] [description]
	 */
	public function editmp12Action()
	{				
		$data = array(
			'suministro_de_agua_potable',
			'suministro_de_agua_reciclada_no_potable',								
			'red_separativa_de_evacuacion',
			'estacion_depuradora_de_aguas_residuales_edar',
			'tipo_de_tratamiento_de_la_depuradora',					
		); 

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 12, $data);			
	}
	
	/**
	 * [editmp13Action description]
	 * @return [type] [description]
	 */
	public function editmp13Action()
	{						
		$data = array(
			'materiales_locales',
			'masa_de_agua_subterranea',								
			'afloramientos_permeables',
			'red_de_control_de_estado_quimico',
			'pluviometria',					
		);

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 13, $data);					    	    					
	}
	
	/**
	 * [editmp14Action description]
	 * @return [type] [description]
	 */
	public function editmp14Action()
	{					
		$data = array(
			'distancia_a_contenedores_de_papel',
			'distania_a_un_punto_limpio',								
			'distancia_a_un_punto_para_compostaje',				
		);
		
		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 14, $data);					    	    					
	}
	
	/**
	 * [editmp15Action description]
	 * @return [type] [description]
	 */
	public function editmp15Action()
	{		
		$data = array(
			'distancia_a_vertedero',				
		); 			
		
		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 15, $data);		    	    					
	}
	
	/**
	 * [editmp16Action description]
	 * @return [type] [description]
	 */
	public function editmp16Action()
	{		
		$data = array(
			'energia_calefaccion',
			'energia_refrigeracion',
			'energia_acs',
			'energia_iluminacion_exterior',
			'energia_iluminacion_interior',
			'energia_equipos',
			'energia_compania_de_suministro',
			'agua_consumo_de_agua_potable',				
		); 					

		$result = $this->_helper->processFormStep2($this->project_id, 2, 'Mp', 16, $data);
	}
}