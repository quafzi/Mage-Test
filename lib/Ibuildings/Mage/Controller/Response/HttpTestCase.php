<?php

class Ibuildings_Mage_Controller_Response_HttpTestCase
    extends Zend_Controller_Response_HttpTestCase
{
    /**
     * Fixes CGI only one Status header allowed bug
     *
     * @link  http://bugs.php.net/bug.php?id=36705
     *
     */
    public function sendHeaders()
    {
        if (!$this->canSendHeaders()) {
            Mage::log('HEADERS ALREADY SENT: '.mageDebugBacktrace(true, true, true));
            return $this;
        }

        if (substr(php_sapi_name(), 0, 3) == 'cgi') {
            $statusSent = false;
            foreach ($this->_headersRaw as $i=>$header) {
                if (stripos($header, 'status:')===0) {
                    if ($statusSent) {
                        unset($this->_headersRaw[$i]);
                    } else {
                        $statusSent = true;
                    }
                }
            }
            foreach ($this->_headers as $i=>$header) {
                if (strcasecmp($header['name'], 'status')===0) {
                    if ($statusSent) {
                        unset($this->_headers[$i]);
                    } else {
                        $statusSent = true;
                    }
                }
            }
        }
        
        parent::sendHeaders();
    }
    
	public function sendResponse()
    {
        Mage::dispatchEvent('http_response_send_before', array('response'=>$this));
        parent::sendResponse();
    }
}