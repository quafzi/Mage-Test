<?php

class Ibuildings_Mage_Controller_Response_HttpTestCase
    extends Zend_Controller_Response_HttpTestCase
{
	public function sendResponse()
    {
        Mage::dispatchEvent('http_response_send_before', array('response'=>$this));
        return parent::sendResponse();
    }
}