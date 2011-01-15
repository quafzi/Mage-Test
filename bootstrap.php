<?php
// Include the patched app to ensure it is not autoloaded 
require_once 'src/app/code/community/Mage/core/Model/App.php';
// Include Magento from the location on your machine
require_once '/mnt/hgfs/Sites/magento.development.local/public/app/Mage.php';  
// Include class dependencies that can not loaded by the autoloader
// when running tests outside a Magento project
require_once 'src/app/code/community/Mage/Core/Controller/Varien/Front.php';
require_once 'src/app/code/community/Mage/Admin/Model/Session.php';
require_once 'src/app/code/community/Ibuildings/Test/Model/Email/Template.php';
// Include the test cases
require_once 'src/lib/Ibuildings/Mage/Controller/Request/HttpTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Controller/Response/HttpTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Test/PHPUnit/ControllerTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Test/PHPUnit/TestCase.php';