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
        $this->dispatch('/non-existant-path/09790-thatwill-never/exist');
        
        $this->assertResponseCode('404', 'A 404 has not been returned for a non existent page');
    } // noRouteShouldSet404Header
    
}