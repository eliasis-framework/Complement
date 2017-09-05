<?php
/**
 * PHP library for adding addition of modules for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Module
 * @since      1.0.8
 */

namespace Eliasis\Module\Traits;

use Eliasis\App\App;

/**
 * Module action handler.
 *
 * @since 1.0.8
 */
trait ModuleAction { 

    /**
     * Action hooks.
     *
     * @since 1.0.8
     *
     * @var array
     */
    protected $hooks = [
        'activation', 
        'deactivation',
        'installation',
        'uninstallation',
    ];

    /**
     * Get module action.
     *
     * @since 1.0.8
     *
     * @param string $state → module state
     *
     * @uses string App::modules()       → module default action
     * @uses array  ModuleState->$states → modules states
     *
     * @return boolean
     */
    public function getAction($state) {

        $action = App::modules('default-action');

        if (isset($this->states['action'])) {

            $action = $this->states['action'];
        }

        return ($state === 'uninstalled') ? '' : $action;
    }

    /**
     * Set module action.
     *
     * @since 1.0.8
     *
     * @param string $action
     *
     * @uses array ModuleState->$states → modules states
     *
     * @return string → module action
     */
    public function setAction($action) {

        return $this->states['action'] = $action;
    }

    /**
     * Execute action hook.
     *
     * @since 1.0.8
     *
     * @param string $action → action hook to execute
     * @param string $state  → module state
     *
     * @uses object Module::getInstance()     → Module instance
     * @uses string ModuleAction::setAction() → set module action
     *
     * @return boolean
     */
    public function doAction($action, $state) {

        $controller = $this->get('hooks-controller');

        $instance = $this->instance($controller, 'controller');

        if (is_object($instance) && method_exists($instance, $action)) {

            $response = call_user_func([$instance, $action]);
        }

        $this->setAction('');

        return isset($response);
    }

    /**
     * Add module action hooks.
     *
     * @since 1.0.8
     *
     * @uses string App::$id          → application ID
     * @uses array  Module->$module   → module settings
     * @uses object Hook::getInstance → get Hook instance
     * @uses mixed  Hook::addActions  → add module action hooks
     *
     * @return void
     */
    private function _addActions() {

        if (isset($this->module['hooks'])) {

            Hook::getInstance(App::$id);
                
            return Hook::addActions($this->module['hooks']);
        }

        return false;
    }

    /**
     * Execute action hooks.
     *
     * @since 1.0.8
     *
     * @param string $action → action hook to execute
     * @param string $state  → module state
     *
     * @uses string App::$id          → application ID
     * @uses object Hook::getInstance → get Hook instance
     * @uses mixed  Hook::doAction    → run hooks
     *
     * @return void
     */
    private function _doActions($action, $state) {

        Hook::getInstance(App::$id);

        Hook::doAction('module-load');

        if (in_array($action, $this->hooks)) {

            $this->doAction($action, $state);
        }
    }
}
