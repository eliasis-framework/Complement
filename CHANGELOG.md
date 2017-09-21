# CHANGELOG

## 1.0.9 - 2017-09-07

* Renamed class `Eliasis\Module\Module` to `Eliasis\Complement\Complement`.
* Renamed trait `Eliasis\Module\ModuleAction` to `Eliasis\Complement\ComplementAction`.
* Renamed trait `Eliasis\Module\ModuleHandler` to `Eliasis\Complement\ComplementHandler`.
* Renamed trait `Eliasis\Module\ModuleImport` to `Eliasis\Complement\ComplementImport`.
* Renamed trait `Eliasis\Module\ModuleRequest` to `Eliasis\Complement\ComplementRequest`.
* Renamed trait `Eliasis\Module\ModuleState` to `Eliasis\Complement\ComplementState`.
* Renamed trait `Eliasis\Module\ModuleView` to `Eliasis\Complement\ComplementView`.

* Added `Eliasis\Complement\Type\Component\Component` class.
* Added `Eliasis\Complement\Type\Plugin\Plugin` class.
* Added `Eliasis\Complement\Type\Module\Module` class.
* Added `Eliasis\Complement\Type\Template\Template` class.

* Added `Eliasis\Complement\Complement` class.
* Added `Eliasis\Complement\Complement::getInstance()` method.
* Added `Eliasis\Complement\Complement::run()` method.
* Added `Eliasis\Complement\Complement::load()` method.
* Added `Eliasis\Complement\Complement::getInfo()` method.
* Added `Eliasis\Complement\Complement::script()` method.
* Added `Eliasis\Complement\Complement::style()` method.
* Added `Eliasis\Complement\Complement::getLibraryPath()` method.
* Added `Eliasis\Complement\Complement::getLibraryVersion()` method.
* Added `Eliasis\Complement\Complement::__callstatic()` method.
* Added `Eliasis\Complement\Complement::render()` method.

* Added `Eliasis\Complement\ComplementAction` trait.
* Added `Eliasis\Complement\ComplementAction->getAction()` method.
* Added `Eliasis\Complement\ComplementAction->setAction()` method.
* Added `Eliasis\Complement\ComplementAction->doAction()` method.
* Added `Eliasis\Complement\ComplementAction->_addActions()` method.
* Added `Eliasis\Complement\ComplementAction->_doActions()` method.

* Added `Eliasis\Complement\ComplementHandler` trait.
* Added `Eliasis\Complement\ComplementHandler->_setComplement()` method.
* Added `Eliasis\Complement\ComplementHandler->set()` method.
* Added `Eliasis\Complement\ComplementHandler->get()` method.
* Added `Eliasis\Complement\ComplementHandler->instance()` method.
* Added `Eliasis\Complement\ComplementHandler->_setComplementParams()` method.
* Added `Eliasis\Complement\ComplementHandler->_getSettings()` method.
* Added `Eliasis\Complement\ComplementHandler->_setImage()` method.
* Added `Eliasis\Complement\ComplementHandler->_getType()` method.
* Added `Eliasis\Complement\ComplementHandler->_addRoutes()` method.

* Added `Eliasis\Complement\ComplementImport` trait.
* Added `Eliasis\Complement\ComplementImport->hasNewVersion()` method.
* Added `Eliasis\Complement\ComplementImport->getRepositoryVersion()` method.
* Added `Eliasis\Complement\ComplementImport->install()` method.
* Added `Eliasis\Complement\ComplementImport->remove()` method.
* Added `Eliasis\Complement\ComplementImport->_deleteDirectory()` method.
* Added `Eliasis\Complement\ComplementImport->_installComplement()` method.
* Added `Eliasis\Complement\ComplementImport->_saveRemoteFile()` method.
* Added `Eliasis\Complement\ComplementImport->_validateRoute()` method.

* Added `Eliasis\Complement\ComplementRequest` trait.
* Added `Eliasis\Complement\ComplementRequest::requestHandler()` method.
* Added `Eliasis\Complement\ComplementRequest::_loadExternalComplements()` method.
* Added `Eliasis\Complement\ComplementRequest::_modulesLoadRequest()` method.
* Added `Eliasis\Complement\ComplementRequest::_installRequest()` method.
* Added `Eliasis\Complement\ComplementRequest::_uninstallRequest()` method.

