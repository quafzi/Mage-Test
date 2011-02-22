<?php
/**
 * Magento CatalogSearch ResultController tests
 *
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_CatalogSearch_ResultControllerTest
 *
 * @package    Mage_CatalogSearch
 * @subpackage Mage_CatalogSearch_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_CatalogSearch_ResultControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * indexActionShouldDisplayMessageWithEmptyQuery
     * @author Alistair Stead
     * @test
     */
    public function indexActionShouldDisplayMessageWithEmptyQuery()
    {
        $this->request->setMethod('POST')
            ->setPost(array('q' => ''));
            
        $this->dispatch('catalogsearch/result/index');
        
        $this->assertResponseCode('200', "The response code is not 200");
        $this->assertContains(Mage::helper('catalogSearch')->__('Minimum Search query length is %s', Mage::getStoreConfig('catalog/search/min_query_length')), $this->response->getBody());
    } // indexActionShouldDisplayMessageWithEmptyQuery
    
    
}