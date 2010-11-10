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
 * PHPUnit_Framework_Magento_TestCase
 *
 * @category   PHPUnit
 * @package    PHPUnit_Framework_Magento
 * @subpackage PHPUnit_Framework_Magento_TestCase
 * @uses PHPUnit_Framework_TestCase
 */
class PHPUnit_Magento_TestCase extends PHPUnit_Framework_TestCase {

    /**
     * The Magento store that the tests are being run against
     *
     * @var string
     **/
    protected $store;

    public function setUp() {
        parent::setUp();

        $this->store = Mage::app()->getStore();
    }
}