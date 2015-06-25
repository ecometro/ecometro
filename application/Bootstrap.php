<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initPluginLoaderCache()
	{
		if ('development' == $this->getEnvironment()) {
			$classFileIncCache =
				APPLICATION_PATH . '/data/cache/pluginLoaderCache.php';
			if (file_exists($classFileIncCache)) {
				include_once $classFileIncCache;
			}

			Zend_Loader_PluginLoader::setIncludeFileCache(
				$classFileIncCache
			);
		}
	}
	
	protected function _initTableMetaDataCache()
	{
	}

	protected function _initView()
	{
		// initialize view
		$view = new Zend_View();
		$view->doctype('HTML5');
		$view->headTitle('Ecómetro');
		$view->headMeta()->setCharset('UTF-8');		
		$view->headMeta()->appendName('description', '');
		$view->headMeta()->appendName('author', '');
		$view->headMeta()->appendName('keywords', '');
		$view->headMeta()->appendName('viewport', 'width=device-width, initial-scale=1.0');
		$view->headScript()->appendFile('/skins/ecometro/js/bootstrap/bootstrap.min.js', 'text/javascript');
		$view->headScript()->appendFile('/skins/ecometro/js/bootstrap/bootstrap-collapse.js', 'text/javascript');
		$view->headScript()->appendFile('/skins/ecometro/js/bootstrap/bootstrap-tooltip.js', 'text/javascript');				
		$view->headScript()->appendFile('/skins/ecometro/js/bootstrap/bootstrap-popover.js', 'text/javascript');		

		$view->headScript()->appendFile('/skins/ecometro/js/plugins/flot/jquery.flot.min.js', 'text/javascript');				
		$view->headScript()->appendFile('/skins/ecometro/js/plugins/flot/excanvas.min.js', 'text/javascript');
		$view->headScript()->appendFile('/skins/ecometro/js/plugins/flot/jquery.flot.axislabels.js', 'text/javascript');
		

		$view->skin = 'ecometro';
		// add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
			'ViewRenderer'
		);
		$viewRenderer->setView($view);

		// return it, so that it can be stored by the bootstrap
		return $view;
	}

	protected function _initAutoload()
	{
		// add autoloader empty namespace
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		$autoLoader->registerNamespace('Ecometro_');
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
			'basePath'=> APPLICATION_PATH,
			'namespace'=> '',
			'resourceTypes' => array(
				'form' => array(
				'path'=> 'forms/',
				'namespace' => 'Form_',
				),
				'model' => array(
				'path'
				=> 'models/',
				'namespace' => 'Model_'
				),
			),
		));

		// return it so that it can be stored by the bootstrap
		return $autoLoader;
	}

	protected function _initConfig()
	{
		$config = new Zend_Config($this->getOptions());
		Zend_Registry::set('config', $config);

		return $config;
	}

	protected function _initActionHelpers()
	{
		Zend_Controller_Action_HelperBroker::addPath(
			APPLICATION_PATH . "/controllers/helpers"
		);
	}

	protected function _initTranslate()
	{		
		$locale = new Zend_Locale('es_ES');
		Zend_Registry::set('Zend_Locale', $locale);

		$translate = new Zend_Translate('gettext', APPLICATION_PATH . "/langs", null, array('scan' => Zend_Translate::LOCALE_DIRECTORY, 'disableNotices' => true));
		$registry = Zend_Registry::getInstance();
		$registry->set('Zend_Translate', $translate);
		$translate->setLocale($locale);
	}

	protected function _initRoutes()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();

		$defaultRoute = new Zend_Controller_Router_Route(
	        ':controller/:lang',
	        array(
	            'module' => 'default',
	            'controller' => 'index',
	            'action' => 'index',
	        	'lang' => 'es',
	        )
	    );

	    $accountRoute = new Zend_Controller_Router_Route(
	        'account/:action/:lang',
	        array(
	            'module' => 'default',
	            'controller' => 'account',
	            'action' => 'index',
	        	'lang' => 'es',
	        )
	    );

	    $accountListRoute = new Zend_Controller_Router_Route(
	        'account/:action/:lang/:page',
	        array(
	            'module' => 'default',
	            'controller' => 'account',
	            'action' => 'index',
	        	'lang' => 'es',
	        	'page' => '1',	        	
	        )
	    );

	    $accountRegisterRoute = new Zend_Controller_Router_Route(
	        'account/confirm/key/:key/:lang',
	        array(
	            'module' => 'default',
	            'controller' => 'account',
	        	'action' => 'confirm',
	        	'lang' => 'es',
	        )
	    );

	    $accountForgotPswdRoute = new Zend_Controller_Router_Route(
	        'account/recoverpswd/key/:key/:lang',
	        array(
	            'module' => 'default',
	            'controller' => 'account',
	        	'action' => 'recoverpswd',
	        	'lang' => 'es',
	        )
	    );

	   	$accountIdRoute = new Zend_Controller_Router_Route(
	        'account/:action/:lang/:page/:id',
	        array(
	            'module' => 'default',
	            'controller' => 'account',
	            'action' => 'index',
	            'lang' => 'es',
	        	'page' => '1',
	        	'id' => '',	            
	        )
	    );

	    $profileRoute = new Zend_Controller_Router_Route(
	        'profile/:action/:lang',
	        array(
	            'module' => 'default',
	            'controller' => 'profile',
	            'action' => 'index',
	        	'lang' => 'es',
	        )
	    );

	    $profileListRoute = new Zend_Controller_Router_Route(
	        'profile/:action/:lang/:page/:params',
	        array(
	            'module' => 'default',
	            'controller' => 'profile',
	            'action' => 'index',
	        	'lang' => 'es',
	        	'page' => '1',
	        	'params' => '',
	        )
	    );

	    $bugRoute = new Zend_Controller_Router_Route(
	        'bug/:action',
	        array(
	            'module' => 'default',
	            'controller' => 'bug',
	            'action' => 'index',
	        )
	    );

	     $bugListRoute = new Zend_Controller_Router_Route(
	        'bug/:action/:page',
	        array(
	            'module' => 'default',
	            'controller' => 'bug',
	            'action' => 'index',
	        	'page' => '1',
	        )
	    );

	    $projectRoute = new Zend_Controller_Router_Route(
	        'project/:action',
	        array(
	            'module' => 'default',
	            'controller' => 'project',
	            'action' => 'index',
	        )
	    );

	    $projectIdRoute = new Zend_Controller_Router_Route(
	        'project/:action/:project_id',
	        array(
	            'module' => 'default',
	            'controller' => 'project',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	     $projectPublicRoute = new Zend_Controller_Router_Route(
	        'project/:action/:project_id/:public',
	        array(
	            'module' => 'default',
	            'controller' => 'project',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $projectsEvaluatedRoute = new Zend_Controller_Router_Route(
	        'proyectos/evaluados/:lang/:page/:params',
	        array(
	            'module' => 'default',
	            'controller' => 'projects',
	            'action' => 'evaluated',
	        	'lang' => 'es',
	        	'page' => '1',
	        	'params' => '',
	        )
	    );
	    $step1Route = new Zend_Controller_Router_Route(
	        'step1/:action/:project_id',
	        array(
	            'module' => 'default',
	            'controller' => 'step1',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $step2Route = new Zend_Controller_Router_Route(
	        'step2/:action/:project_id',
	        array(
	            'module' => 'default',
	            'controller' => 'step2',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $step3Route = new Zend_Controller_Router_Route(
	        'step3/:action/:project_id',
	        array(
	            'module' => 'default',
	            'controller' => 'step3',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $step4Route = new Zend_Controller_Router_Route(
	        'step4/:action/:project_id',
	        array(
	            'module' => 'default',
	            'controller' => 'step4',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $step5Route = new Zend_Controller_Router_Route(
	        'step5/:action/:project_id',
	         array(
				'module' => 'default',
	            'controller' => 'step5',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );

	    $reportRoute = new Zend_Controller_Router_Route(
	        'report/:action/:project_id',
	         array(
				'module' => 'default',
	            'controller' => 'report',
	            'action' => 'index',
	        	'project_id' => '',
	        )
	    );
	    
	     $adminRoute = new Zend_Controller_Router_Route(
	        'admin/:action/',
	         array(
				'module' => 'default',
	            'controller' => 'admin',
	            'action' => 'index',	        	
	        )
	    );

	    $router->addRoute('defaultRoute', $defaultRoute);
	    $router->addRoute('accountRoute', $accountRoute);
	    $router->addRoute('accountIdRoute', $accountIdRoute);
	    $router->addRoute('accountListRoute', $accountListRoute);
	    $router->addRoute('accountRegisterRoute', $accountRegisterRoute);
	    $router->addRoute('accountForgotPswdRoute', $accountForgotPswdRoute);
	    $router->addRoute('profileRoute', $profileRoute);
	    $router->addRoute('profileListRoute', $profileListRoute);
	    $router->addRoute('bugRoute', $bugRoute);
	    $router->addRoute('bugListRoute', $bugListRoute);
	    $router->addRoute('projectRoute', $projectRoute);
	    $router->addRoute('projectIdRoute', $projectIdRoute);
	    $router->addRoute('projectPublicRoute', $projectPublicRoute);
	    $router->addRoute('projectsEvaluatedRoute', $projectsEvaluatedRoute);
	    $router->addRoute('step1Route', $step1Route);
	    $router->addRoute('step2Route', $step2Route);
	    $router->addRoute('step3Route', $step3Route);
	    $router->addRoute('step4Route', $step4Route);
	    $router->addRoute('step5Route', $step5Route);
	    $router->addRoute('reportRoute', $reportRoute);
	    $router->addRoute('adminRoute', $adminRoute);
	}

	protected function _initLanguages() 
	{
		Zend_Controller_Front::getInstance()->registerPlugin(new GSD_Controller_Plugin_Language());
	}

	/**
	 * [_initTranslation description]
	 * @return [type] [description]
	 */
	protected function _initTranslation()
	{		
	    $translator = new Zend_Translate(array(
	    	'adapter' => 'array',
	    	'content' => APPLICATION_PATH . '/resources/languages',
	    	'locale' => 'es',
	    	'scan' => Zend_Translate::LOCALE_DIRECTORY)
		);
				
		Zend_Form::setDefaultTranslator($translator);
	}

	/**
	 * [_initDbconn description]
	 * @return [type] [description]
	 */
	protected function _initDbconn()
	{
		$resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        return $db;
    }

    /*********************************************************/
	/* CREATE & POPULATE MATERIALS TABLE FOR STEP 4 		 */
	/* =hce_db_materials_table() from H2C 		             */
	/* =hce_db_materials_table_populate() from H2C           */
	/*********************************************************/
	function _initDbMaterialsTable() 
	{
		
		$table_name = 's_4' . "_materials"; 
		$tableExists = true;

		$db = $this->_initDbconn();				
		
		try {
			$result = $db->describeTable($table_name); //throws exception
			if (empty($result)) $tableExists = 0;
			else return;
		} catch ( Exception $e ) {
			$tableExists = 0;
	    }

		if (!$tableExists) {	
			$sql = "
				CREATE TABLE $table_name (
				  id bigint(20) unsigned NOT NULL auto_increment,
				  material_code varchar(12) NOT NULL default '',
				  material_name varchar(100) NOT NULL default '',
				  material_unit varchar(10) NOT NULL default '',
				  material_mass float(10,5) NOT NULL default 0,
				  component_1 varchar(100) NOT NULL default '',
				  component_1_mass float(10,5) NOT NULL default 0,
				  component_2 varchar(100) NOT NULL default '',
				  component_2_mass float(10,5) NOT NULL default 0,
				  component_3 varchar(100) NOT NULL default '',
				  component_3_mass float(10,5) NOT NULL default 0,
				  dap_factor float(10,5) NOT NULL default 0,
				  PRIMARY KEY  (id)
				);
			";
			$db->query($sql);	
		}
	} // end create materials table in DB

	function _initDbMaterialsTablePopulate() {

		if ( Zend_Registry::get('config')->materials->upload ) {						
			// data file
			$filename = Zend_Registry::get('config')->paths->backend->data . "/materiales.simples.csv"; // relative path to data filename
			$line_length = "4096"; // max line lengh (increase in case you have longer lines than 1024 characters)
			$delimiter = ","; // field delimiter character
			$enclosure = '"'; // field enclosure character
			
			// open the data file
			$fp = fopen($filename, 'r');

			if ( $fp !== FALSE ) { // if the file exists and is readable
			
				$table = 's_4' . '_materials';
				$db = $this->_initDbconn();
				$db->query( "TRUNCATE TABLE `$table`" );

				$line = 0;	
				$pattern = '/(\d+),(\d+)/'; // to convert coma to period in numbers
				$replacement = '$1.$2';				
				$inserts = array();
				while ( ($fp_csv = fgetcsv($fp, $line_length, $delimiter, $enclosure)) !== FALSE ) { // begin main loop
					if ( $line == 0 ) { /* check version */ } 
					elseif ( $line == 1 ) { /* csv file headers */ }
					else {
						// preparing data to insert
						$material_code = $fp_csv[0];
						if ( $material_code != '' ) {
							$material_mass = preg_replace($pattern, $replacement, $fp_csv[9]);
							$material_mass = round($material_mass, 5);
							$component1_mass = preg_replace($pattern, $replacement, $fp_csv[6]);
							$component1_mass = round($component1_mass, 5);
							$component2_mass = preg_replace($pattern, $replacement, $fp_csv[7]);
							$component2_mass = round($component2_mass, 5);
							$component3_mass = preg_replace($pattern, $replacement, $fp_csv[8]);
							$component3_mass = round($component3_mass, 5);
							$dap_factor = preg_replace($pattern, $replacement, $fp_csv[10]);
							$dap_factor = round($dap_factor, 5);
							$material_name = $fp_csv[2];
							$material_unit = $fp_csv[1];
							$component1 = $fp_csv[3];
							$component2 = $fp_csv[4];
							$component3 = $fp_csv[5];
									
							$data = array(
									//'id' => is autoincrement
									'material_code' => $material_code,
									'material_name' => $material_name,									
									'material_unit' => $material_unit,
									'material_mass' => $material_mass,
									'component_1' => $component1,
									'component_1_mass' => $component1_mass,
									'component_2' => $component2,
									'component_2_mass' => $component2_mass,
									'component_3' => $component3,
									'component_3_mass' => $component3_mass,
									'dap_factor' => $dap_factor
								);										
				
							$db->insert( $table, $data );

						} // end if material code exists
					} // end if not line 0
					$line++;
				} // end main loop
				fclose($fp);															
			} else { // if data file do not exist
				echo "<h2>Error</h2>
					<p>File with contents not found or not accesible.</p>
					<p>Check the path: " . $csv_filename . ". Maybe it has to be absolute...</p>";
			} // end if file exist and is readable
		}
	} // end populate emissions table

	/************************************************/
	/* CREATE & POPULATE EMISSIONS TABLE FOR STEP 4 */
	/* =hce_db_emissions_table() from H2C           */
	/* =hce_db_emissions_table_populate() from H2C  */
	/************************************************/
	protected function _initDbEmissionsTable()
	{				
		$table_name = 's_4' . '_emissions'; 
		$tableExists = true;

		$db = $this->_initDbconn();				
		
		try {
			$result = $db->describeTable($table_name); //throws exception
			if (empty($result)) $tableExists = 0;
			else return;
		} catch ( Exception $e ) {
			$tableExists = 0;
	    }

		if (!$tableExists) {	
			$sql = "
				CREATE TABLE $table_name (
				  id bigint(20) unsigned NOT NULL auto_increment,
				  opendap_code char(7) NOT NULL default '0000000',
				  type varchar(200) NOT NULL default '',
				  subtype varchar(200) NOT NULL default '',
				  emission_factor float(10,5) NOT NULL default 0,
				  PRIMARY KEY  (id)
				);
			";	
			$db->query($sql);	
		}		
	}

	protected function _initDbEmissionsTablePopulate()
	{
		if ( Zend_Registry::get('config')->emissions->upload ) {
			// data file
			$filename = Zend_Registry::get('config')->paths->backend->data . "/opendap.csv"; // relative path to data filename
			$line_length = "4096"; // max line lengh (increase in case you have longer lines than 1024 characters)
			$delimiter = ","; // field delimiter character
			$enclosure = '"'; // field enclosure character
			
			// open the data file
			$fp = fopen($filename, 'r');

			if ( $fp !== FALSE ) { // if the file exists and is readable
			
				$table = 's_4' . '_emissions'; 
				$db = $this->_initDbconn();
				$db->query( "TRUNCATE TABLE `$table`" );				
				$line = 0;
				// to convert coma to period in numbers
				$pattern = '/(\d+),(\d+)/';
				$replacement = '$1.$2';
				while (($fp_csv = fgetcsv($fp, $line_length, $delimiter, $enclosure)) !== FALSE ) { // begin main loop
					if ( $line == 0 ) { /* check version */ } 
					elseif ( $line == 1 ) { /* csv file headers */ }
					else {
						// preparing data to insert
						$opendap_code = $fp_csv[2];
						$emission_factor = preg_replace($pattern, $replacement, $fp_csv[3]);
						$emission_factor = round($emission_factor, 5);
						$data = array(
							//'id' => is autoincrement
							'opendap_code' => $opendap_code,
							'type' => $fp_csv[0],
							'subtype' => $fp_csv[1],
							'emission_factor' => $emission_factor
						);
						/* create row */ $db->insert( $table, $data );

					} // end if not line 0
					$line++;
				} // end main loop
				fclose($fp);
			} else { // if data file do not exist
				echo "<h2>Error</h2>
					<p>File with contents not found or not accesible.</p>
					<p>Check the path: " . $csv_filename. ". Maybe it has to be absolute...</p>";
			} // end if file exist and is readable
		}
	}	

	/*protected function _initEmail()
	{
		$emailConfig = array(
			'auth' => 'login',
			'username' => Zend_Registry::get('config')->email->username,
			'password' => Zend_Registry::get('config')->email->password,
			'ssl' => Zend_Registry::get('config')->email->protocol,
			'port' => Zend_Registry::get('config')->email->port
		);

		$mailTransport = new Zend_Mail_Transport_Smtp(Zend_Registry::get('config')->email->server, $emailConfig);

		Zend_Mail::setDefaultTransport($mailTransport);
	}*/

	/*protected function _initDbCaches(){
		//$this->_logger->info('Bootstrap ' . __METHOD__);
		if('development' == $this->getEnvironment()){
			$frontendOptions = array(
				'automatic_serialization' => true
			);

			$cache = Zend_Cache::factory('Core', 'XCache', $frontendOptions);

			Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
		}
	}*/
}