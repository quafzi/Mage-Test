<?php
/**
 * Magento Cms Index Controller tests
 *
 * @package    Mage_Cms
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Cms_IndexControllerTest
 *
 * @package    Mage_Cms
 * @subpackage Mage_Cms_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Cms_IndexControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * noRouteShouldSet404Header
     * @author Alistair Stead
     * @test
     */
    public function noRouteShouldSet404Header()
    {
        $this->dispatch('/cms/defaultIndex');
        
        $this->assertRoute('cms', "The expected cms route has not been matched");
        $this->assertController('index', "The expected controller is not been used");
        $this->assertAction('noRoute', "The login form should be presented");
        
        // TODO review the response header functionality and redirects
        // $this->assertResponseCode('404', 'A 404 has not been returned for a non existent page');
    } // noRouteShouldSet404Header
    
}