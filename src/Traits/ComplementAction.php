<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/complement
 * @since     1.0.9
 */
namespace Eliasis\Complement\Traits;

use Eliasis\Framework\App;
use Josantonius\Hook\Hook;

/**
 * Complement action handler.
 */
trait ComplementAction
{
    /**
     * Action hooks.
     *
     * @var array
     */
    protected static $hooks = [
        'activation',
        'deactivation',
        'installation',
        'uninstallation',
    ];

    /**
     * Default actions.
     *
     * @var array
     */
    protected static $defaultAction = [
        'component' => 'activation',
        'plugin' => 'activation',
        'module' => 'activation',
        'template' => 'activation',
    ];

    /**
     * Get complement action.
     *
     * @param string $state → complement state
     *
     * @uses \Eliasis\Complement\ComplementState->$states
     * @uses \Eliasis\Complement\Traits\ComplementHandler::getType()
     *
     * @return string → complement action
     */
    public function getAction($state)
    {
        $type = self::getType('strtolower', false);
        $action = self::$defaultAction[$type];

        if (isset($this->states['action'])) {
            $action = $this->states['action'];
        }

        return ($state === 'uninstalled') ? '' : $action;
    }

    /**
     * Set complement action.
     *
     * @param string $action
     *
     * @uses \Eliasis\Complement\Traits\ComplementState->$states
     * @uses \Eliasis\Complement\Traits\ComplementState->setStates()
     *
     * @return string → complement action
     */
    public function setAction($action)
    {
        $this->states['action'] = $action;

        $this->setStates();

        return $action;
    }

    /**
     * Execute action hook.
     *
     * @param string $action → action hook to execute
     *
     * @uses \Eliasis\Complement\Traits\ComplementAction::setAction()
     * @uses \Eliasis\Complement\Traits\ComplementHandler::getOption()
     *
     * @return bool
     */
    public function doAction($action)
    {
        $controller = $this->getOption('hooks-controller');
        $instance = $this->getControllerInstance($controller);

        if (is_object($instance) && method_exists($instance, $action)) {
            $response = call_user_func([$instance, $action]);
        }

        $this->setAction('');

        return isset($response);
    }

    /**
     * Add complement action hooks.
     *
     * @uses \Eliasis\Framework\App::getCurrentID()
     * @uses \Eliasis\Complement\Complement->$complement
     * @uses \Josantonius\Hook\Hook::getInstance
     * @uses \Josantonius\Hook\Hook::addActions
     */
    private function addActions()
    {
        if ($this->setSettings('hooks')) {
            Hook::getInstance(App::getCurrentID());

            return Hook::addActions($this->complement['hooks']);
        }

        return false;
    }

    /**
     * Execute action hooks.
     *
     * @param string $action → action hook to execute
     *
     * @uses \Eliasis\Framework\App::getCurrentID()
     * @uses \Josantonius\Hook\Hook::getInstance
     * @uses \Josantonius\Hook\Hook::doAction
     * @uses \Eliasis\Complement\Traits\ComplementHandler::getType()
     */
    private function doActions($action)
    {
        $type = self::getType('strtolower', false);

        Hook::getInstance(App::getCurrentID());
        Hook::doAction('after_load_' . $type . 's');
        Hook::doAction('after_load_' . $this->complement['slug'] . '_' . $type);

        if (in_array($action, self::$hooks, true)) {
            $this->doAction($action);
        }
    }
}