* Added `Eliasis\Complement\ComplementState` trait.
* Added `Eliasis\Complement\ComplementState->setState()` method.
* Added `Eliasis\Complement\ComplementState->changeState()` method.
* Added `Eliasis\Complement\ComplementState->getState()` method.
* Added `Eliasis\Complement\ComplementState->getStates()` method.
* Added `Eliasis\Complement\ComplementState->_setStates()` method.
* Added `Eliasis\Complement\ComplementState->_stateChanged()` method.
* Added `Eliasis\Complement\ComplementState->_getStatesFromFile()` method.
* Added `Eliasis\Complement\ComplementState->_getStatesFilePath()` method.

* Added `Eliasis\Complement\ComplementView` trait.
* Added `Eliasis\Complement\ComplementView->_setFile()` method.
* Added `Eliasis\Complement\ComplementView->_renderizate()` method.

* Added `Eliasis\Complement\Exception\ComplementException` class.
* Added `Eliasis\Complement\Exception\ComplementException::__construct()` method.

* Added `Eliasis\Module\ModuleView` trait.
* Added `Eliasis\Module\ModuleView->_setFile()` method.
* Added `Eliasis\Module\ModuleView->_renderizate()` method.

* Deleted `public/css/eliasis-module-min.css` file.
* Deleted `public/js/eliasis-module.js` file.
* Deleted `public/js/eliasis-module-min.js` file.
* Deleted `public/sass/partials/_modules.sass` file.
* Deleted `public/sass/eliasis-module.sass` file.
* Deleted `public/template/eliasis-module.php` file.

* Added `public/css/eliasis-complement-min.css` file.
* Added `public/js/eliasis-complement.js` file.
* Added `public/js/eliasis-complement-min.js` file.
* Added `public/sass/partials/_complements.sass` file.
* Added `public/sass/eliasis-complement.sass` file.
* Added `public/template/eliasis-complement.php` file.

* Added `Eliasis/Complement/after_set_states` hook in `Eliasis\Complement\ComplementState` trait.

## 1.0.8 - 2017-09-05

* The library was optimized and some errors corrected.

* The whole library was restructured by dividing it into traits.

* Module visualization and management was implemented.

* Added option to install external modules just by adding the link to the configuration file.

* Deleted `Eliasis\Module\Module->_getState()` method.
* Deleted `Eliasis\Module\Module->_setStates()` method.
* Deleted `Eliasis\Module\Module::getStates()` method.
* Deleted `Eliasis\Module\Module::setState()` method.
* Deleted `Eliasis\Module\Module::changeState()` method.
* Deleted `Eliasis\Module\Module->_getAction()` method.
* Deleted `Eliasis\Module\Module->_setAction()` method.
* Deleted `Eliasis\Module\Module->_doAction()` method.
* Deleted `Eliasis\Module\Module::_add()` method.
* Deleted `Eliasis\Module\Module::remove()` method.
* Deleted `Eliasis\Module\Module::_deleteDir()` method.
* Deleted `Eliasis\Module\Module->_getSettings()` method.
* Deleted `Eliasis\Module\Module->_addResources()` method.
* Deleted `Eliasis\Module\Module->get()` method.
* Deleted `Eliasis\Module\Module->set()` method.

* Added `Eliasis\Module\Module::loadModule()` method.
* Added `Eliasis\Module\Module::script()` method.
* Added `Eliasis\Module\Module::style()` method.
* Added `Eliasis\Module\Module::getLibraryPath()` method.
* Added `Eliasis\Module\Module::getLibraryVersion()` method.
* Added `Eliasis\Module\Module::render()` method.

* Added `Eliasis\Module\ModuleAction` trait.
* Added `Eliasis\Module\ModuleAction->getAction()` method.
* Added `Eliasis\Module\ModuleAction->setAction()` method.
* Added `Eliasis\Module\ModuleAction->doAction()` method.
* Added `Eliasis\Module\ModuleAction->_addActions()` method.
* Added `Eliasis\Module\ModuleAction->_doActions()` method.

