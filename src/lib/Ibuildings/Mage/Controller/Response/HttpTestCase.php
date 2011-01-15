<?php
/**
 * Magento Controller Response HttpTestCase
 *
 * @package     Ibuildings_Mage_Controller
 * @copyright   Copyright (c) 2011 Ibuildings. (http://www.ibuildings.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Alistair Stead <alistair@ibuildings.com>
 * @version     $Id$
 */

/**
 * Ibuildings_Mage_Controller_Response_HttpTestCase
 *
 * @category    Mage_Test
 * @package     Ibuildings_Mage_Controller
 * @subpackage  Ibuildings_Mage_Controller_Response
 * @uses        PHPUnit_Framework_TestCase
 */
class Ibuildings_Mage_Controller_Response_HttpTestCase
    extends Zend_Controller_Response_HttpTestCase
{
	public function sendResponse()
    {
        Mage::dispatchEvent('http_response_send_before', array('response'=>$this));
        return parent::sendResponse();
    }
}