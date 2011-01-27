<?php

class TemplateTest extends PHPUnit_Framework_TestCase
{    
    /**
     * Setup fixtures and dependencies
     *
     * @return void
     * @author Alistair Stead
     **/
    public function setUp()
    {
        parent::setUp();
        // Bootstrap Mage in the same way as during testing
        $stub = $this->getMockForAbstractClass('Ibuildings_Mage_Test_PHPUnit_ControllerTestCase');
        $stub->mageBootstrap();
    }
    
    /**
     * Tear down fixtures and dependencies
     *
     * @return void
     * @author Alistair Stead
     **/
    public function tearDown()
    {
        parent::tearDown();
        Mage::reset();
    }
    
    /**
     * testingEmailTemplateModelShouldBeReturned
     * @author Alistair Stead
     * @test
     */
    public function testingEmailTemplateModelShouldBeReturned()
    {
        $this->assertInstanceOf(
            'Ibuildings_Test_Model_Email_Template',
            Mage::getModel('core/email_template'),
            "Ibuildings_Test_Model_Email_Template was not returned as expected"
        );
    } // testingEmailTemplateModelShouldBeReturned
}