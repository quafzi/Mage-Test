<?php

class AppTest extends PHPUnit_Framework_TestCase 
{
    /**
     * Member variable that will hold the Magento Application
     *
     * @var Mage_Core_App
     **/
    protected $_app;
    
    /**
     * Setup the dependencies for testing Mage_Core_App
     *
     * @return void
     * @author Alistair Stead
     **/
    public function setUp()
    {
        $this->_app = Mage::app();
    }
    
    /**
     * Tear down the dependencies and reset state
     *
     * @return void
     * @author Alistair Stead
     **/
    public function tearDown()
    {
        unset(
            $this->_app
        );
        Mage::reset();
    }
    
    /**
     * mageCoreAppHasBeenPatched
     * @author Alistair Stead
     * @test
     */
    public function mageCoreAppHasBeenPatched()
    {
        $this->assertInstanceOf(
            'Mage_Core_Model_App', 
            $this->_app, 
            "The application is of the wrong class"
        );
    } // mageCoreAppHasBeenPatched
    
    /**
     * mageCoreAppHasSetRequestMethod
     * @author Alistair Stead
     * @test
     */
    public function mageCoreAppHasSetRequestMethod()
    {
        $this->assertTrue( 
            method_exists($this->_app, 'setRequest'), 
            "The Mage_Core_Model_App does not have a setRequest method"
        );
    } // mageCoreAppHasSetRequestMethod
    
    /**
     * mageCoreAppSetRequestUpdatesInternalRequest
     * @author Alistair Stead
     * @depends mageCoreAppHasSetRequestMethod
     * @test
     */
    public function mageCoreAppSetRequestUpdatesInternalRequest()
    {
        // Inject an alternate request class
        $this->_app->setRequest(new Ibuildings_Mage_Controller_Request_HttpTestCase);
        
        $this->assertInstanceOf(
            'Ibuildings_Mage_Controller_Request_HttpTestCase',
            $this->_app->getRequest(),
            "The wrong request object is returned"
        );
    } // mageCoreAppSetRequestUpdatesInternalRequest
    
    /**
     * mageCoreAppGetRequestStillCreatesDependency
     * @author Alistair Stead
     * @test
     */
    public function mageCoreAppGetRequestStillCreatesDependency()
    {
        $this->assertInstanceOf(
            'Mage_Core_Controller_Request_Http',
            $this->_app->getRequest(),
            "The wrong request object is returned"
        );
    } // mageCoreAppGetRequestStillCreatesDependency
    
    /**
     * mageCoreAppHasSetResponseMethod
     * @author Alistair Stead
     * @test
     */
    public function mageCoreAppHasSetResponseMethod()
    {
        $this->assertTrue( 
            method_exists($this->_app, 'setResponse'), 
            "The Mage_Core_Model_App does not have a setResponse method"
        );
    } // mageCoreAppHasSetResponseMethod
    
    /**
     * mageCoreAppSetResponseUpdatesInternameResponse
     * @author Alistair Stead
     * @depends mageCoreAppHasSetResponseMethod
     * @test
     */
    public function mageCoreAppSetResponseUpdatesInternameResponse()
    {
        // Inject an alternate request class
        $this->_app->setResponse(new Ibuildings_Mage_Controller_Response_HttpTestCase);
        
        $this->assertInstanceOf(
            'Ibuildings_Mage_Controller_Response_HttpTestCase',
            $this->_app->getResponse(),
            "The wrong response object is returned"
        );
    } // mageCoreAppSetResponseUpdatesInternameResponse
    
    /**
     * mageCoreAppGetResponseStillCreatesDependency
     * @author Alistair Stead
     * @test
     */
    public function mageCoreAppGetResponseStillCreatesDependency()
    {
        $this->assertInstanceOf(
            'Mage_Core_Controller_Response_Http',
            $this->_app->getResponse(),
            "The wrong response object is returned"
        );
    } // mageCoreAppGetResponseStillCreatesDependency
    
}