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
require dirname(__DIR__) . '/lib/vendor/autoload.php';

use Eliasis\Framework\App;
use Josantonius\LoadTime\LoadTime;

LoadTime::start();

App::run(dirname(__DIR__));

/*
 * Show runtime.
 *
 * print_r('Executed in: ' . LoadTime::end() . ' seconds.');
 */
