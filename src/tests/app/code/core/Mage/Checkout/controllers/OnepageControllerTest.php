<?php
/**
 * Magento Checkout OnepageControllerTest tests
 *
 * @author     Thomas Kappel <thomas.kappel@netresearch.de>
 * @package    Mage_Checkout
 * @version    $Id$
 */

/**
 * Mage_Checkout_OnepageControllerTest
 *
 * @package    Mage_Checkout
 * @subpackage Mage_Checkout_Test
 * @author     Thomas Kappel <thomas.kappel@netresearch.de>
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_Checkout_OnepageControllerTest extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase
{
    /**
     * Member variable that will hold the Category Helper
     *
     * @var Mage_Catalog_Helper_Category
     **/
    protected $_helperCheckout;
    
    /**
     * Variable to remember config values we have to modify during test
     * 
     * @var array
     */
    protected $_origConfigData = array();
    
    /**
     * Setup dependencies for tests
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     * 
     * @return void
     **/
    public function setUp()
    {
        parent::setUp();
        
        $freeshippingPath = 'carriers/freeshipping/active';
        $freeshippingActive = Mage::app()->getStore(0)
            ->getConfig($freeshippingPath);
        if ('1' !== $freeshippingActive) {
            Mage::app()->getStore(0)
                ->setConfig('carriers/freeshipping/active', 1);
            $this->_originalConfigData[] = $freeshippingActive;
        }
        $this->_helperCheckout = Mage::helper('checkout');
    }
    
    /**
     * Reset dependencies
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     *
     * @return void
     **/
    public function tearDown()
    {
        parent::tearDown();
        foreach ($this->_origConfigData as $path=>$value) {
            Mage::app()->getStore(0)
                ->setConfig($path, $value);
        }
        unset(
            $this->_helperCheckout
        );
    }
    
    /**
     * get a salable product of the shop
     * 
     * @param int $offset Offset
     * 
     * @return Mage_Catalog_Model_Product
     */
    public static function getSalableProduct($offset=0)
    {
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        /*$productCollection->addAttributeToFilter(
            'visibility',
            Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH
        );*/
        $productCollection->addAttributeToFilter('type_id', 'simple');
        $productCollection->addAttributeToFilter(
            'status',
            Mage_Catalog_Model_Product_Status::STATUS_ENABLED
        ); 
        Mage::getSingleton('cataloginventory/stock')
            ->addInStockFilterToCollection($productCollection);
        $productIds = $productCollection->getAllIds();
        return Mage::getModel('catalog/product')->load($productIds[$offset]);
    }
    
    /**
     * addProductToCart
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function addProductToCart()
    {
        $productId = self::getSalableProduct()->getId();
        $_COOKIE = array('unittest' => true);
        
        $this->request->setMethod('POST')
            ->setPost(array(
                'qty'     => 1,
                'product' => $productId,
            )
        );
        $this->dispatch('checkout/cart/add');
        $this->assertResponseCode('302');
        
        $this->reset();
        $this->dispatch('checkout/cart/');
        
        $this->assertQuery('.continue_checkout');
        $this->reset();
    }
    
    /**
     * check out
     * 
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     * 
     * @test
     */
    public function checkout()
    {
        $this->addProductToCart();
        $this->dispatch('checkout/onepage/index');
        
        $this->assertQuery('#opc-login');
        $this->assertQuery('#opc-billing');
        $this->assertQuery('#opc-shipping');
        $this->assertQuery('#opc-shipping_method');
        $this->assertQuery('#opc-payment');
        $this->assertQuery('#opc-review');
        $this->reset();
        
        $this->setOpcLogin();
        $this->setOpcBilling();
        $this->setOpcShipping();
        $this->setOpcShippingMethod();
        $this->setOpcPayment();
        $this->setOpcReview();
    }
    
    /**
     * assert that step has a given state
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     * 
     * @param string $step
     */
    protected function assertStepStatus($stepCode, $status='complete')
    {
        $stepData = Mage::getModel('checkout/type_onepage')->getCheckout()
            ->getStepData($stepCode);
        $this->assertTrue(array_key_exists($status, $stepData) && $stepData[$status] == '1');
    }
    
    
    /**
     * set checkout method (login/guest)
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcLogin()
    {
        $this->request->setMethod('POST')
            ->setPost(array(
                'method' => 'guest',
            )
        );
        $this->dispatch('checkout/onepage/saveMethod');
        $json = $this->getResponse()->getBody();
        if (false !== strpos($json, 'error')) {
            $this->fail('error while saving checkout method');
        }
        
        $this->reset();
    }
    /**
     * set billing address
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcBilling()
    {
        $this->request->setMethod('POST')
            ->setPost(array(
                'billing' => array(
                    'gender'     => '1',
                    'firstname'  => 'Homer',
                    'lastname'   => 'Simpson',
                    'street'     => array('742 Evergreen Terrace'),
                    'postcode'   => '12345',
                    'city'       => 'Springfield',
                    'region'     => '',
                    'country_id' => 'US',
                    'telephone'  => '555-0173',
                    'email'      => 'homer.simpson@example.com'
                )
            )
        );
        $this->dispatch('checkout/onepage/saveBilling');
        $json = $this->getResponse()->getBody();
        if (false !== strpos($json, 'error')) {
            $this->fail('error while saving billing');
        }
        $this->assertStepStatus('billing');
        
        $this->reset();
    }
    
    /**
     * set shipping address
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcShipping()
    {
        $this->request->setMethod('POST')
            ->setPost(array(
                'shipping' => array(
                    'gender'     => '1',
                    'firstname'  => 'Ned',
                    'lastname'   => 'Flanders',
                    'street'     => array('740 Evergreen Terrace'),
                    'postcode'   => '12345',
                    'city'       => 'Springfield',
                    'region'     => '',
                    'country_id' => 'US',
                    'telephone'  => '555-0172',
                    'email'      => 'ned.flanders@example.com'
                )
            )
        );
        $this->dispatch('checkout/onepage/saveShipping');
        $json = $this->getResponse()->getBody();
        if (false !== strpos($json, 'error')) {
            $this->fail('error while saving shipping');
        }
        $this->assertStepStatus('shipping');
        
        $this->reset();
    }
    
    /**
     * set shipping method
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcShippingMethod()
    {
        $this->request->setMethod('POST')
            ->setPost(array(
                'shipping_method' => 'freeshipping_freeshipping'
        ));
        $this->dispatch('checkout/onepage/saveShippingMethod');
        $json = $this->getResponse()->getBody();
        if (false !== strpos($json, 'error')) {
            $this->fail('error while saving shipping method');
        }
        $this->assertStepStatus('shipping_method');
        
        $this->reset();
    }
    
    /**
     * set payment method
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcPayment()
    {
        $this->request->setMethod('POST')
            ->setPost(array(
                'payment' => array(
                    'method' => 'checkmo'
        )));
        $this->dispatch('checkout/onepage/savePayment');
        $json = $this->getResponse()->getBody();
        if (false !== strpos($json, 'error')) {
            $this->fail('error while saving payment');
        }
        $this->assertStepStatus('payment');
        
        $this->reset();
        $this->dispatch('checkout/onepage/progress');
        
        $this->reset();
    }
    
    /**
     * review
     *
     * @author Thomas Kappel <thomas.kappel@netresearch.de>
     */
    public function setOpcReview()
    {
        $requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds();
        $agreements = array();
        foreach ($requiredAgreements as $agreementId) {
            $agreements[$agreementId] = '1';
        }
        Mage::getModel('checkout/type_onepage')->getCheckout()->getQuote()
            ->collectTotals();
        
        $this->request->setMethod('POST')
            ->setPost(array(
                'agreement' => $agreements
        ));
        $this->dispatch('checkout/onepage/saveOrder');
        $json = $this->getResponse()->getBody();
        if ('{"success":true,"error":false}' !== $json) {
            Mage::getModel('checkout/type_onepage')->getCheckout()->getStepData('review');
            $this->fail('error while saving order');
        }
        
        $this->reset();
    }
}