<?php
/**
 * Documentation Block Here
 */
class Zend_Controller_Action_Helper_GenerateID extends Zend_Controller_Action_Helper_Abstract
{	
    /**
     * Returns random 32 character long string 
     * @return string random 32 character long string
     */
    public function getGenerateID()
    {
    	return md5(uniqid(mt_rand(), true));
    }
    
	/**
     * Strategy pattern: call helper as broker method
     *
     * @return string random 32 character long string
     */       
    public function direct()
    {
        return $this->getGenerateID();
    }
}