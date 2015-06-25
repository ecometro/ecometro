<?php 
/**
* Outputs error messages using a uniform format
*
*/
class Zend_View_Helper_ErrorMessages extends Zend_View_Helper_Abstract
{
    /**
     * Outputs errors using a uniform format
     * @param array $errors [description]
     */
    public function errorMessages($errors)
    {
    	if ($errors) {
    		echo "<div id='errors'>";
        		echo "<ul>";
        		foreach($errors as $error) {        			
        			printf("<li>%s</li>", $error);        			
        		}
        		echo "</ul>";
    		echo "</div>";
    	}
    }
}