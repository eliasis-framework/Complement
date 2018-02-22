<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Eliasis-Framework/Complement
 * @since     1.1.1
 */
namespace AdvancedLocalComplement\Controller;

use Eliasis\Framework\Controller;

/**
 * Home controller.
 */
class Home extends Controller
{
    /**
     * Actions for header hook.
     */
    public function header()
    {
        echo '<header></header>';
    }

    /**
     * Actions for css hook.
     */
    public function css()
    {
        echo '<style></style>';
    }

    /**
     * Actions for js hook.
     */
    public function js()
    {
        echo '<script></script>';
    }

    /**
     * Actions for footer hook.
     */
    public function footer()
    {
        echo '<footer></footer>';
    }

    /**
     * Actions for route.
     */
    public function routes()
    {
        echo 'The routes were loaded correctly';
    }

    /**
     * Get model instance.
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get view instance.
     */
    public function getView()
    {
        return $this->view;
    }
}
