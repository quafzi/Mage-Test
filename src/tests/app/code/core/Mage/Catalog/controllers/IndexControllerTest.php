<?php
/**
 * Magento Catalog Index Controller tests
 *
 * @package    Mage_Catalog
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Catalog_IndexControllerTest
 *
 * @package    Mage_Catalog
 * @subpackage Mage_Catalog_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Catalog_IndexControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * theIndexActionShouldRedirectToRoot
     * @author Alistair Stead
     * @test
     */
    public function theIndexActionShouldRedirectToRoot()
    {
        $this->dispatch('/');
        
        $this->assertRoute('cms', "The expected cms route has not been matched");
        $this->assertAction('index', "The index action has not been called");
        $this->assertController('index', "The expected controller is not been used");
        $this->assertQuery('div.nav-container', 'The site navigation is not present on the home page');
        
        $doc = new DomDocument();
        $doc->loadHTML($this->response->getBody());
        
        // TODO We should capture the navigation here to allow us to browse categories and products
        // TODO Store as a member variable that can be used in other tests
    } // theIndexActionShouldRedirectToRoot
}