<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/complement
 * @since     1.1.1
 */
use Eliasis\Framework\App;

global $argv;

$type = isset($argv[2]) ? ucfirst($argv[2]) : 'Component';

$type = ucwords($type);

$rootPath = App::$type() . 'advanced-local-complement/';

return [
    'path' => [
        'css' => $rootPath . 'public/css/',
        'js' => $rootPath . 'public/js/',
        'layout' => $rootPath . 'src/template/layout/',
        'page' => $rootPath . 'src/template/page/',
    ],
];
