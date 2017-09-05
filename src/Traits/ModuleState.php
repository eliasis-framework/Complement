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

use Eliasis\App\App,
    Josantonius\Json\Json;

/**
 * Module states handler.
 *
 * @since 1.0.8
 */
trait ModuleState {

    /**
     * List of modules (status indicators).
     *
     * @since 1.0.8
     *
     * @var array
     */
    protected $states;

    /**
     * States and actions that will be executed when a module changes state.
     *
     * @since 1.0.8
     *
     * @var array
     */
    protected $statesHandler = [
        'active' => [
            'action' => 'deactivation',
            'state'  => 'inactive'
        ],
        'inactive' => [
            'action' => 'activation',
            'state'  => 'active'
        ],
        'uninstall' => [
            'action' => 'uninstallation',
            'state'  => 'uninstalled'
        ],
        'uninstalled' => [
            'action' => '',
            'state'  => 'installed'
        ],
        'installed' => [
            'action' => 'installation',
            'state'  => 'inactive'
        ],
        'outdated' => [
            'action' => 'installation',
            'state'  => 'updated'
        ],
        'updated' => [
            'action' => 'activation',
            'state'  => 'active'
        ],
    ];

    /**
     * Set module state.
     *
     * @since 1.0.8
     *
     * @param string $state → module state
     *
     * @return string → state
     */
    public function setState($state) {

        $this->module['state'] = $state;
        $this->states['state'] = $state;

        $this->_setStates();

        return $state;
    }

    /**
     * Change module state.
     *
     * @since 1.0.8
     *
     * @uses void ModuleAction::doAction() → execute action hooks
     *
     * @return string → new state
     */
    public function changeState() {

        $this->getStates();

        $actualState = $this->getState();

        $newState = $this->statesHandler[$actualState]['state'];
        $action   = $this->statesHandler[$actualState]['action'];

        $this->setState($newState);

        $this->doAction($action, $newState);

        return $newState;
    }

    /**
     * Get module state.
     *
     * @since 1.0.8
     *
     * @uses string App::modules() → default state module
     *
     * @return string → module state
     */
    public function getState() {

        if (isset($this->states['state'])) {

            return $this->states['state'];
        
        } else if (isset($this->module['state'])) {

            return $this->module['state'];
        }

        return App::modules('default-state');
    }

    /**
     * Get modules states.
     *
     * @since 1.0.8
     *
     * @uses string App::$id    → application ID
     * @uses string Module::$id → module ID
     *
     * @return array → modules states
     */
    public function getStates() {

        $states = $this->_getStatesFromFile();

        if (isset($states[App::$id][self::$id])) {

            return $this->states = $states[App::$id][self::$id];
        }

        return $this->states = [];
    }

    /**
     * Set modules states.
     *
     * @since 1.0.8
     *
     * @uses string App::$id            → application ID
     * @uses string Module::$id         → module ID
     * @uses array  Json::arrayToFile() → convert array to json file
     *
     * @return void
     */
    private function _setStates() {

        if (!is_null($this->states)) {

            $states = $this->_getStatesFromFile();

            if ($this->_stateChanged($states)) {

                $states[App::$id][self::$id] = $this->states;

                Json::arrayToFile($states, $this->_getStatesFilePath());
            }
        }
    }

    /**
     * Check if module state has changed.
     *
     * @since 1.0.8
     *
     * @param string $states → module states
     *
     * @uses string App::$id    → application ID
     * @uses string Module::$id → module ID
     *
     * @return boolean
     */
    private function _stateChanged($states) {

        if (isset($states[App::$id][self::$id])) {

            $actualStates = $states[App::$id][self::$id];

            if (!count(array_diff_assoc($actualStates, $this->states))) {

                return false;
            }
        }

        return true;
    }

    /**
     * Get states from json file.
     *
     * @since 1.0.8
     *
     * @uses array Json::fileToArray() → convert json file to array
     *
     * @return array → modules states
     */
    private function _getStatesFromFile() {

        return Json::fileToArray($this->_getStatesFilePath());
    }

    /**
     * Get modules file path.
     *
     * @since 1.0.8
     *
     * @uses string App::MODULES() → modules path
     * @uses string App::modules() → modules file
     *
     * @return string → modules file path
     */
    private function _getStatesFilePath() {

        return App::MODULES() . App::modules('states-file');
    }
}
