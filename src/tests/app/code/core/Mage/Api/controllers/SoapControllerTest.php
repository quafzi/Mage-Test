<?php
/**
 * Magento API Soap Controller tests
 *
 * @package    Mage_Api
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Api_SoapControllerTest
 *
 * @package    Mage_Api
 * @subpackage Mage_Api_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Api_SoapControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {
    
    /**
     * theFullAPISoapRouteUsesSoapController
     * @author Alistair Stead
     * @test
     */
    public function theFullAPISoapRouteUsesSoapController()
    {
        $this->dispatch('api/soap?wsdl=1');
        
        $this->assertAction('index', "The index action is not used");
        $this->assertController('soap', "The expected controller is not been used");
        
        $this->assertHeaderContains('Content-Type', 'text/xml', "The Content-Type header is not text/xml as expected");
    } // theFullAPISoapRouteUsesSoapController
}