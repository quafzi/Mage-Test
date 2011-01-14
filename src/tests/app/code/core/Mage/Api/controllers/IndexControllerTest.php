<?php
/**
 * Magento API Index Controller tests
 *
 * @package    Mage_Api
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Api_IndexControllerTest
 *
 * @package    Mage_Api
 * @subpackage Mage_Api_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Api_IndexControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * theAPIrouteIsForwardedToAPISoapController
     * @author Alistair Stead
     * @test
     */
    public function theAPIrouteIsForwardedToAPISoapController()
    {
        $this->dispatch('api?wsdl=1');
        
        $this->assertAction('index', "The index action is not used");
        $this->assertController('index', "The expected controller is not been used");
        
        $this->assertModule('api');
        
        $this->assertRoute('api', "The expected route has not been matched");
        $this->assertHeaderContains('Content-Type', 'text/xml', "The Content-Type header is not text/xml as expected");
    } // theAPIrouteIsForwardedToAPISoapController
}