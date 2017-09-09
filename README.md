# Complement PHP library for Eliasis Framework

[![Latest Stable Version](https://poser.pugx.org/eliasis-framework/complement/v/stable)](https://packagist.org/packages/eliasis-framework/complement) [![Total Downloads](https://poser.pugx.org/eliasis-framework/complement/downloads)](https://packagist.org/packages/eliasis-framework/complement) [![Latest Unstable Version](https://poser.pugx.org/eliasis-framework/complement/v/unstable)](https://packagist.org/packages/eliasis-framework/complement) [![License](https://poser.pugx.org/eliasis-framework/complement/license)](https://packagist.org/packages/eliasis-framework/complement)

[Versión en español](README-ES.md)

PHP library for adding addition of complements (components, plugins, modules, templates) for Eliasis Framework.

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick Start and Examples](#quick-start-and-examples)
- [Available Methods](#available-methods)
- [Images](#images)
- [Usage](#usage)
- [Tests](#tests)
- [Exception Handler](#exception-handler)
- [Contribute](#contribute)
- [Repository](#repository)
- [License](#license)
- [Copyright](#copyright)

---

<p align="center"><strong>Complements view (Módules)</strong></p>

<p align="center">
  <a href="https://youtu.be/EJi_TXa28Mc" title="Take a look at the code">
  	<img src="https://raw.githubusercontent.com/Josantonius/PHP-Algorithm/master/resources/youtube-thumbnail.jpg">
  </a>
</p>

---

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install PHP Complement library, simply:

    $ composer require eliasis-framework/Complement

The previous command will only install the necessary files, if you prefer to download the entire source code (including tests, vendor folder, exceptions not used, docs...) you can use:

    $ composer require eliasis-framework/Complement --prefer-source

Or you can also clone the complete repository with Git:

	$ git clone https://github.com/eliasis-framework/Complement.git
	
### Requirements

This library is supported by PHP versions 5.6 or higher and is compatible with HHVM versions 3.0 or higher.

### Quick Start and Examples

To use this class, simply:

```php
require __DIR__ . '/vendor/autoload.php';
```

### Available Methods

Available methods in this library:

```php
use Eliasis\Complement\Type\Component;

Component::getInstance();
Component::run();
Component::load();
Component::getInfo();
Component::script();
Component::style();
Component::exists();
Component::getLibraryPath();
Component::getLibraryVersion();
Component::render();

Component::Identifier()->set();
Component::Identifier()->get();
Component::Identifier()->instance();
Component::Identifier()->getAction();
Component::Identifier()->setAction();
Component::Identifier()->doAction();
Component::Identifier()->hasNewVersion();
Component::Identifier()->getRepositoryVersion();
Component::Identifier()->install();
Component::Identifier()->remove();
Component::Identifier()->setState();
Component::Identifier()->changeState();
Component::Identifier()->getState();
Component::Identifier()->getStates();
```

```php
use Eliasis\Complement\Type\Plugin;

Plugin::getInstance();
Plugin::run();
Plugin::load();
Plugin::getInfo();
Plugin::script();
Plugin::style();
Plugin::exists();
Plugin::getLibraryPath();
Plugin::getLibraryVersion();
Plugin::render();

Plugin::Identifier()->set();
Plugin::Identifier()->get();
Plugin::Identifier()->instance();
Plugin::Identifier()->getAction();
Plugin::Identifier()->setAction();
Plugin::Identifier()->doAction();
Plugin::Identifier()->hasNewVersion();
Plugin::Identifier()->getRepositoryVersion();
Plugin::Identifier()->install();
Plugin::Identifier()->remove();
Plugin::Identifier()->setState();
Plugin::Identifier()->changeState();
Plugin::Identifier()->getState();
Plugin::Identifier()->getStates();
```

```php
use Eliasis\Complement\Type\Module;

Module::getInstance();
Module::run();
Module::load();
Module::getInfo();
Module::script();
Module::style();
Module::exists();
Module::getLibraryPath();
Module::getLibraryVersion();
Module::render();

Module::Identifier()->set();
Module::Identifier()->get();
Module::Identifier()->instance();
Module::Identifier()->getAction();
Module::Identifier()->setAction();
Module::Identifier()->doAction();
Module::Identifier()->hasNewVersion();
Module::Identifier()->getRepositoryVersion();
Module::Identifier()->install();
Module::Identifier()->remove();
Module::Identifier()->setState();
Module::Identifier()->changeState();
Module::Identifier()->getState();
Module::Identifier()->getStates();
```

```php
use Eliasis\Complement\Type\Template;

Template::getInstance();
Template::run();
Template::load();
Template::getInfo();
Template::script();
Template::style();
Template::exists();
Template::getLibraryPath();
Template::getLibraryVersion();
Template::render();

Template::Identifier()->set();
Template::Identifier()->get();
Template::Identifier()->instance();
Template::Identifier()->getAction();
Template::Identifier()->setAction();
Template::Identifier()->doAction();
Template::Identifier()->hasNewVersion();
Template::Identifier()->getRepositoryVersion();
Template::Identifier()->install();
Template::Identifier()->remove();
Template::Identifier()->setState();
Template::Identifier()->changeState();
Template::Identifier()->getState();
Template::Identifier()->getStates();
```

### Images

![image](resources/eliasis-complement-1.png)

![image](resources/eliasis-complement-2.png)

![image](resources/eliasis-complement-3.png)

### Usage

- The library will be loaded automatically from the Eliasis Framework core.
 
- [ ] Pending

### Tests

- [ ] Pending

### Exception Handler

This library uses [exception handler](src/Exception) that you can customize.

### Contribute
1. Check for open issues or open a new issue to start a discussion around a bug or feature.
1. Fork the repository on GitHub to start making your changes.
1. Write one or more tests for the new feature or that expose the bug.
1. Make code changes to implement the feature or fix the bug.
1. Send a pull request to get your changes merged and published.

This is intended for large and long-lived objects.

### Repository

All files in this repository were created and uploaded automatically with [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).