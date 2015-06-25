<?php 
/**
* Outputs success messages using a uniform format
*
*/
class Zend_View_Helper_SuccessMessages extends Zend_View_Helper_Abstract
{

    /**
     * Outputs errors using a uniform format
     * @param array $errors [description]
     */
    public function successMessages($messages)
    {
    	if ($messages) {
    		echo "<div id='flash'>";
        		echo "<ul>";
        		foreach($messages as $message) {        			
        			printf("<li>%s</li>", $message);        			
        		}
        		echo "</ul>";
    		echo "</div>";
    	}
    }
}