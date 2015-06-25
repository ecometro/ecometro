<?php 
/**
* This class transforms float values to localized format
*
*/
class Zend_View_Helper_NormalizeToLocalize extends Zend_View_Helper_Abstract
{
	/**
	 * [normalizeToLocalize description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
    function normalizeToLocalize($value) 
    {
    	$filter_es = new Zend_Filter_NormalizedToLocalized();
        return $filter_es->filter($value);
    }
}