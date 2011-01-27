<?php
// Include class dependencies that can not loaded by the autoloader
// when running tests outside a Magento project
// Include the patched app to ensure it is not autoloaded when we bootstrap Magento
require_once 'src/app/code/community/Mage/core/Model/App.php';
// Include Magento from the location on your machine
// TODO Change to include Mage.php adding it to the include path making to project portable
require_once '/mnt/hgfs/Sites/magento.development.local/public/app/Mage.php';  

require_once 'src/app/code/community/Mage/Admin/Model/Session.php';
require_once 'src/app/code/community/Mage/Core/Controller/Varien/Front.php';
require_once 'src/app/code/community/Ibuildings/Test/Model/Email/Template.php';

// Include the test cases
require_once 'src/lib/Ibuildings/Mage/Controller/Request/HttpTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Controller/Response/HttpTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Test/PHPUnit/ControllerTestCase.php';
require_once 'src/lib/Ibuildings/Mage/Test/PHPUnit/TestCase.php';