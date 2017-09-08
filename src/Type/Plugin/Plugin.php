<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Complement
 * @since      1.0.9
 */

namespace Eliasis\Complement\Type\Plugin;

use Eliasis\Complement\Complement;

/**
 * Plugin complement.
 *
 * @since 1.0.9
 */
class Plugin extends Complement { 

    /**
     * Plugin instances.
     *
     * @since 1.0.9
     *
     * @var array
     */
    protected static $instances;

    /**
     * Complement type.
     *
     * @since 1.0.9
     *
     * @var string
     */
    protected static $type = 'plugin';

    /**
     * Id of current module called.
     *
     * @since 1.0.9
     *
     * @var array
     */
    public static $id = 'unknown';

    /**
     * Errors for file management.
     *
     * @since 1.0.9
     *
     * @var array
     */
    protected static $errors = [];
}
