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
     * indexActionShouldRedirectWithEmptyQuery
     * @author Alistair Stead
     * @test
     */
    public function indexActionShouldRedirectWithEmptyQuery()
    {
        $this->request->setMethod('POST')
            ->setPost(array('q' => ''));
            
        $this->dispatch('catalogsearch/result/index');
        $this->assertResponseCode('302', "The result action deos not redirect with emty query");
    } // indexActionShouldRedirectWithEmptyQuery
    
}