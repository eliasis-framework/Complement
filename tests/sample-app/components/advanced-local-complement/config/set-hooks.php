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
$homeClass = 'AdvancedLocalComplement\Controller\Home';

return [
    'hooks' => [
        ['header', [$homeClass, 'header'], 8, 0],
        ['footer', [$homeClass, 'footer'], 8, 0],
        ['css', [$homeClass, 'css'], 8, 0],
        ['js',  [$homeClass, 'js'], 8, 0],
    ],
];
