<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7d665493a0d69eb2a102f56296aa7db1
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'Josantonius\\Url\\' => 16,
            'Josantonius\\Json\\' => 17,
            'Josantonius\\Hook\\' => 17,
        ),
        'E' => 
        array (
            'Eliasis\\Module\\' => 15,
            'Eliasis\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Josantonius\\Url\\' => 
        array (
            0 => __DIR__ . '/..' . '/josantonius/url/src',
        ),
        'Josantonius\\Json\\' => 
        array (
            0 => __DIR__ . '/..' . '/josantonius/json/src',
        ),
        'Josantonius\\Hook\\' => 
        array (
            0 => __DIR__ . '/..' . '/josantonius/hook/src',
        ),
        'Eliasis\\Module\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/src',
        ),
        'Eliasis\\' => 
        array (
            0 => __DIR__ . '/..' . '/eliasis-framework/eliasis/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7d665493a0d69eb2a102f56296aa7db1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7d665493a0d69eb2a102f56296aa7db1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
