# Eliasis PHP Framework

[![Packagist](https://img.shields.io/packagist/v/eliasis-framework/complement.svg)](https://packagist.org/packages/eliasis-framework/complement) [![Downloads](https://img.shields.io/packagist/dt/eliasis-framework/complement.svg)](https://github.com/eliasis-framework/complement) [![License](https://img.shields.io/packagist/l/eliasis-framework/complement.svg)](https://github.com/eliasis-framework/complement/blob/master/LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/3ccc95bd114a451bb4fc2ef1884b0a66)](https://www.codacy.com/app/Josantonius/complement?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=eliasis-framework/complement&amp;utm_campaign=Badge_Grade) [![Build Status](https://travis-ci.org/eliasis-framework/complement.svg?branch=master)](https://travis-ci.org/eliasis-framework/complement) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![codecov](https://codecov.io/gh/eliasis-framework/complement/branch/master/graph/badge.svg)](https://codecov.io/gh/eliasis-framework/complement)

[Versión en español](README-ES.md)

![image](resources/eliasis-complement.png)

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Documentation](#documentation)
- [Tests](#tests)
- [TODO](#-todo)
- [Contribute](#contribute)
- [License](#license)
- [Copyright](#copyright)

---

## Requirements

This framework is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

You can install **Eliasis PHP Framework** into your project using [Composer](http://getcomposer.org/download/). If you're starting a new project, we
recommend using the [basic app](https://github.com/eliasis-framework/app) as
a starting point. For existing applications you can run the following:

    $ composer require eliasis-framework/complement

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    $ composer require eliasis-framework/complement --prefer-source

## Documentation

[Documentation and examples of use](https://eliasis-framework.github.io/complement/v1.1.1/lang/en/).

## Tests 

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

    $ git clone https://github.com/eliasis-framework/complement.git
    
    $ cd complement

    $ bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

    $ composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

    $ composer phpmd

Run all previous tests:

    $ composer tests

## ☑ TODO

- [ ] Add new feature.
- [ ] Add tests for Vue.
- [ ] Improve PHP tests.
- [ ] Improve documentation.
- [ ] Refactor code for disabled code style rules. See [phpmd.xml](phpmd.xml) and [.php_cs.dist](.php_cs.dist).

## Contribute

If you would like to help, please take a look at the list of
[issues](https://github.com/eliasis-framework/complement/issues) or the [To Do](#-todo) checklist.

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Run the command `composer install` to install the dependencies.
  This will also install the [dev dependencies](https://getcomposer.org/doc/03-cli.md#install).
* Run the command `composer fix` to excute code standard fixers.
* Run the [tests](#tests).
* Create a **branch**, **commit**, **push** and send me a
  [pull request](https://help.github.com/articles/using-pull-requests).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

2017 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).