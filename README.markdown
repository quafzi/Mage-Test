# Mage_Test #

This module provides a patched version of Mage_Core enabling you to inject testing dependencies at run time. Due to the functionality of the Varien_Autoloader the local code pool is prioritised over the core. Meaning that any code duplicated from the Mage vendor namespace into the local code pool will be used over the core.

This allows you to build and run functional controller tests in the same way you would with a standard Zend Framework Application using [Zend Test](http://framework.zend.com/manual/en/zend.test.phpunit.html). This mocks the Request and Response objects to that you can query the Response within a suite of tests.

## Manual Install ##

Clone the module code to your local machine or VM.

    git clone git@github.com:ibuildings/Mage_Test.git

Then symlink the following module paths to the matching magento path:

    e.g. module path => magento path
    
    Mage_Test/Mage => app/code/local/Mage
    lib/Ibuildings => lib/Ibuildings
    
Using symlinks means that you can keep your project code separate to this module yet still pull updates to this module from git. This module is still in development and not all assertions have yet been tested.

Instead of using manually created symlinks you may wish to consider using [Modman (Module-Manager)](http://code.google.com/p/module-manager/) to manage your module installation / management within your Magento project. This can be used in standalone without any SCM integration.

## Magento Functional Testing ##

