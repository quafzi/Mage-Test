# Mage_Test #

This module provides a patched version of Mage_Core enabling you to inject testing dependencies at run time. Due to the functionality of the Varien_Autoloader the local code pool is prioritised over the core. Meaning that any code duplicated from the Mage vendor namespace into the local code pool will be used over the core.

## Install ##

Copy or symlink the following module paths to the matching magento path:

    e.g. module path => magento path
    
    Mage_Test/Mage => app/code/local/Mage
    lib/PHPUnit => lib/PHPUnit

## Magento Functional Testing ##

Magento, although it uses the Zend Framework in places, it does not use the MVC. Magento uses the Varien Controller and associated classes. The Varien_Request & Varien_Response do however extend:

* Zend_Controller_Request_Http
* Zend_Controller_Response_Http

This means that the Zend_Controller_Request_HttpTestCase & Zend_Controller_Response_HttpTestCase should be compatible with Magento

Because Magento uses the Varien MVC it is not possible to use the existing Zend_Test_PHPUnit_ControllerTestCase that are shipped as part of Zend Test. We require a new version of Zend_Test_PHPUnit_ControllerTestCase extended to suite the needs of Magento, PHPUnit_Magento_ControllerTestCase.

We will need to override the setup() method to use a custom bootstrap method to bootstrap the Magento application correctly for it to run within test cases. The bootstrap within Zend_Test_PHPUnit_ControllerTestCase is declared final so we must create a Magento specific version. We will need to create patched versions of some Mage_Core files to allow the runtime injection of:

* Zend_Controller_Request_HttpTestCase
* Zend_Controller_Response_HttpTestCase

These classes will possibly need to be overloaded to add the additional functionality required by Magento?

The Magento Controller will also need to be extended to overload the dispatch() method, preventing headers from being sent and allowing the view to be tested.

== Magento Classes to be Overloaded ==

* Mage_Core_Controller_Varien_Front
* Mage_Core_Controller_Varien_Action
* Mage_Core_Model_App

== Complex Issues ==

The Mage.php bootstrap class used within Magento that also provides access to all other parts of the application is declared Final. It may be required that an additional testing bootstrap is created that proxies this class. The Mage bootstrap provides access to the application singleton and provides a number of static factory methods that are used throughout the application.

The Mage class will need to be used during testing but we should be able to bootstrap the application and then set the property of the Mage singleton?

None of the classes that require overload are instantiated using the static factory. This means that patches will be required to the core application in order for us to be able to run controller tests. These however can be maintained within the local code pool and loaded based on the ordered priorities of the Varien_Autoloader:

1. local
2. community
3. core

= Risks =

* We need to clearly separate modifications from the Magento core so that future upgrades are still possible.
* Our testing code may be broken as part of an upgrade due to the nature of the modifications.
* The tests will be using alternate code that may mask an error.
