<?php
/**
* Formulario Acv New Material: Add new material
*/
 class Form_AcvNewMaterialForm extends Zend_Form
 {
 	/**
	* initialize form
	*/
 	public function init()
 	{
 		// set action, id, class and method 		
		$this->setAction(Zend_Layout::getMvcInstance()->getView()->url(array('controller' => 'step4', "action"=>"newmaterial"), 'step4Route'))
			->setAttribs(array( 		  		
 				'id' => 'step4-newmaterial',
 		  		'class' => 'form-horizontal materiales' 				
			))
			->setMethod('post');
 			 		
 		// add element: otras_redes_locales textbox
		$producto = $this->createElement('text', 'producto');
		$producto->setLabel(Zend_Registry::get('Zend_Translate')->translate('Producto/Material'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($producto);
		
		// add element: otras_redes_locales textbox
		$fabricante = $this->createElement('text', 'fabricante');
		$fabricante->setLabel(Zend_Registry::get('Zend_Translate')->translate('Fabricante'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($fabricante);
		
		// add element: origen_del_producto select
		// add element: familia_de_productos_materiales select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$origen_del_producto = $this->createElement('select', 'origen_del_producto');
		$origen_del_producto->setLabel(Zend_Registry::get('Zend_Translate')->translate('Origen del producto'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->addValidators (array ($required))
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_product_origin');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['product_origin'];
					
		$origen_del_producto->addMultiOptions($options);
		$this->addElement($origen_del_producto);
		
		// add element: familia_de_productos_materiales select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    
		$familia_de_productos_materiales = $this->createElement('select', 'familia_de_productos_materiales');
		$familia_de_productos_materiales->setLabel(Zend_Registry::get('Zend_Translate')->translate('Familia de productos/materiales'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addValidators (array ($required))
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
							
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_family_materials');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['family_material'];
			
		$familia_de_productos_materiales->addMultiOptions($options);
		$this->addElement($familia_de_productos_materiales);		
		
		// add element: familia_de_productos select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$familia_de_productos = $this->createElement('select', 'familia_de_productos');
		$familia_de_productos->setLabel(Zend_Registry::get('Zend_Translate')->translate('Familia de productos'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addValidators (array ($required))
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
							
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_family_products');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['family_product'];					
			
		$familia_de_productos->addMultiOptions($options);
		$this->addElement($familia_de_productos);
		
		// add element: informacion_adicional textbox
		$informacion_adicional = $this->createElement('text', 'informacion_adicional');
		$informacion_adicional->setLabel(Zend_Registry::get('Zend_Translate')->translate('Información adicional'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($informacion_adicional);
		
		// add element: cantidad textbox
		$cantidad = $this->createElement('text', 'cantidad');
		$cantidad->setLabel(Zend_Registry::get('Zend_Translate')->translate('Cantidad'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($cantidad);
		
		// add element: unidades select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$unidad = $this->createElement('select', 'unidad');
		$unidad->setLabel(Zend_Registry::get('Zend_Translate')->translate('Unidad'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->addValidators (array ($required))
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_product_unit');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['product_unit'];
			
		$unidad->addMultiOptions($options);
		$this->addElement($unidad);
		
		// add element: densidad textbox
		$densidad = $this->createElement('text', 'densidad');
		$densidad->setLabel(Zend_Registry::get('Zend_Translate')->translate('Densidad (g/cm3)'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($densidad);
		
		// add element: espesor textbox
		$espesor = $this->createElement('text', 'espesor');
		$espesor->setLabel(Zend_Registry::get('Zend_Translate')->translate('Espesor (cm)'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($espesor);
		
		// add element: vida_util textbox
		$vida_util = $this->createElement('text', 'vida_util');
		$vida_util->setLabel(Zend_Registry::get('Zend_Translate')->translate('Vida útil producto (años)'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));							
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($vida_util);
		
		// add element: emplazamiento_fabricante select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$emplazamiento_fabricante = $this->createElement('select', 'emplazamiento_fabricante');
		$emplazamiento_fabricante->setLabel(Zend_Registry::get('Zend_Translate')->translate('Emplazamiento fabricante'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->addValidators (array ($required))
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_product_emplazamiento_fabricante');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['emplazamiento_fabricante'];
			
		$emplazamiento_fabricante->addMultiOptions($options);
		$this->addElement($emplazamiento_fabricante);
		
		// add element: distancia_distribuidor textbox
		$distancia_distribuidor = $this->createElement('text', 'distancia_distribuidor');
		$distancia_distribuidor->setLabel(Zend_Registry::get('Zend_Translate')->translate('Distancia Distribuidor (origen)-Obra (km)'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($distancia_distribuidor);
		
		// add element: tipo_de_transporte select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$tipo_de_transporte = $this->createElement('select', 'tipo_de_transporte');
		$tipo_de_transporte->setLabel(Zend_Registry::get('Zend_Translate')->translate('Tipo de transporte'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->addValidators (array ($required))
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));				

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_product_transport_type');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['transport_type'];
			
		$tipo_de_transporte->addMultiOptions($options);
		$this->addElement($tipo_de_transporte);
		
		// add element: potencial_de_acidificacion textbox
		$potencial_de_acidificacion = $this->createElement('text', 'potencial_de_acidificacion');
		$potencial_de_acidificacion->setLabel(Zend_Registry::get('Zend_Translate')->translate('Potencial de acidificación [kg SO2-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($potencial_de_acidificacion);
		
		// add element: potencial_de_eutrofizacion textbox
		$potencial_de_eutrofizacion = $this->createElement('text', 'potencial_de_eutrofizacion');
		$potencial_de_eutrofizacion->setLabel(Zend_Registry::get('Zend_Translate')->translate('Potencial de eutrofización [kgPO43-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($potencial_de_eutrofizacion);
		
		// add element: potencial_de_calentamiento_global textbox
		$potencial_de_calentamiento_global = $this->createElement('text', 'potencial_de_calentamiento_global');
		$potencial_de_calentamiento_global->setLabel(Zend_Registry::get('Zend_Translate')->translate('Potencial de calentamiento global (100 años) [kg CO2-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($potencial_de_calentamiento_global);
		
		// add element: potencial_de_agotamiento_de_capa_de_ozono textbox
		$potencial_de_agotamiento_de_capa_de_ozono = $this->createElement('text', 'potencial_de_agotamiento_de_capa_de_ozono');
		$potencial_de_agotamiento_de_capa_de_ozono->setLabel(Zend_Registry::get('Zend_Translate')->translate('Potencial de agotamiento de capa de ozono [kg R11-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($potencial_de_agotamiento_de_capa_de_ozono);
		
		// add element: potencial_de_formacion_de_oxidantes_fotoquimicos textbox
		$potencial_de_formacion_de_oxidantes_fotoquimicos = $this->createElement('text', 'potencial_de_formacion_de_oxidantes_fotoquimicos');
		$potencial_de_formacion_de_oxidantes_fotoquimicos->setLabel(Zend_Registry::get('Zend_Translate')->translate('Potencial de formación de oxidantes fotoquímicos [kg C2H4-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($potencial_de_formacion_de_oxidantes_fotoquimicos);
		
		// add element: agotamiento_de_recursos_abioticos textbox
		$agotamiento_de_recursos_abioticos = $this->createElement('text', 'agotamiento_de_recursos_abioticos');
		$agotamiento_de_recursos_abioticos->setLabel(Zend_Registry::get('Zend_Translate')->translate('Agotamiento de recursos abióticos [kg Sb-eq.]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($agotamiento_de_recursos_abioticos);
		
		// add element: consumo_de_energia_primaria_total textbox
		$consumo_de_energia_primaria_total = $this->createElement('text', 'consumo_de_energia_primaria_total');
		$consumo_de_energia_primaria_total->setLabel(Zend_Registry::get('Zend_Translate')->translate('Consumo de energía primaria total [MJ]'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($consumo_de_energia_primaria_total);
		
		// add element: origen_informacion_de_impactos select
		$required = new Zend_Validate_NotEmpty ();
    	$required->setType ($required->getType() | Zend_Validate_NotEmpty::INTEGER | Zend_Validate_NotEmpty::ZERO);
    	
		$origen_informacion_de_impactos = $this->createElement('select', 'origen_informacion_de_impactos');
		$origen_informacion_de_impactos->setLabel(Zend_Registry::get('Zend_Translate')->translate('Origen información de impactos'))
							//->setRequired(true)
							//->setAttrib('size', 30)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->addValidators (array ($required))
							->setAttrib('class', 'arrow')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'))							
							->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$select = $db->select()->from('acv_product_origen_informacion_de_impactos');
		$stmt = $select->query();
		$results = $stmt->fetchAll();		
		
		$options = array( 0 => Zend_Registry::get('Zend_Translate')->translate('Seleccione...'));
		foreach($results as $result)
			$options[$result['id']] = $result['origen_informacion_de_impactos'];
			
		$origen_informacion_de_impactos->addMultiOptions($options);
		$this->addElement($origen_informacion_de_impactos);
		
		// add element: documentacion_adjunta textbox
		$documentacion_adjunta = $this->createElement('text', 'documentacion_adjunta');
		$documentacion_adjunta->setLabel(Zend_Registry::get('Zend_Translate')->translate('Documentación adjunta'))
							//->setRequired(true)
							->addFilter('StripTags')
							->addFilter('HtmlEntities')
							->addFilter('StringTrim')
							->setAttrib('size', 30)
							->setAttrib('class', 'input-large')
							->addDecorator('Label', array('class' => 'control-label'))
							->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'controls'));
							//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'))
		$this->addElement($documentacion_adjunta);
		
		// add element: comentarios textarea
		$comentarios = $this->createElement('textarea', 'comentarios',  array('rows' => '4'));
		$comentarios->addFilter('StripTags')
					->addFilter('HtmlEntities')
					->addFilter('StringTrim');		
					//->setRequired(true);
					//->setAttrib('size', 30);
					//->addErrorMessage(Zend_Registry::get('Zend_Translate')->translate('requerido'));
		$this->addElement($comentarios);
		
		$hash = $this->createElement('hash', 'csrfVerification', array('timeout' => 1800));
		$hash->setSalt(md5(uniqid(rand(), TRUE)))
			 ->removeDecorator('label')
			 ->removeDecorator('htmlTag');		
		$this->addElement($hash);
		
		$this->setElementDecorators(array(
			"ViewHelper",
			"Errors",			
			array('decorator' => array('td' => 'HtmlTag'), 'options' => array('tag' => 'td', 'class' => 'column3')),
			array('Label', array('tag' => 'td', 'tagClass' => 'column2', 'escape' => false)),						
		));
		
		// add element: user_submit_profile submit button
		$submit = $this->createElement('submit', 'submit');
		$submit->setAttrib('class', 'boton red')
				->setLabel(Zend_Registry::get('Zend_Translate')->translate('Guardar'))
				->removeDecorator('DtDdWrapper')
				->removeDecorator('Label');
		$this->addElement($submit);					
		
		// establish the register form view
		$this->setDecorators(array(array('ViewScript',array('viewScript' => 'forms/_form_step_4_acv_new_material.phtml'))));
 	}
 }