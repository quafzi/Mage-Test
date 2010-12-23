<?php
/**
 * Magento Cms Page Controller tests
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
class Mage_Cms_PageControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * theIndexActionShouldRedirectToRoot
     * @author Alistair Stead
     * @test
     */
    public function theIndexActionShouldRedirectToRoot()
    {
        $this->dispatch('/');
        
        $this->assertRoute('cms', "The expected cms route has not been matched");
        $this->assertAction('index', "The login form should be presented");
        $this->assertController('index', "The expected controller is not been used");
        $this->assertQueryContains('div.nav-container', 'The site navigation is not present on the home page');
        
        // TODO We should capture the navigation here to allow us to browse categories and products
        // TODO Store as a member variable that can be used in other tests
    } // theIndexActionShouldRedirectToRoot
}