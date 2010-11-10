<?php
/**
 * Magento PHPUnit TestCase
 *
 * @category   PHPUnit
 * @package    PHPUnit_Framework_Magento
 * @copyright  Copyright (c) 2010 Ibuildings
 * @author  Alistair Stead
 * @version    $Id$
 */

/**
 * Functional testing scaffold for Magento applications
 *
 * @TODO Create an alternate bootstraop method
 * @TODO modify the alternate bootstrap to inject Zend_
 *
 * @uses       Zend_Test_PHPUnit_ControllerTestCase
 */
abstract class PHPUnit_Magento_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    
    /**
     * Internal member variable that will be used to define which store will be used
     *
     * @var string
     **/
    protected $mageRunCode;
    
    /**
     * Internal member variabe that will be used to define if it is a store or the admin that will run
     *
     * @var string
     **/
    protected $mageRunType;
    
    /**
     * Internal member variable that will hold the additional options passed to Mage::app()->run()
     *
     * @var array
     **/
    protected $options = array();
    
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
     * Provides overloading for request, response, and frontController objects.
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
        $this->_setUp();
    }
    
    /**
     * Additional setUp method to anable separation of the test setup methods
     *
     * @return void
     * @author Alistair Stead
     **/
    protected function _setUp()
    {
        // Add test class setup
    }

    /**
     * undocumented function
     *
     * @return void
     * @author Alistair Stead
     */
    public function mageBootstrap()
    {
        $this->reset();
        if (isset($_SERVER['MAGE_IS_DEVELOPER_MODE'])) {
            Mage::setIsDeveloperMode(true);
        }
        
        /* Store or website code */
        $this->mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';

        /* Run store or run website */
        $this->mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
        
        Mage::app($this->mageRunCode, $this->mageRunType, $this->options);
        Mage::app()->setRequest(new Zend_Controller_Request_HttpTestCase);
        Mage::app()->setResponse(new Zend_Controller_Response_HttpTestCase);
    }

    /**
     * Dispatch the Mage request
     *
     * If a URL is provided, sets it as the request URI in the request object.
     * Then sets test case request and response objects in front controller,
     * disables throwing exceptions, and disables returning the response.
     * Finally, dispatches the front controller.
     *
     * @param  string|null $url
     * @return void
     */
    public function dispatch($url = null)
    {
        // redirector should not exit
        // $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        // $redirector->setExit(false);

        // $request    = $this->getRequest();
        // if (null !== $url) {
        //     $request->setRequestUri($url);
        // }
        // $request->setPathInfo(null);
        // 
        // $controller = $this->getFrontController();
        
        var_dump($this->getResponse());exit;
        
        // Mage::app()->run(array(
        //     'scope_code' => $this->mageRunCode,
        //     'scope_type' => $this->mageRunType,
        //     'options'    => $this->options,
        // ));
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
        $_SESSION = array();
        $_GET     = array();
        $_POST    = array();
        $_COOKIE  = array();
        $this->resetRequest();
        $this->resetResponse();
        Mage::reset();
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
}
