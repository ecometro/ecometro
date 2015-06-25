<?php
/**
* This class loads the cms skin
*
*/
class Zend_View_Helper_LoadSkin extends Zend_View_Helper_Abstract
{
	/**
	 * [loadSkin description]
	 * @param  [type] $skin [description]
	 * @return [type]       [description]
	 */
	public function loadSkin($skin)
	{
		// load the skin config file
		$skinData = new Zend_Config_Xml('./skins/' . $skin . '/skin.xml');
		$stylesheets = $skinData->stylesheets->stylesheet->toArray();
		// append each stylesheet
		if (is_array($stylesheets)) {
			foreach ($stylesheets as $stylesheet) {
				$this->view->headLink()->appendStylesheet(Zend_Controller_Front::getInstance()->getBaseUrl() . '/skins/' . $skin . '/css/' . $stylesheet);
			}
		}
	}
}