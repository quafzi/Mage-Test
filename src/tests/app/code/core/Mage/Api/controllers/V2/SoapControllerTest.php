<?php
/**
 * Magento API V2 Soap Controller tests
 *
 * @package    Mage_Api
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Api_V2_SoapControllerTest
 *
 * @package    Mage_Api
 * @subpackage Mage_Api_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Api_V2_SoapControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {
    
    /**
     * theFullAPIV2RouteUsesV2SoapController
     * @author Alistair Stead
     * @test
     */
    public function theFullAPIV2RouteUsesV2SoapController()
    {
        $this->dispatch('api/v2_soap?wsdl=1');
        
        $this->assertAction('index', "The index action is not used");
        $this->assertController('v2_soap', "The expected controller is not been used");
        
        $this->assertHeaderContains('Content-Type', 'text/xml', "The Content-Type header is not text/xml as expected");
    } // theFullAPIV2RouteUsesV2SoapController
    

}