<?php
/**
* Step 4 Controller
*/
class Step4Controller extends Zend_Controller_Action
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
            // If they aren't, they can't logout, so that action should
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
     * [indexAction description]
     * @return [type] [description]
     */
    public function indexAction()
    {    			    												
		// instantiate model step4					
		$step4Model = new Model_Step4();
		// instantiate form 1 step1
		$step4Bc3Form = new Form_Step4Bc3Form();
		// store errors
		$errors = array();		
		// top ten materials
		$topten = array();							
		
		$this->view->form_step4_bc3 = $step4Bc3Form;

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();

		if($this->getRequest()->isPost()) {
			if($step4Bc3Form->isValid($_POST)) {																					
				if ($step4Bc3Form->getElement('fichero')->isUploaded()) {											
	    			
	    			/***********************************************/ 
	    			/* 1. GET MATERIALS FROM TRANSLATOR BC3 -> CSV */
	    			/***********************************************/
					$data = $this->_helper->AcvTranslateBc3ToCsv($_FILES['fichero']);										
										
					/*******************************************************/ 
					/* 2. CREATE CSV FROM THE ARRAY PROVIDED BY TRANSLATOR */
					/*******************************************************/
					try {
						$filename = $this->_helper->AcvSaveUserCsv($this->account->username, $data, $this->project_id);
					} catch (Exception $e) {
						array_push($errors, Zend_Registry::get('Zend_Translate')->translate('An error ocurred.'));							
						$view->errors = $errors;
					}	
					
					/*****************************************/ 
					/* 3. CREATE TABLE TO HOLD INFO FROM CSV */
					/*****************************************/																				
					try {
						$this->_helper->AcvCreateUserTable($db, $this->project_id);
					} catch(Exception $e) {
						array_push($errors, Zend_Registry::get('Zend_Translate')->translate('An error ocurred.'));							
						$view->errors = $errors;
					}
					
					/********************************************/ 
					/* 4. POPULATE TABLE WITH THE INFO FROM CSV */
					/********************************************/	
					try {
						$this->_helper->AcvPopulateUserTable($db, $filename, $this->project_id);	
					} catch(Exception $e) {
						array_push($errors, Zend_Registry::get('Zend_Translate')->translate('An error ocurred.'));							
						$view->errors = $errors;
					}	
					
					/********************************************/ 
					/* 5. CALCULATE CO2 EMISSIONS 				*/
					/********************************************/
					try {
						$this->_helper->AcvCalculateEmissions($db, $this->project_id);
					} catch(Exception $e) {
						array_push($errors, Zend_Registry::get('Zend_Translate')->translate('An error ocurred.'));							
						$view->errors = $errors;
					}
				}
			}
		}

		/********************************************/ 
		/* 5. DISPLAY RESULTS 						*/
		/********************************************/
		try {
			$this->view->topten = $this->_helper->AcvDisplayEmissions($db, $this->project_id);			
		} catch(Exception $e) {
			array_push($errors, Zend_Registry::get('Zend_Translate')->translate('An error ocurred.'));							
			$view->errors = $errors;
		}
    }
    
	/**
	 * [listfamilymaterialsAction description]
	 * @return [type] [description]
	 */
    public function listfamilymaterialsAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
		// acv family materials
		$familyMaterialsModel = new Model_AcvFamilyMaterials();
		$results = $familyMaterialsModel->listFamilyMaterials();
		    	    	
    	echo Zend_Json::encode($results);    			
    }
    
	/**
	 * [findfamilyproductsAction description]
	 * @return [type] [description]
	 */
    public function findfamilyproductsAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
    	// get post parameters
    	if($this->getRequest()->isPost())
    		$idfamilymaterial = $this->getRequest()->getPost('key', null);    		   		    	
    	
		$familyProductsModel = new Model_AcvFamilyProducts();
		$results = $familyProductsModel->findFamilyProducts($idfamilymaterial);
				    	    	
    	echo Zend_Json::encode($results);		
    }
    

	/**
	 * [findproductsAction description]
	 * @return [type] [description]
	 */
    public function findproductsAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
    	// get post parameters
    	if($this->getRequest()->isPost())
    		$idfamilyproduct = $this->getRequest()->getPost('key', null);   
    	
		$productsModel = new Model_AcvProducts();
		$results = $productsModel->findProducts($idfamilyproduct);
				    	    	
    	echo Zend_Json::encode($results);		
    }
    
	/**
	 * [finddetailsproductAction description]
	 * @return [type] [description]
	 */
    public function finddetailsproductAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
    	// get post parameters
    	if($this->getRequest()->isPost())
    		$idproduct = $this->getRequest()->getPost('key', null);   
    	
		$productsModel = new Model_AcvProducts();
		$results = $productsModel->findDetailsProduct($idproduct);
			    	    	
    	echo Zend_Json::encode($results);		
    }
    
	/**
	 * [listproductoriginAction description]
	 * @return [type] [description]
	 */
    public function listproductoriginAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
		$productoriginModel = new Model_AcvProductOrigin();
		$results = $productoriginModel->listProductOrigin();
				    	    	
    	echo Zend_Json::encode($results);		
    }
    
	/**
	 * [listtransporttypeAction description]
	 * @return [type] [description]
	 */
    public function listtransporttypeAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();   
    	header('Content-type: application/json');
    	
		$transportTypeModel = new Model_AcvProductTransportType();
		$results = $transportTypeModel->listTransportType();
				    	    	
    	echo Zend_Json::encode($results);		
    }
    
	/**
	 * [newproductAction description]
	 * @return [type] [description]
	 */
    public function newproductAction()
    {
    	// instantiate model step1					
		$acvProductsModel = new Model_AcvProducts();
    	// instantiate form new material step4
		$acvNewMaterialForm = new Form_AcvNewMaterialForm();	
		
		if($this->getRequest()->isPost()) {
			if($acvNewMaterialForm->isValid($_POST)) {	
				// get producto
				$tmp = $acvNewMaterialForm->getValue('producto');				
				if(isset($tmp)) {
					if($tmp != '') {
						$producto = $tmp;												
					} else {
						$producto = null;						
					}												
				}				
				// get fabricante
				$tmp = $acvNewMaterialForm->getValue('fabricante');				
				if(isset($tmp)) {
					if($tmp != '') {
						$fabricante = $tmp;												
					} else {
						$fabricante = null;						
					}													
				}				
				// get origen_del_producto
				$tmp = $acvNewMaterialForm->getValue('origen_del_producto');				
				if(isset($tmp)) {
					if($tmp != '') {
						$origen_del_producto = $tmp;												
					} else {
						$origen_del_producto = null;						
					}													
				}				
				// get familia_de_productos_materiales
				$tmp = $acvNewMaterialForm->getValue('familia_de_productos_materiales');				
				if(isset($tmp)) {
					if($tmp != '') {
						$familia_de_productos_materiales = $tmp;												
					} else {
						$familia_de_productos_materiales = null;						
					}													
				}				
				// get familia_de_productos
				$tmp = $acvNewMaterialForm->getValue('familia_de_productos');				
				if(isset($tmp)) {
					if($tmp != '') {
						$familia_de_productos = $tmp;												
					} else {
						$familia_de_productos = null;						
					}													
				}				
				// get informacion_adicional
				$tmp = $acvNewMaterialForm->getValue('informacion_adicional');				
				if(isset($tmp)) {
					if($tmp != '') {
						$informacion_adicional = $tmp;												
					} else {
						$informacion_adicional = null;						
					}													
				}				
				// get cantidad
				$tmp = $acvNewMaterialForm->getValue('cantidad');				
				if(isset($tmp)) {
					if($tmp != '') {
						$cantidad = $tmp;												
					} else {
						$cantidad = null;						
					}													
				}				
				// get unidad
				$tmp = $acvNewMaterialForm->getValue('unidad');				
				if(isset($tmp)) {
					if($tmp != '') {
						$unidad = $tmp;
						// find unit measure
						$unitModel = new Model_AcvProductUnit();
						$measure = $unitModel->findUnitMeasureById($unidad);
						switch($measure['product_unit']) {
							case 'm': 	// get densidad
										$tmp = $acvNewMaterialForm->getValue('densidad');				
										if(isset($tmp)) {
											if($tmp != '') {
												$densidad = $tmp;												
											} else {
												$densidad = null;						
											}																			
										}
										// set espesor
									  	$espesor = 1;
									  	break;
							case 'm2':  // get densidad
										$tmp = $acvNewMaterialForm->getValue('densidad');				
										if(isset($tmp)) {
											if($tmp != '') {
												$densidad = $tmp;												
											} else {
												$densidad = null;						
											}																			
										}		
										// get espesor
										$tmp = $acvNewMaterialForm->getValue('espesor');				
										if(isset($tmp)) {
											if($tmp != '') {
												$espesor = $tmp;												
											} else {
												$espesor = null;						
											}																			
										}  	
										break;
							case 'm3':  // get densidad
										$tmp = $acvNewMaterialForm->getValue('densidad');				
										if(isset($tmp)) {
											if($tmp != '') {
												$densidad = $tmp;												
											} else {
												$densidad = null;						
											}																			
										}
									   // set espesor		
									   $espesor = 1;
									   break;
							case 'kg': // set densidad
									   $densidad = 1;
									   // set espesor	
									   $espesor = 1;
									   break;							
							case 'Componente':  // get densidad
												$tmp = $acvNewMaterialForm->getValue('densidad');				
												if(isset($tmp)){
													if($tmp != '') {
														$densidad = $tmp;												
													} else {
														$densidad = null;						
													}																					
												}
												// set espesor
												$espesor = 1;
									   		  	break;		   		   		   		  
							
						}																		
					} else {
						$unidad = null;						
					}													
				}				
				// get vida_util
				$tmp = $acvNewMaterialForm->getValue('vida_util');				
				if(isset($tmp)) {
					if($tmp != '') {
						$vida_util = $tmp;												
					} else {
						$vida_util = null;						
					}													
				}				
				// get emplazamiento_fabricante
				$tmp = $acvNewMaterialForm->getValue('emplazamiento_fabricante');				
				if(isset($tmp)) {
					if($tmp != '') {
						$emplazamiento_fabricante = $tmp;												
					} else {
						$emplazamiento_fabricante = null;						
					}						
				}				
				// get distancia_distribuidor
				$tmp = $acvNewMaterialForm->getValue('distancia_distribuidor');				
				if(isset($tmp)) {
					if($tmp != '') {
						$distancia_distribuidor = $tmp;												
					} else {
						$distancia_distribuidor = null;						
					}													
				}				
				// get tipo_de_transporte
				$tmp = $acvNewMaterialForm->getValue('tipo_de_transporte');				
				if(isset($tmp)) {
					if($tmp != '') {
						$tipo_de_transporte = $tmp;												
					} else {
						$tipo_de_transporte = null;						
					}													
				}				
				// get potencial_de_acidificacion
				$tmp = $acvNewMaterialForm->getValue('potencial_de_acidificacion');				
				if(isset($tmp)) {
					if($tmp != '') {
						$potencial_de_acidificacion = $tmp;												
					} else {
						$potencial_de_acidificacion = null;						
					}													
				}				
				// get potencial_de_eutrofizacion
				$tmp = $acvNewMaterialForm->getValue('potencial_de_eutrofizacion');				
				if(isset($tmp)) {
					if($tmp != '') {
						$potencial_de_eutrofizacion = $tmp;												
					} else {
						$potencial_de_eutrofizacion = null;						
					}													
				}				
				// get potencial_de_calentamiento_global
				$tmp = $acvNewMaterialForm->getValue('potencial_de_calentamiento_global');				
				if(isset($tmp)) {
					if($tmp != '') {
						$potencial_de_calentamiento_global = $tmp;												
					} else {
						$potencial_de_calentamiento_global = null;						
					}													
				}				
				// get potencial_de_agotamiento_de_capa_de_ozono
				$tmp = $acvNewMaterialForm->getValue('potencial_de_agotamiento_de_capa_de_ozono');				
				if(isset($tmp)) {
					if($tmp != '') {
						$potencial_de_agotamiento_de_capa_de_ozono = $tmp;												
					} else {
						$potencial_de_agotamiento_de_capa_de_ozono = null;						
					}													
				}				
				// get potencial_de_formacion_de_oxidantes_fotoquimicos
				$tmp = $acvNewMaterialForm->getValue('potencial_de_formacion_de_oxidantes_fotoquimicos');				
				if(isset($tmp)) {
					if($tmp != '') {
						$potencial_de_formacion_de_oxidantes_fotoquimicos = $tmp;												
					} else {
						$potencial_de_formacion_de_oxidantes_fotoquimicos = null;						
					}													
				}				
				// get agotamiento_de_recursos_abioticos
				$tmp = $acvNewMaterialForm->getValue('agotamiento_de_recursos_abioticos');				
				if(isset($tmp)) {
					if($tmp != '') {
						$agotamiento_de_recursos_abioticos = $tmp;												
					} else {
						$agotamiento_de_recursos_abioticos = null;						
					}													
				}				
				// get consumo_de_energia_primaria_total
				$tmp = $acvNewMaterialForm->getValue('consumo_de_energia_primaria_total');				
				if(isset($tmp)) {
					if($tmp != '') {
						$consumo_de_energia_primaria_total = $tmp;												
					} else {
						$consumo_de_energia_primaria_total = null;						
					}													
				}				
				// get origen_informacion_de_impactos
				$tmp = $acvNewMaterialForm->getValue('origen_informacion_de_impactos');				
				if(isset($tmp)) {
					if($tmp != '') {
						$origen_informacion_de_impactos = $tmp;												
					} else {
						$origen_informacion_de_impactos = null;						
					}													
				}

				$tmp = $acvNewMaterialForm->getValue('comentarios');					
				if (isset($tmp) && $tmp!=''){							
					$comentarios = $tmp;												
				}	
				
				$acvProductsModel->createProduct($producto, $fabricante, $origen_del_producto, $familia_de_productos_materiales, $familia_de_productos, $informacion_adicional, $cantidad, $unidad, $densidad, $espesor, $vida_util, $emplazamiento_fabricante, $distancia_distribuidor, $tipo_de_transporte, $potencial_de_acidificacion, $potencial_de_eutrofizacion, $potencial_de_calentamiento_global, $potencial_de_agotamiento_de_capa_de_ozono, $potencial_de_formacion_de_oxidantes_fotoquimicos, $agotamiento_de_recursos_abioticos, $consumo_de_energia_primaria_total, $origen_informacion_de_impactos, $comentarios);
				
				// Set the flash message and redirect the user to the index page
				$this->_helper->flashMessenger->addMessage(
					Zend_Registry::get('Zend_Translate')->translate('Producto guardado.')
				);
							
				$urlOptions = array('controller' => 'step4', 'action' => 'newmaterial', 'project_id' => $this->project_id);
					$this->_helper->redirector->gotoRoute($urlOptions, 'step4Route');										
				} else {
					$this->view->errors = array(Zend_Registry::get('Zend_Translate')->translate('Hay errores en el formulario. Por favor, revise los campos.'));
				}
			} else {
				$data = array(); 				
				$acvNewMaterialForm->populate($data);											
			}					
			$this->view->form_step4_new_material = $acvNewMaterialForm;
    }
    
    /**
     * [getetapasAction description]
     * @return [type] [description]
     */
    public function getetapasAction()
    {
    	
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
    	// encuentra etapa del paso 4 de este project id    	
    	$step4Model = new Model_Step4();
    	$step4result = $step4Model->findStep4byProjectId($this->project_id, 'Pmtm');
    	
    	// encuentra todos los materiales
    	$step4PmtmMaterialsModel = new Model_Step4PmtmMaterials();
		$results = $step4PmtmMaterialsModel->findPmtmMaterialsbyPmtmId($step4result->id);
		
		$json = array();
		
		// si el numero de filas es 1 y es null
    	// carga default
    	// si es diferente carga el contenido, la familia de materiales, la familia de productos y el producto
    	
		if (count($results) >= 1) {					
			foreach($results as $result) {
				array_push($json,
					array(
						'id' => $result->id,
						'family_material_id' => $result->family_material_id,
						'family_product_id' => $result->family_product_id,
						'product_id' => $result->product_id,
						'cantidad' => $result->cantidad,
					)
				);
			}				
		}    	    			    	    	
    	echo Zend_Json::encode($json);    	
    }
    
    /**
     * [saveAction description]
     * @return [type] [description]
     */
    public function saveAction()
    {
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');

	    // get post parameters    	
    	if($this->getRequest()->isPost()) {
    		$familymaterialsid = $this->getRequest()->getPost('familymaterialsid', null);
    		$familyproductsid = $this->getRequest()->getPost('familyproductsid', null);
    		$productsid = $this->getRequest()->getPost('productsid', null);
    		$selectedtrclass = $this->getRequest()->getPost('selectedtrclass', null);
    		$numrow = $this->getRequest()->getPost('numrow', null);
    		$cantidad = $this->getRequest()->getPost('cantidad', null);
    	}	 
    	// find step4 id
    	$step4Model = new Model_Step4();
    	$step4result = $step4Model->findStep4byProjectId($this->project_id, 'Pmtm');
    	// find pmtms materials first row id    	
		$step4PmtmMaterialsModel = new Model_Step4PmtmMaterials();
		
		$result = null;
		
		$newrow = false;
		
		if($selectedtrclass == '' && $familymaterialsid != null) {
			$newrow = true;			
			$result = $step4PmtmMaterialsModel->createStep4PmtmMaterials($step4result->id, $familymaterialsid, $familyproductsid, $productsid);			
		} elseif($selectedtrclass != "") {					
			$result = $step4PmtmMaterialsModel->updateStep4PmtmMaterials($selectedtrclass, $familymaterialsid, $familyproductsid, $productsid, $cantidad);			
		}															
		// set header of json type			
		$json = array(
    				'id' => $result,
    				'newrow' => $newrow,
    				'numrow' => $numrow,
					'message' => Zend_Registry::get('Zend_Translate')->translate('Material(es) guardado(s).'),													    					
    			);    			    	    	
    	echo Zend_Json::encode($json);
    }
    
    /**
     * [deleteAction description]
     * @return [type] [description]
     */
    public function deleteAction(){
    	
    	// disable view & layout
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	header('Content-type: application/json');
    	
    	// get post parameters    	
    	if($this->getRequest()->isPost()) {
    		$productid = $this->getRequest()->getPost('productid', null);
    		// find pmtms materials first row id    	
			$step4PmtmMaterialsModel = new Model_Step4PmtmMaterials();
			$result = $step4PmtmMaterialsModel->deleteStep4PmtmMaterials($productid);			
			if($result) {
				// set header of json type			
				$json = array(    			
							'message' => Zend_Registry::get('Zend_Translate')->translate('Material borrado.'),													    					
		    			);		    					    	    	
		    	echo Zend_Json::encode($json);
			}  		
    	}	    	
    }
    
    public function compareAction() {

    }
    
    /**
     * [resultsAction description]
     * @return [type] [description]
     */
    public function resultsAction()
    {
    	// get materials from etapa de producciÃ³n de materiales, transporte y mantenimiento    	
    	$step3Model = new Model_Step3();        
    	// find etapa producciÃ³n of step 4 with this project id    	
    	$step4Model = new Model_Step4();
    	$step4result = $step4Model->findStep4byProjectId($this->project_id, 'Pmtm');
    	// find all materials
    	$step4PmtmMaterialsModel = new Model_Step4PmtmMaterials();
		$results = $step4PmtmMaterialsModel->findPmtmMaterialsbyPmtmId($step4result->id);
		// find material's information
		$productModel = new Model_AcvProducts();
		// find matrices emplazamiento, transporte
		$modelEmplazamiento = new Model_AcvProductEmplazamientoFabricante();
		$modelTransporte = new Model_AcvProductTransportType();
		$modelOrigin = new Model_AcvProductOrigin();
		// find info step 1
		$step1Model = new Model_Step1();
        $resultStep1 = $step1Model->findStep1byProjectId($this->project_id);
        // get provisional graphic
        $step5Model = new Model_Step5();
        $resultStep5 = $step5Model->findStep5byProjectId($this->project_id); 
        $this->view->l_photo = $resultStep5->l_photo; 
        // results points array
       	// formularios que pertenecen a Step 3 
         $forms = array(array('Re', array('numForms' => $step3Model->getNumberOfColumns('re'))),
        	  		array('Bc', array('numForms' => $step3Model->getNumberOfColumns('bc'))),
        	  		array('Ga', array('numForms' => $step3Model->getNumberOfColumns('ga'))),
        	  		array('Bl', array('numForms' => $step3Model->getNumberOfColumns('bl'))),
        	  		array('Ge', array('numForms' => $step3Model->getNumberOfColumns('ge'))),
		);
       	$totalResults = $this->_helper->GraphData(new Model_Step3(), new Model_Calculus(), $resultStep1, $this->project_id, $forms);
		$data = array($totalResults['Bl'][2], $totalResults['Ga'][2], $totalResults['Ge'][2], $totalResults['Re'][2], $totalResults['Bc'][2]);
        $this->view->data = $data;		
		
		$materials = array();
		
		// total acidificacion
		$total_acidificacion = 0;
		$total_eutrofizacion = 0;
		$total_calentamiento_global = 0;
		$total_agotamiento_de_capa_de_ozono = 0;
		$total_formacion_de_oxidantes_fotoquimicos = 0;
		$total_agotamiento_de_recursos_abioticos = 0;
		$total_consumo_de_energia_primaria_total = 0;
		
		$results_impactos = array();
		
		if (count($results) >= 1) {					
			foreach($results as $result) {				
				// Formula STEP 4				
				// Matriz PRODUCTO/MATERIAL
				$product = $productModel->findNameProductById($result->product_id);			
				// Procedencia = IF(H7="Componente reutilizado",0,1)
				$origen_producto = $modelOrigin->findDetailsProductOrigin($product['id_product_origin']);
				if($origen_producto['product_origin'] == 'Componente reutilizado')				
					$procedencia = 0;
				else
					$procedencia = 1;					
				
				// Factor vida = CEILING(Vida proyectada del edificio (aÃ±os)/Vida Ãºtil producto,1,1)		
				$factor_vida = 1;				

				// Matriz EMPLAZAMIENTO FABRICANTE 
				$matriz_emplazamiento = $modelEmplazamiento->findDetailsEmplazamientoFabricante($product['id_emplazamiento_fabricante']);
				$matriz_emplazamiento_acidificacion = $matriz_emplazamiento['potencial_de_acidificacion'];
				$matriz_emplazamiento_eutrofizacion = $matriz_emplazamiento['potencial_de_eutrofizacion'];
				$matriz_emplazamiento_calentamiento_global = $matriz_emplazamiento['potencial_de_calentamiento_global'];
				$matriz_emplazamiento_agotamiento_de_capa_de_ozono = $matriz_emplazamiento['potencial_de_agotamiento_de_capa_de_ozono'];
				$matriz_emplazamiento_formacion_de_oxidantes_fotoquimicos = $matriz_emplazamiento['potencial_de_formacion_de_oxidantes_fotoquimicos'];
				$matriz_emplazamiento_agotamiento_de_recursos_abioticos = $matriz_emplazamiento['agotamiento_de_recursos_abioticos'];
				$matriz_emplazamiento_consumo_de_energia_primaria_total = $matriz_emplazamiento['consumo_de_energia_primaria_total'];				
				
				// Matriz TIPO DE TRANSPORTE
				$matriz_transporte = $modelTransporte->findDetailsTransportType($product['id_transport_type']);
				$matriz_transporte_acidificacion = $matriz_transporte['potencial_de_acidificacion'];
				$matriz_transporte_eutrofizacion = $matriz_transporte['potencial_de_eutrofizacion'];
				$matriz_transporte_calentamiento_global = $matriz_transporte['potencial_de_calentamiento_global'];
				$matriz_transporte_agotamiento_de_capa_de_ozono = $matriz_transporte['potencial_de_agotamiento_de_capa_de_ozono'];
				$matriz_transporte_formacion_de_oxidantes_fotoquimicos = $matriz_transporte['potencial_de_formacion_de_oxidantes_fotoquimicos'];
				$matriz_transporte_agotamiento_de_recursos_abioticos = $matriz_transporte['agotamiento_de_recursos_abioticos'];
				$matriz_transporte_consumo_de_energia_primaria_total = $matriz_transporte['consumo_de_energia_primaria_total'];
								
				
				$resultado_acidificacion = $result->cantidad * ($product['potencial_de_acidificacion'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_acidificacion * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_acidificacion * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);
											
				$resultado_eutrofizacion = $result->cantidad * ($product['potencial_de_eutrofizacion'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_eutrofizacion * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_eutrofizacion * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);
											
				$resultado_calentamiento_global = $result->cantidad * ($product['potencial_de_calentamiento_global'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_calentamiento_global * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_calentamiento_global * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);

				$resultado_agotamiento_de_capa_de_ozono = $result->cantidad * ($product['potencial_de_agotamiento_de_capa_de_ozono'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_agotamiento_de_capa_de_ozono * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_agotamiento_de_capa_de_ozono * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);

				$resultado_formacion_de_oxidantes_fotoquimicos = $result->cantidad * ($product['potencial_de_formacion_de_oxidantes_fotoquimicos'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_formacion_de_oxidantes_fotoquimicos * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_formacion_de_oxidantes_fotoquimicos * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);

				$resultado_agotamiento_de_recursos_abioticos = $result->cantidad * ($product['agotamiento_de_recursos_abioticos'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_agotamiento_de_recursos_abioticos * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_agotamiento_de_recursos_abioticos * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);							
																		
				$resultado_consumo_de_energia_primaria_total = $result->cantidad * ($product['consumo_de_energia_primaria_total'] * $procedencia * $factor_vida + 
											$matriz_emplazamiento_consumo_de_energia_primaria_total * $product['densidad'] * $product['espesor'] * $procedencia * $factor_vida +
											$matriz_transporte_consumo_de_energia_primaria_total * $product['densidad'] * $product['espesor'] * $factor_vida * $product['distancia_distribuidor']);							
																		
				$total_acidificacion += $resultado_acidificacion;
				$total_eutrofizacion += $resultado_eutrofizacion;					
				$total_calentamiento_global += $resultado_calentamiento_global;
				$total_agotamiento_de_capa_de_ozono += $resultado_agotamiento_de_capa_de_ozono;
				$total_formacion_de_oxidantes_fotoquimicos += $resultado_formacion_de_oxidantes_fotoquimicos;
				$total_agotamiento_de_recursos_abioticos += $resultado_agotamiento_de_recursos_abioticos;
				$total_consumo_de_energia_primaria_total += $resultado_consumo_de_energia_primaria_total;				
		
				// RESULTADO = 
				// Cantidad * 
				// (AcidificaciÃ³n [kg SO2-eq.] * 
				// Procedencia *
				// Factor Vida
				
				// +
				
				// Matriz Emplazamiento *
				// Densidad *
				// Espesor *
				// Procedencia *
				// Factor Vida
				
				// +
				
				// Matriz Transporte *
				// Densidad *
				// Espesor *		
				// Factor Vida *
				// Distancia Distribuidor-Obra
				
				array_push($materials,
					array(
						'producto' => $product['producto'],
						'potencial_de_acidificacion' => $product['potencial_de_acidificacion'],
						'potencial_de_eutrofizacion' => $product['potencial_de_eutrofizacion'],
						'potencial_de_calentamiento_global' => $product['potencial_de_calentamiento_global'],
						'potencial_de_agotamiento_de_capa_de_ozono' => $product['potencial_de_agotamiento_de_capa_de_ozono'],
						'potencial_de_formacion_de_oxidantes_fotoquimicos' => $product['potencial_de_formacion_de_oxidantes_fotoquimicos'],						 						
						'agotamiento_de_recursos_abioticos' => $product['agotamiento_de_recursos_abioticos'],
						'consumo_de_energia_primaria_total' => $product['consumo_de_energia_primaria_total'],
						'resultado_acidificacion' => $resultado_acidificacion,
						'resultado_eutrofizacion' => $resultado_eutrofizacion,
						'resultado_calentamiento_global' => $resultado_calentamiento_global,
						'resultado_agotamiento_de_capa_de_ozono' => $resultado_agotamiento_de_capa_de_ozono,
						'resultado_formacion_de_oxidantes_fotoquimicos' => $resultado_formacion_de_oxidantes_fotoquimicos,
						'resultado_agotamiento_de_recursos_abioticos' => $resultado_agotamiento_de_recursos_abioticos,
						'resultado_consumo_de_energia_primaria_total' => $resultado_consumo_de_energia_primaria_total,
					)
				);
			}				
		}						

		$results_impactos['total_acidificacion'] = $total_acidificacion;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_acidificacion_pers'] = $total_acidificacion/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_acidificacion_pers'] = 1;
				
		$results_impactos['total_eutrofizacion'] = $total_eutrofizacion;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_eutrofizacion_pers'] = $total_eutrofizacion/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_eutrofizacion_pers'] = 1;
		
		$results_impactos['total_calentamiento_global'] = $total_calentamiento_global;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_calentamiento_global_pers'] = $total_calentamiento_global/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_calentamiento_global_pers'] = 1;
			
		
		$results_impactos['total_agotamiento_de_capa_de_ozono'] = $total_agotamiento_de_capa_de_ozono;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_agotamiento_de_capa_de_ozono_pers'] = $total_agotamiento_de_capa_de_ozono/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_agotamiento_de_capa_de_ozono_pers'] = 1;
		
			
		$results_impactos['total_formacion_de_oxidantes_fotoquimicos'] = $total_formacion_de_oxidantes_fotoquimicos;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_formacion_de_oxidantes_fotoquimicos_pers'] = $total_formacion_de_oxidantes_fotoquimicos/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_formacion_de_oxidantes_fotoquimicos_pers'] = 1;
			
		$results_impactos['total_agotamiento_de_recursos_abioticos'] = $total_agotamiento_de_recursos_abioticos;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_agotamiento_de_recursos_abioticos_pers'] = $total_agotamiento_de_recursos_abioticos/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_agotamiento_de_recursos_abioticos_pers'] = 1;
			
		$results_impactos['total_consumo_de_energia_primaria_total'] = $total_consumo_de_energia_primaria_total;
		
		if($resultStep1['no_de_ocupantes'] != null)
			$results_impactos['total_consumo_de_energia_primaria_total_pers'] = $total_consumo_de_energia_primaria_total/$resultStep1['no_de_ocupantes'];
		else
			$results_impactos['total_consumo_de_energia_primaria_total_pers'] = 1;
			
		$this->view->materials = $materials;
		$this->view->results_impactos = $results_impactos;    	    	
    }	
}