* Added `Eliasis\Module\ModuleHandler` trait.
* Added `Eliasis\Module\ModuleHandler->setModule()` method.
* Added `Eliasis\Module\ModuleHandler->set()` method.
* Added `Eliasis\Module\ModuleHandler->get()` method.
* Added `Eliasis\Module\ModuleHandler->instance()` method.
* Added `Eliasis\Module\ModuleHandler->_setModuleParams()` method.
* Added `Eliasis\Module\ModuleHandler->_getSettings()` method.
* Added `Eliasis\Module\ModuleHandler->_setImage()` method.
* Added `Eliasis\Module\ModuleHandler->_addRoutes()` method.

* Added `Eliasis\Module\ModuleImport` trait.
* Added `Eliasis\Module\ModuleImport->hasNewVersion()` method.
* Added `Eliasis\Module\ModuleImport->getRepositoryVersion()` method.
* Added `Eliasis\Module\ModuleImport->install()` method.
* Added `Eliasis\Module\ModuleImport->remove()` method.
* Added `Eliasis\Module\ModuleImport->_deleteDirectory()` method.
* Added `Eliasis\Module\ModuleImport->_installModule()` method.
* Added `Eliasis\Module\ModuleImport->_saveRemoteFile()` method.
* Added `Eliasis\Module\ModuleImport->_validateRoute()` method.

* Added `Eliasis\Module\ModuleRequest` trait.
* Added `Eliasis\Module\ModuleRequest::requestHandler()` method.
* Added `Eliasis\Module\ModuleRequest::_loadExternalModules()` method.
* Added `Eliasis\Module\ModuleRequest::_modulesLoadRequest()` method.
* Added `Eliasis\Module\ModuleRequest::_installRequest()` method.
* Added `Eliasis\Module\ModuleRequest::_uninstallRequest()` method.

* Added `Eliasis\Module\ModuleState` trait.
* Added `Eliasis\Module\ModuleState->setState()` method.
* Added `Eliasis\Module\ModuleState->changeState()` method.
* Added `Eliasis\Module\ModuleState->getState()` method.
* Added `Eliasis\Module\ModuleState->getStates()` method.
* Added `Eliasis\Module\ModuleState->_setStates()` method.
* Added `Eliasis\Module\ModuleState->_stateChanged()` method.
* Added `Eliasis\Module\ModuleState->_getStatesFromFile()` method.
* Added `Eliasis\Module\ModuleState->_getStatesFilePath()` method.

* Added `Eliasis\Module\ModuleView` trait.
* Added `Eliasis\Module\ModuleView->_setFile()` method.
* Added `Eliasis\Module\ModuleView->_renderizate()` method.

* Added `public/css/eliasis-module-min.css` file.

* Added `public/images/default.png` file.

* Added `public/js/vue/app/app.js` file.

* Added `public/js/vue/vue.js` file.
* Added `public/js/vue/vue.min.js` file.
* Added `public/js/vue/vue-resource.min.js` file.

* Added `public/js/eliasis-module.js` file.
* Added `public/js/eliasis-module-min.js` file.

* Added `public/sass/partials/_load-buttons.sass` file.
* Added `public/sass/partials/_material-design-lite.sass` file.
* Added `public/sass/partials/_modules.sass` file.

* Added `public/sass/eliasis-module.sass` file.

* Added `public/template/eliasis-module.php` file.

* Added `Josantonius\File\File` library.

## 1.0.7 - 2017-07-25

* Fixed a bug in `__callstatic()` method. Now save the module id before obtaining the module instance.

## 1.0.6 - 2017-06-25

* Bugs fixed in doAction() method.

* Deleted `Eliasis\Module\Module->_setState()` method.

* Added `Eliasis\Module\Module->setState()` method.

## 1.0.5 - 2017-06-18

* Fixes in `remove()` method and others.

* Action hooks are executed when the module state is changed using Ajax.

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