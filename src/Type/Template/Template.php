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

namespace Eliasis\Complement\Type\Template;

use Eliasis\Complement\Complement;

/**
 * Template complement.
 *
 * @since 1.0.9
 */
class Template extends Complement { 

    /**
     * Template instances.
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
    protected static $type = 'template';

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
