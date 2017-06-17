# CHANGELOG

## 1.0.5 - 2017-06-18

* Fixes in `remove()` method and others.

* Deleted `Eliasis\Module\Module->addOption()` method.

* Added `Eliasis\Module\Module->_doAction()` method.

## 1.0.4 - 2017-06-12

* Added `Eliasis\Module\Module->set()` method.
* Added `Eliasis\Module\Module->get()` method.
* Added `Eliasis\Module\Module->instance()` method.

* Deprecated `Eliasis\Module\Module->addOption()` method.

The `addOption()` method will be deleted in the next version. It will be replaced by the `set()` method and will be removed in the next version.

## 1.0.3 - 2017-05-31

* Added `Eliasis\Module\Module->addOption()` method.

## 1.0.2 - 2017-05-31

* Some bugs were fixed.

* Added argument in `getModulesInfo` method to filter modules by category.

* Added `Eliasis\Module\Module::exists($id)` method.

* Required `Josantonius/Json` library.

## 1.0.1 - 2017-05-27

* The following parameters were added for the module configuration file:

	id       → Required → Unique identifier. Previously 'name' was used.
	state    → Required → State: active, inactive, uninstalled, installed.
	category → Required → Category: Extension, component, widget, plugin...

## 1.0.0 - 2017-05-07

* Added `Eliasis\Module\Module` class.
* Added `Eliasis\Module\Module::getInstance()` method.
* Added `Eliasis\Module\Module::loadModules()` method.
* Added `Eliasis\Module\Module::_add()` method.
* Added `Eliasis\Module\Module::getStates()` method.
* Added `Eliasis\Module\Module::_setStates()` method.
* Added `Eliasis\Module\Module->_getState()` method.
* Added `Eliasis\Module\Module->_setState()` method.
* Added `Eliasis\Module\Module->_getAction()` method.
* Added `Eliasis\Module\Module->_setAction()` method.
* Added `Eliasis\Module\Module::changeState()` method.
* Added `Eliasis\Module\Module::remove()` method.
* Added `Eliasis\Module\Module->_deleteDir()` method.
* Added `Eliasis\Module\Module::getModulesInfo()` method.
* Added `Eliasis\Module\Module->_getSettings()` method.
* Added `Eliasis\Module\Module->_addResources()` method.
* Added `Eliasis\Module\Module::__callstatic()` method.

* Required `Eliasis-Framework/Eliasis` framework.
* Required `Josantonius/Hook` library.

* Bug fixed when creating status file.

* The module path was added to the getModulesInfo method.