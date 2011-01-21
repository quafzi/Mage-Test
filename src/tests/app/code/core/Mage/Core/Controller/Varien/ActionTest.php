<?php
/**
 * Magento Core Controller Varien Action tests
 *
 * @package    Mage_Core
 * @copyright  Copyright (c) 2010 Ibuildings
 * @version    $Id$
 */

/**
 * Mage_Adminhtml_IndexControllerTest
 *
 * @package    Mage_Catalog
 * @subpackage Mage_Catalog_Test
 *
 *
 * @uses PHPUnit_Framework_Magento_TestCase
 */
class Mage_CoreController_Varien_ActionTests extends Ibuildings_Mage_Test_PHPUnit_ControllerTestCase {
    
    /**
     * undocumented class variable
     *
     * @var string
     **/
    protected $controllerRewrite = <<<HDOC
        <config>
            <modules>
                <Oauth_Customer>
                    <version>0.1.0</version>
                </Oauth_Customer>
            </modules>
            <global>
                <routers>
                    <customer>
                        <rewrite>
                            <account>
                                <to>test/test</to>
                                <override_actions>true</override_actions>
                                <actions>
                                    <login>
                                        <to>test/test/test</to>
                                    </login>
                                </actions>
                            </account>
                        </rewrite>
                    </customer>
                </routers>
            </global>
        </config>
HDOC;

    /**
     * undocumented class variable
     *
     * @var string
     **/
    protected $altControllerRewrite = <<<HDOC
        <config>
            <modules>
                <Ibuildings_Test>
                    <version>0.1.0</version>
                </Ibuildings_Test>
            </modules>
            <frontend>
                <routers>
                    <customer>
                        <args>
                            <modules>
                                <ibuildings_test before="Mage_Customer_AccountController">
                                    Ibuildings_Test_TestController
                                </ibuildings_test>
                            </modules>
                        </args>
                    </customer>
                </routers>
            </frontend>
        </config>
HDOC;
    

    /**
     * controllerRewriteRespectsWhiteSpaceInXMLConfig
     * @author Alistair Stead
     * @test
     */
    public function controllerRewriteRespectsWhiteSpaceInXMLConfig()
    {
        $config = Mage::getConfig()->getNode(); 
        $config->extend(new Varien_Simplexml_Element($this->controllerRewrite));

        $this->dispatch('customer/account/login/');
        
        $this->markTestIncomplete(
                  'This test has not been implemented yet.'
                );
    } // controllerRewriteRespectsWhiteSpaceInXMLConfig
    
}