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
namespace AdvancedLocalComplement\Controller;

use Eliasis\Framework\Controller;

/**
 * Hooks controller.
 */
class Hooks extends Controller
{
    /**
     * Actions for activation hook.
     */
    public function activation()
    {
        echo 'Response from activation hook';
    }

    /**
     * Actions for deactivation hook.
     */
    public function deactivation()
    {
        echo 'Response from deactivation hook';
    }

    /**
     * Actions for installation hook.
     */
    public function installation()
    {
        echo 'Response from installation hook';
    }

    /**
     * Actions for uninstallation hook.
     */
    public function uninstallation()
    {
        echo 'Response from uninstallation hook';
    }
}
