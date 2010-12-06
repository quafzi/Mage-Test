<?php
/**
 * Magento PHPUnit TestCase
 *
 * @package    Ibuildings_Mage_Test_PHPUnit
 * @copyright  Copyright (c) 2010 Ibuildings
 * @author  Alistair Stead
 * @version    $Id$
 */

/**
 * Functional testing scaffold for Magento applications
 *
 *
 * @uses       Zend_Test_PHPUnit_ControllerTestCase
 */
abstract class Ibuildings_Mage_Test_PHPUnit_ControllerTestCase
   extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    /**
     * Internal member variable that will be used to define which store will be used
     *
     * @var string
     **/
    protected $mageRunCode = '';
    
    /**
     * Internal member variabe that will be used to define if it is a store or the admin that will run
     *
     * @var string
     **/
    protected $mageRunType = 'store';
    
    /**
     * Internal member variable that will hold the additional options passed to Mage::app()
     *
     * @var array
     **/
    protected $options = array();
    
    /**
     * Internal member variable that will hold any email generated
     * during the request / response with the controller
     *
     * @var Zend_Mail
     **/
    protected $_mail;
    
    /**
     * Overloading: prevent overloading to special properties
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (in_array($name, array('request', 'response', 'frontController'))) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception(sprintf('Setting %s object manually is not allowed', $name));
        }
        $this->$name = $value;
    }

    /**
     * Overloading for common properties
     *
     * Provides overloading for request, response, responseMail and frontController objects.
     *
     * @param mixed $name
     * @return void
     */
    public function __get($name)
    {
        switch ($name) {
            case 'request':
                return $this->getRequest();
            case 'response':
                return $this->getResponse();
            case 'responseMail':
                return $this->getResponseMail();
            case 'frontController':
                return $this->getFrontController();
        }

        return null;
    }

    /**
     * Set up Magento app
     *
     * Calls {@link mageBootstrap()} by default
     *
     * @return void
     */
    protected function setUp()
    {
        $this->mageBootstrap();
    }
    
    /**
     * Teardown the modifications to the Mage App and Config
     *
     * @return void
     * @author Alistair Stead
     **/
    protected function tearDown()
    {
        Mage::getConfig()->reinit();
    }

    /**
     * Boostrap the Mage application in a similar way to the procedure
     * of index.php
     * 
     * Then sets test case request and response objects in Mage_Core_App,
     * and disables returning the response.
     *
     * @return void
     * @author Alistair Stead
     */
    public function mageBootstrap()
    {
        Mage::reset();
        if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
            Mage::setIsDeveloperMode(true);
        }
        // Store or website code
        $this->mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';

        // Run store or run website
        $this->mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
        
        // Initialize the Mage App and inject the testing request & response
        Mage::app($this->mageRunCode, $this->mageRunType, $this->options);
        Mage::app()->setRequest(new Ibuildings_Mage_Controller_Request_HttpTestCase);
        Mage::app()->setResponse(new Ibuildings_Mage_Controller_Response_HttpTestCase);
        
        // Rewrite the core classes at runtime to prevent emails from being sent
        Mage::getConfig()->setNode('global/models/core/rewrite/email_template', 'Ibuildings_Test_Model_Email_Template');
        // This is a hack to get the runtime config changes to take effect
        Mage::getModel('core/email_template');
    }

    /**
     * Dispatch the Mage request
     *
     * If a URL is provided, sets it as the request URI in the request object.
     * Dispatches the application request.
     *
     * @param  string|null $url
     * @return void
     */
    public function dispatch($url = null)
    {
        $request = $this->getRequest();
        if (null !== $url) {
            $request->setRequestUri($url);
        }
        $request->setPathInfo(null);
        
        Mage::app()->run(array(
            'scope_code' => $this->mageRunCode,
            'scope_type' => $this->mageRunType,
            'options'    => $this->options,
        ));
    }

    /**
     * Reset Mage state
     *
     * Creates new request/response objects, resets Mage and globals
     * instance, and resets the action helper broker.
     *
     * @return void
     */
    public function reset()
    {
        $_GET     = array();
        $_POST    = array();
        $this->resetRequest();
        $this->resetResponse();
        $this->resetResponseMail();
        $this->mageBootstrap();
    }
    
    /**
     * Reset the browser session and cookies
     *
     * @return void
     * @author Alistair Stead
     **/
    public function resetSession()
    {
        $_SESSION = array();
        $_COOKIE = array();
    }

    /**
     * Retrieve front controller instance
     *
     * @return Zend_Controller_Front
     */
    public function getFrontController()
    {
        if (null === $this->_frontController) {
            $this->_frontController = Mage::app()->getFrontController();
        }
        
        return $this->_frontController;
    }

    /**
     * Retrieve test case request object
     *
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest()
    {
        if (null === $this->_request) {
            $this->_request = Mage::app()->getRequest();
        }
        return $this->_request;
    }

    /**
     * Retrieve test case response object
     *
     * @return Zend_Controller_Response_Abstract
     */
    public function getResponse()
    {
        if (null === $this->_response) {
            $this->_response = Mage::app()->getResponse();
        }
        return $this->_response;
    }
    
    /**
     * Retrieve any emails that would have been sent
     * by Magento during execution of the request
     *
     * @return Zend_Mail
     * @author Alistair Stead
     **/
    public function getResponseEmail()
    {
        if (null === $this->_mail) {
            $this->_mail = Mage::app()->getResponseEmail();
        }
        return $this->_mail;
    }
    
    /**
     * Reset the responseMail generated during the request & response
     *
     * @return void
     * @author Alistair Stead
     **/
    public function resetResponseMail()
    {
        $this->_mail = null;
    }
    
    /**
     * Reset the request object
     *
     * Useful for test cases that need to test multiple trips to the server.
     *
     * @return Zend_Test_PHPUnit_ControllerTestCase
     */
    public function resetRequest()
    {
        if ($this->request instanceof Ibuildings_Mage_Controller_Request_HttpTestCase) {
            $this->request->clearQuery()
                           ->clearPost();
        }
        $this->_request = null;
        return $this;
    }

    /**
     * Reset the response object
     *
     * Useful for test cases that need to test multiple trips to the server.
     *
     * @return Zend_Test_PHPUnit_ControllerTestCase
     */
    public function resetResponse()
    {
        // $this->response->clearAllHeaders();
        // $this->response->clearBody();
        $this->_resetPlaceholders();
        $this->_request = null;
        return $this;
    }
    
    /**
     * Assert that the specified route was used
     *
     * @param  string $route
     * @param  string $message
     * @return void
     */
    public function assertRoute($route, $message = '')
    {
        $this->_incrementAssertionCount();
        if ($route != $this->getRequest()->getRequestedRouteName()) {
            $msg = sprintf('Failed asserting matched route was "%s", actual route is %s',
                $route,
                $this->getRequest()->getRequestedRouteName()
            );
            if (!empty($message)) {
                $msg = $message . "\n" . $msg;
            }
            $this->fail($msg);
        }
    }
    
    /**
     * Assert that the route matched is NOT as specified
     *
     * @param  string $route
     * @param  string $message
     * @return void
     */
    public function assertNotRoute($route, $message = '')
    {
        $this->_incrementAssertionCount();
        if ($route == $this->getRequest()->getRequestedRouteName()) {
            $msg = sprintf('Failed asserting route matched was NOT "%s"', $route);
            if (!empty($message)) {
                $msg = $message . "\n" . $msg;
            }
            $this->fail($msg);
        }
    }
}
