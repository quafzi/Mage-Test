<?php
/**
 * Magento PHPUnit TestCase
 *
 * @package     Ibuildings_Mage_Test_PHPUnit
 * @copyright   Copyright (c) 2011 Ibuildings. (http://www.ibuildings.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Alistair Stead <alistair@ibuildings.com>
 * @version     $Id$
 */

/**
 * PHPUnit_Framework_Magento_TestCase
 *
 * @category    Mage_Test
 * @package     Ibuildings_Mage_Test_PHPUnit
 * @subpackage  Ibuildings_Mage_Test_PHPUnit_TestCase
 * @uses        PHPUnit_Framework_TestCase
 */
abstract class Ibuildings_Mage_Test_PHPUnit_TestCase extends PHPUnit_Framework_TestCase {

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