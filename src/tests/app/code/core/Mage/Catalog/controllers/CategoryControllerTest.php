<?php
/**
 * Magento Catalog Category Controller tests
 *
 * @package    Mage_Catalog
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Catalog_CategoryControllerTest
 *
 * @package    Mage_Catalog
 * @subpackage Mage_Catalog_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Catalog_CategoryControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {
    
    /**
     * Member variable that will hold the Category Helper
     *
     * @var Mage_Catalog_Helper_Category
     **/
    protected $_helperCategory;
    
    /**
     * Setup dependencies for tests
     *
     * @return void
     * @author Alistair Stead
     **/
    public function setUp()
    {
        parent::setUp();
        $this->_helperCategory = Mage::helper('catalog/category');
    }
    
    /**
     * Reset dependencies
     *
     * @return void
     * @author Alistair Stead
     **/
    public function tearDown()
    {
        parent::tearDown();
        unset(
            $this->_helperCategory
        );
    }
    
    /**
     * allCategoryURLsShouldRespond
     * @author Alistair Stead
     * @test
     */
    public function allCategoryURLsShouldRespond()
    {
        $categories = $this->_helperCategory->getStoreCategories(true, true, true);
        
        foreach ($categories as $key => $category) {
            if ($this->_helperCategory->canShow($category) && $category->getIsActive()) {
                // Construct the URL for the category pre dispatch
                $url = str_replace(Mage::getBaseUrl(), '', $this->_helperCategory->getCategoryUrl($category));
                // Dispatch the testing URL
                $this->dispatch($url);
                // Make assertions about the response
                $this->assertRoute('catalog', "The expected category route has not been matched");
                $this->assertAction('view', "The index action has not been called");
                $this->assertController('category', "The expected controller is not been used");
                // Test the the h1 tag is correctly populated with the category name
                $this->assertQueryContentContains(
                    'h1', 
                    $category->getName(), 
                    'The page h1 has not been correctly set'
                );
                // Reset after testing the response
                $this->reset();                
            } 
        }
    } // allCategoryURLsShouldRespond
    
    /**
     * invalidCategoryShouldReturn404
     * @author Alistair Stead
     * @test
     */
    public function invalidCategoryShouldReturn404()
    {
        $this->dispatch('invalid-category.html');
        
        // TODO this should be a 302 redirect followed by a 404 need to 
        // update response to follow redirects like lime in symfony
        // $this->assertResponseCode('404', "The invalid request has not returned 404");
        $this->markTestIncomplete(
                  'This test has not been implemented yet.'
                );
                
    } // invalidCategoryShouldReturn404
}