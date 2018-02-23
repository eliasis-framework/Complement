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
use Eliasis\Framework\View;
use Josantonius\Hook\Hook;

echo View::getOption('test');
?>
<!DOCTYPE html>

<html lang="es">

    <head>
        <!-- Site meta -->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta charset="utf-8">
        <?php Hook::doAction('meta') ?> 
        <!-- Title -->
        <title>Eliasis PHP Framework</title>
        <!-- CSS -->
        <?php Hook::doAction('css') ?>
    </head>
