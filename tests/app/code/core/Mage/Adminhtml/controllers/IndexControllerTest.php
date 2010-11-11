<?php
/**
 * Magento Adminhtml Index Controller tests
 *
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Adminhtml_IndexControllerTest
 *
 * @package    Mage_Adminhtml
 * @subpackage Mage_Adminhtml_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Adminhtml_IndexControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {

    /**
     * theAdminRouteAccessesTheAdminApplicationArea
     * @author Alistair Stead
     * @test
     */
    public function theAdminRouteAccessesTheAdminApplicationArea()
    {
        $this->dispatch('admin/');
        
        $this->assertRoute('adminhtml', "The expected route has not been matched");
        $this->assertAction('login', "The login form should be presented");
        $this->assertController('index', "The expected controller is not been used");
    } // theAdminRouteAccessesTheAdminApplicationArea
    
    /**
     * theAdminhtmlIndexControllerLoginActionDisplaysLoginForm
     * @author Alistair Stead
     * @test
     */
    public function theAdminhtmlIndexControllerIndexActionDisplaysLoginForm()
    {
        $this->dispatch('admin/');
        
        $this->assertQueryCount('form#loginForm', 1);
    } // theAdminhtmlIndexControllerLoginActionDisplaysLoginForm
    
    /**
     * submittingTheAdminLoginFormWithInvalidCredsShouldDisplayError
     * @author Alistair Stead
     * @test
     */
    public function submittingTheAdminLoginFormWithInvalidCredsShouldDisplayError()
    {
        $this->request->setMethod('POST')
                              ->setPost(array(
                                  'username' => 'admin',
                                  'password' => 'invalid',
                              ));
                              
        $this->dispatch('admin/');
        
        var_dump($this->response);
        
        $this->assertQueryCount('li.error-msg', 1);
    } // submittingTheAdminLoginFormWithInvalidCredsShouldDisplayError
    
    
    
}