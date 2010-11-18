# Mage_Test #

This module provides a patched version of Mage_Core enabling you to inject testing dependencies at run time. Due to the functionality of the Varien_Autoloader the local code pool is prioritised over the core. Meaning that any code duplicated from the Mage vendor namespace into the local code pool will be used over the core.

This allows you to build and run functional controller tests in the same way you would with a standard Zend Framework Application using [Zend Test](http://framework.zend.com/manual/en/zend.test.phpunit.html). This mocks the Request and Response objects to that you can query the Response within a suite of tests.

***Warning - This replaces Mage_Core_Model_App for testing purposes***

## Requirements ##

* PHPUnit 5.3+

## Manual Install ##

Clone the module code to your local machine or VM somewhere outside your Magento install but accessible with symlinks.

    git clone git@github.com:ibuildings/Mage_Test.git

Navigate into your Magento base directory and then symlink the following module paths to the matching magento path:
    
    ln -s [PATH]/Mage_Test/Mage app/code/local/Mage
    ln -s [PATH]/Mage_Test/Ibuildings/Test app/code/local/Ibuildings/Test
    ln -s [PATH]/Mage_Test/lib/Ibuildings lib/Ibuildings
    
    
If you want to take advantage of the core tests created as part of this module within your project. You should also symlink the core tests from within the module:

    mkdir -p tests/app/code
    ln -s [PATH]/Mage_Test/tests/app/code/core tests/app/code/core
    
Using symlinks means that you can keep your project code separate to this module yet still pull updates to this module from git. This module is still in development and not all assertions have yet been tested.

Instead of using manually created symlinks you may wish to consider using [Modman (Module-Manager)](http://code.google.com/p/module-manager/) to manage your module installation / management within your Magento project. This can be used in standalone without any SCM integration.

## Magento Functional Testing ##

In order to run functional tests within Magento you will need to setup PHPUnit and all the dependencies. You will then need to create a bootstrap.php file that configures the include path ready for running Magento tests.

    <?php
    // Define path to application directory
    defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));

    require_once APPLICATION_PATH.'/Mage.php';
    
You will also need to setup your phpunit.xml file and define your test suites. The example below includes the core test suite supplied as part of this module if you have symlinked the files.

    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit
        bootstrap="bootstrap.php"
        stopOnFailure="false"
        backupGlobals="true"
        backupStaticAttributes="true"
        colors="true"
        convertErrorsToExceptions="true"
        convertNoticesToExceptions="true"
        convertWarningsToExceptions="true"
        processIsolation="true"
        syntaxCheck="false"
        verbose="true">
        <testsuite name="Core Tests">
            <directory suffix="Test.php">app/code/core</directory>
        </testsuite>
    </phpunit>
    
You can then create your functional test classes that extend Ibuildings_Mage_Test_PHPUnit_ControllerTestCase.

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
    
## Magento Email Functional Testing ##

There are many actions within Magento that will generate transactional emails. In order to test these we need to prevent the email from being sent and capture the Zend_Mail object for making assertions against it. In order to use the standard Zend_Test assertions you can update the response body with the content from the email:

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
    $this->assertQueryContentContains('p strong', "Dear, $this->firstName $this->lastName");
    // The fixture users password has been changed
    $this->assertNotQueryContentContains('p', $this->password);

