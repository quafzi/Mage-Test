<?php
/**
 * Magento CatalogSearch AdvancedController tests
 *
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_CatalogSearch_AdvancedControllerTest
 *
 * @package    Mage_CatalogSearch
 * @subpackage Mage_CatalogSearch_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_CatalogSearch_AdvancedControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {
    
    /**
     * indexActionShouldDisplayForm
     * @author Alistair Stead
     * @test
     */
    public function indexActionShouldDisplayForm()
    {
        $this->dispatch('catalogsearch/advanced/index');
        
        //$this->assertResponseCode('200', "The index action does not return 200");
        $this->assertQuery('form#form-validate', "The advanced search form cannot be found");
    } // indexActionShouldDisplayForm
    
}