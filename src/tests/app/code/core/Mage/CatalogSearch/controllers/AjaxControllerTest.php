<?php
/**
 * Magento CatalogSearch AjaxController tests
 *
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_CatalogSearch_AjaxControllerTest
 *
 * @package    Mage_CatalogSearch
 * @subpackage Mage_CatalogSearch_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_CatalogSearch_AjaxControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * suggestActionReturns200
     * @author Alistair Stead
     * @test
     */
    public function suggestActionReturns200()
    {
        $this->request->setMethod('POST')
            ->setPost(array('q' => 'invalid'));
            
        $this->dispatch('catalogsearch/ajax/suggest');
        $this->assertResponseCode('200', "The suggest action does not return success.");
    } // suggestActionReturns200
    
    /**
     * suggestActionReturnsFormattedHTMLResults
     * @author Alistair Stead
     * @test
     */
    public function suggestActionReturnsFormattedHTMLResults()
    {
        $this->request->setMethod('POST')
            ->setPost(array('q' => 'invalid'));
            
        $this->dispatch('catalogsearch/ajax/suggest');
        
        $this->markTestIncomplete(
                  'This test has not been implemented yet.'
                );
    } // suggestActionReturnsFormattedHTMLResults
    
}