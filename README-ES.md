# Module PHP library for Eliasis Framework

[![Latest Stable Version](https://poser.pugx.org/eliasis-framework/module/v/stable)](https://packagist.org/packages/eliasis-framework/module) [![Total Downloads](https://poser.pugx.org/eliasis-framework/module/downloads)](https://packagist.org/packages/eliasis-framework/module) [![Latest Unstable Version](https://poser.pugx.org/eliasis-framework/module/v/unstable)](https://packagist.org/packages/eliasis-framework/module) [![License](https://poser.pugx.org/eliasis-framework/module/license)](https://packagist.org/packages/eliasis-framework/module)

[English version](README.md)

Librería PHP para agregar adición de módulos en Eliasis Framework.

---

- [Instalación](#instalación)
- [Requisitos](#requisitos)
- [Cómo empezar y ejemplos](#cómo-empezar-y-ejemplos)
- [Métodos disponibles](#métodos-disponibles)
- [Uso](#uso)
- [Tests](#tests)
- [Manejador de excepciones](#manejador-de-excepciones)
- [Contribuir](#contribuir)
- [Repositorio](#repositorio)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

### Instalación 

La mejor forma de instalar esta extensión es a través de [composer](http://getcomposer.org/download/).

Para instalar PHP Hook library, simplemente escribe:

    $ composer require eliasis-framework/Module

El comando anterior sólo instalará los archivos necesarios, si prefieres descargar todo el código fuente (incluyendo tests, directorio vendor, excepciones no utilizadas, documentos...) puedes utilizar:

    $ composer require eliasis-framework/Module --prefer-source

También puedes clonar el repositorio completo con Git:

	$ git clone https://github.com/eliasis-framework/Module.git

### Requisitos

Esta ĺibrería es soportada por versiones de PHP 5.6 o superiores y es compatible con versiones de HHVM 3.0 o superiores.

### Cómo empezar y ejemplos

Para utilizar esta librería, simplemente:

```php
require __DIR__ . '/vendor/autoload.php';

use Eliasis\Module\Module;
```

### Métodos disponibles

Métodos disponibles en esta librería:

```php
Module::getInstance();
Module::loadModules();
Module::getStates();
Module::changeState();
Module::remove();
Module->getModulesInfo();
```

### Uso

- Una vez instalada, la librería se cargará automáticamente desde el core de Eliasis Framework.

- Examinará el directorio "modules" en la raíz del sitio y cargará los módulos que tienen un [archivo de configuración válido](https://github.com/Eliasis-Framework/Modules#create-module).

### Tests 

- [ ] Pendiente.

### Manejador de excepciones

Esta librería utiliza [control de excepciones](src/Exception) que puedes personalizar a tu gusto.
### Contribuir
1. Comprobar si hay incidencias abiertas o abrir una nueva para iniciar una discusión en torno a un fallo o función.
1. Bifurca la rama del repositorio en GitHub para iniciar la operación de ajuste.
1. Escribe una o más pruebas para la nueva característica o expón el error.
1. Haz cambios en el código para implementar la característica o reparar el fallo.
1. Envía pull request para fusionar los cambios y que sean publicados.

Esto está pensado para proyectos grandes y de larga duración.

### Repositorio

Los archivos de configuración de este repositorio se crearon y subieron automáticamente con [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

### Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

### Copyright

2017 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).