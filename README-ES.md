# Eliasis PHP Framework

[![Packagist](https://img.shields.io/packagist/v/eliasis-framework/complement.svg)](https://packagist.org/packages/eliasis-framework/complement) [![Downloads](https://img.shields.io/packagist/dt/eliasis-framework/complement.svg)](https://github.com/eliasis-framework/complement) [![License](https://img.shields.io/packagist/l/eliasis-framework/complement.svg)](https://github.com/eliasis-framework/complement/blob/master/LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/3ccc95bd114a451bb4fc2ef1884b0a66)](https://www.codacy.com/app/Josantonius/complement?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=eliasis-framework/complement&amp;utm_campaign=Badge_Grade) [![Build Status](https://travis-ci.org/eliasis-framework/complement.svg?branch=master)](https://travis-ci.org/eliasis-framework/complement) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![codecov](https://codecov.io/gh/eliasis-framework/complement/branch/master/graph/badge.svg)](https://codecov.io/gh/eliasis-framework/complement)

[English version](README.md)

![image](resources/eliasis-complement.png)

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Documentación](#documentation)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

## Requisitos

Este framework es soportado por versiones de **PHP 5.6** o superiores y es compatible con versiones de **HHVM 3.0** o superiores.

## Installation

Puedes instalar **Eliasis PHP Framework** en tu proyecto utilizando [Composer](http://getcomposer.org/download/). Si vas a empezar un nuevo proyecto, recomendamos utilizar nuestra [app básica](https://github.com/eliasis-framework/app) como punto de partida. Para aplicaciones existentes puedes ejecutar lo siguiente:

    $ composer require eliasis-framework/complement

El comando anterior sólo instalará los archivos necesarios, si prefieres **descargar todo el código fuente** puedes utilizar:

    $ composer require eliasis-framework/complement --prefer-source

## Documentación

[Documentación y ejemplos de uso](https://eliasis-framework.github.io/complement/v1.1.1/lang/es/).

## Tests 

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/) y seguir los siguientes pasos:

    $ git clone https://github.com/eliasis-framework/complement.git
    
    $ cd complement

    $ bash bin/install-wp-tests.sh wordpress_test root '' localhost latest

    $ composer install

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Ejecutar pruebas de estándares de código [PSR2](http://www.php-fig.org/psr/psr-2/) con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias en el estilo de codificación:

    $ composer phpmd

Ejecutar todas las pruebas anteriores:

    $ composer tests

## ☑ Tareas pendientes

- [ ] Añadir nueva funcionalidad.
- [ ] Agregar pruebas para Vue.
- [ ] Mejorar pruebas PHP.
- [ ] Mejorar documentación.
- [ ] Refactorizar código para las reglas de estilo de código deshabilitadas. Ver [phpmd.xml](phpmd.xml) y [.php_cs.dist](.php_cs.dist).

## Contribuir

Si deseas colaborar, puedes echar un vistazo a la lista de
[issues](https://github.com/eliasis-framework/complement/issues) o [tareas pendientes](#-tareas-pendientes).

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Ejecuta el comando `composer install` para instalar dependencias.
  Esto también instalará las [dependencias de desarrollo](https://getcomposer.org/doc/03-cli.md#install).
* Ejecuta el comando `composer fix` para estandarizar el código.
* Ejecuta las [pruebas](#tests).
* Crea una nueva rama (**branch**), **commit**, **push** y envíame un
  [pull request](https://help.github.com/articles/using-pull-requests).

## Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

## Copyright

2017 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).