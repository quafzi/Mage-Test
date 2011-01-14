<?php
/**
 * Define the path to the Magento application on the local file system.
 * In order to run tests on the Mage_Test module we need access to Magento
 * it is too big to mock at this point.
 */
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../app'));

require_once APPLICATION_PATH.'/Mage.php';