<?php
/**
 * Magento Customer AccountController tests
 *
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Customer_AccountControllerTest
 *
 * @package    Mage_Customer
 * @subpackage Mage_Customer_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Customer_AccountControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * indexActionIsSecureAndRequiresLogin
     * @author Alistair Stead
     * @test
     */
    public function indexActionIsSecureAndRequiresLogin()
    {
        $this->dispatch('customer/account/index');
    } // indexActionIsSecureAndRequiresLogin
    
    /**
     * indexActionReturnsDashboardToLoggedInUser
     * @author Alistair Stead
     * @test
     */
    public function indexActionReturnsDashboardToLoggedInUser()
    {
        // Log in with the fixtures user
        $this->_login();
        // Attempt to access the account page
        $this->dispatch('customer/account/index');
    } // indexActionReturnsDashboardToLoggedInUser
    
    
    /**
     * Internal helper method to streamline the process of user login
     *
     * @return void
     * @author Alistair Stead
     **/
    protected function _login($username, $password)
    {
        // TODO add method body
    }
}