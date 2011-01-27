<?php
/**
 * Magento Adminhtml Index Controller tests
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
 * Mage_Adminhtml_IndexControllerTest
 *
 * @package    Mage_Adminhtml
 * @subpackage Mage_Adminhtml_Test
 *
 *
 * @uses Ibuildings_Mage_Test_PHPUnit_ControllerTestCase
 */
class Mage_Adminhtml_IndexControllerTest extends Mage_Adminhtml_ControllerTestCase {

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
     * theIndexActionDisplaysLoginForm
     * @author Alistair Stead
     * @group login
     * @test
     */
    public function theIndexActionDisplaysLoginForm()
    {
        $this->dispatch('admin/index/');
        
        $this->assertQueryCount('form#loginForm', 1);
    } // theIndexActionDisplaysLoginForm
    
    /**
     * submittingInvalidCredsShouldDisplayError
     * @author Alistair Stead
     * @group login
     * @test
     */
    public function submittingInvalidCredsShouldDisplayError()
    {
        $this->login('invalid', 'invalid');
        
        $this->assertQueryCount('li.error-msg', 1);
        $this->assertQueryContentContains('li.error-msg', 'Invalid Username or Password.');
    } // submittingInvalidCredsShouldDisplayError
    
    /**
     * submittingValidCredsShouldDisplayDashboard
     * @author Alistair Stead
     * @group login
     * @test
     */
    public function submittingValidCredsShouldDisplayDashboard()
    {
        $this->login();

        $this->assertRedirect('We should be redirected after login');
        $this->assertRedirectRegex("/^.*dashboard.*$/", 'We are not directed to the dashboard');      
    } // submittingValidCredsShouldDisplayDashboard
    
    
    /**
     * theForgotPasswordActionShouldDisplayFrom
     * @author Alistair Stead
     * @group password
     * @test
     */
    public function theForgotPasswordActionShouldDisplayFrom()
    {
        $this->dispatch('admin/index/forgotpassword/');
        
        // The forgot password form is the same as the login
        $this->assertQueryCount('form#loginForm', 1);
        $this->assertQueryCount('div.forgot-password', 1);
        $this->assertQueryContentContains('h2', 'Forgot your user name or password?');
    } // theForgotPasswordActionShouldDisplayFrom
    
    /**
     * submittingForgotPasswordWithInvalidEmailReturnsError
     * @author Alistair Stead
     * @group password
     * @test
     */
    public function submittingForgotPasswordWithInvalidEmailReturnsError()
    {
        $this->request->setMethod('POST')
            ->setPost(array('email' => 'invalid'));
            
        $this->dispatch('admin/index/forgotpassword/');
        
        $this->assertQueryCount('li.error-msg', 1);
        $this->assertQueryContentContains('li.error-msg', 'Cannot find the email address.');
    } // submittingForgotPasswordWithInvalidEmailReturnsError
    
    /**
     * submittingForgotPasswordWithValidEmailReturnsSuccess
     * @author Alistair Stead
     * @group password
     * @test
     * 
     */
    public function submittingForgotPasswordWithValidEmailReturnsSuccess()
    {
        $this->request->setMethod('POST')
            ->setPost(array('email' => $this->email));
            
        $this->dispatch('admin/index/forgotpassword/');
        
        $this->assertQueryCount('li.success-msg', 1);
        $this->assertQueryContentContains('li.success-msg', 'A new password was sent to your email address. Please check your email and click Back to Login.');
        // Test that the email contains the correct data
        $emailContent = $this->getResponseEmail()
                            ->getBodyHtml()
                            ->getContent();
        // Overriding the response body to be able to use the standard content assertions
        $this->response->setBody($emailContent);
        
        // The email content addresses the fixture user
        $this->assertQueryContentContains('body', "Dear $this->firstName $this->lastName");
        // The fixture users password has been changed
        $this->assertNotQueryContentContains('body', $this->password);
    } // submittingForgotPasswordWithValidEmailReturnsSuccess
    
    
    
}