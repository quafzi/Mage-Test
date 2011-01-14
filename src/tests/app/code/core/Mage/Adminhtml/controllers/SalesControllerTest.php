<?php
/**
 * Magento Adminhtml Sales Controller tests
 *
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */
 
 /**
  * @see Mage_Adminhtml_ControllerTestCase
  */
require_once 'ControllerTestCase.php';

/**
 * Mage_Adminhtml_SalesControllerTest
 *
 * @package    Mage_Adminhtml
 * @subpackage Mage_Adminhtml_Test
 *
 *
 * @uses Ibuildings_Mage_Test_PHPUnit_ControllerTestCase
 */
class Mage_Adminhtml_SalesControllerTest extends Mage_Adminhtml_ControllerTestCase {

 
    /**
     * indexActionListsOrders
     * @author Alistair Stead
     * @test
     */
    public function indexActionListsOrders()
    {
        $this->login();
        // Reset the requests after login before next dispatch
        $this->reset();
        $this->dispatch('admin/sales_order/index');
        
        $this->assertQueryContentContains('h3.icon-head', 'Orders');
    } // indexActionListsOrders
    
}