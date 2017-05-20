<?php
/**
 * PHP library for adding addition of modules for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Module
 * @since      1.0.0
 */

namespace Eliasis\Module;

use Eliasis\App\App,
    Josantonius\Hook\Hook,
    Eliasis\Module\Exception\ModuleException;

/**
 * Module class.
 *
 * @since 1.0.0
 */
class Module { 

    /**
     * Module instance.
     *
     * @since 1.0.0
     *
     * @var object
     */
    protected static $instance;

    /**
     * Available modules.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $modules = [];

    /**
     * List of modules (status indicators).
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected static $states;

    /**
     * Action hooks.
     *
     * @since 1.0.0
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
     * Id of current module called.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public static $id;

    /**
     * Get module instance.
     *
     * @since 1.0.0
     *
     * @return object → module instance
     */
    public static function getInstance() {

        if (is_null(self::$instance)) { 

            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Load all modules found in the directory.
     *
     * @since 1.0.0
     *
     * @param string $path → modules folder path
     */
    public static function loadModules($path) {

        Hook::setHook(self::$hooks);

        self::getStates();

        if (is_dir($path) && $handle = opendir($path)) {

            while ($dir = readdir($handle)) {

                $ignore = App::DS . '.' . App::DS . '..' . App::DS;

                if ((is_dir($path . $dir)) && !strpos($ignore, $dir)) {

                    $file = $path . $dir . App::DS . $dir . '.php';

                    if (!file_exists($file)) {

                        continue;
                    }

                    $module = require($file);

                    self::$id = isset($module['name']) ? $module['name'] : '';

                    self::_add($module, $path . $dir);
                }
            }

            closedir($handle);
        }

        self::_setStates();
    }

    /**
     * Add module.
     *
     * @since 1.0.0
     *
     * @param string $module → module info
     * @param string $path   → module path
     *
     * @throws ModuleException → module configuration file error
     */
    private static function _add($module, $path) {

        Hook::setHook($hookID = 'module-launch');

        $instance = self::getInstance();

        $required = [

            'name',
            'version',
            'description',
            'uri',
            'author',
            'author-uri',
            'license',
        ];

        if (count(array_intersect_key(array_flip($required),$module)) !== 7) {

            $message = 'The module configuration file is not correct. Path';

            throw new ModuleException($message . ': ' . $path . '.', 816);
        }

        $folder = explode(App::DS, $path);

        $module['path']['root'] = $path . App::DS;
        $module['folder'] = array_pop($folder) . App::DS;

        $instance->modules[App::$id][self::$id] = $module;

        $state  = $instance->_getState();
        $action = $instance->_getAction($state);

        $instance->_setAction($action);

        $instance->_setState($state);

        $instance->_getSettings();

        if (in_array($action, self::$hooks) || $state === 'active') {

            $instance->_addResources();

            Hook::run($hookID);

            Hook::resetHook($hookID);

            if (in_array($action, self::$hooks)) {

                Hook::run($action);

                $instance->_setAction('');

                Hook::resetHook($action);
            }
        }
    }

    /**
     * Get modules list (status indicators).
     *
     * @since 1.0.0
     *
     * @throws ModuleException → file not found
     *
     * @return array → modules states
     */
    public static function getStates() {

        if (is_null(self::$states)) {

            $path = App::ROOT() . 'modules' . App::DS;

            $filepath = $path . App::modules('states-file');

            if (is_file($filepath)) {

                $file = file_get_contents($filepath);
                
                return self::$states = json_decode($file, true);
            
            } else {

                return self::_setStates();

            }
            
            $message = 'modules-states.jsond file not found in';

            throw new ModuleException($message . ' ' . $path, 605);
        }

        return self::$states;
    }

    /**
     * Save states for modules.
     *
     * @since 1.0.0
     *
     * @throws ModuleException → file could not be created
     */
    private static function _setStates() {

        $path = App::ROOT() . 'modules' . App::DS;

        $filepath = $path . App::modules('states-file');

        $json = json_encode(self::$states, JSON_PRETTY_PRINT);
        
        if (!$file = fopen($filepath, 'w+')) { 

            $message = 'modules-states.jsond could not be created in';
            
            throw new ModuleException($message . ' ' . $filepath, 300);
        }

        fwrite($file, $json);
    }

    /**
     * Get module state.
     *
     * @since 1.0.0
     *
     * @return string → module state
     */
    private function _getState() {

        if (isset(self::$states[App::$id][self::$id]['state'])) {

            return self::$states[App::$id][self::$id]['state'];
        
        } else if (isset($this->modules[App::$id][self::$id]['state'])) {

            return $this->modules[App::$id][self::$id]['state'];
        }

        return App::modules('default-state');
    }

    /**
     * Set module state.
     *
     * @since 1.0.0
     *
     * @param string $state → module state
     */
    private function _setState($state) {

        $this->modules[App::$id][self::$id]['state'] = $state;

        self::$states[App::$id][self::$id]['state'] = $state;
    }

    /**
     * Get module action.
     *
     * @since 1.0.0
     *
     * @param string $state → module state
     */
    private function _getAction($state) {

        $action = App::modules('default-action');

        if (isset(self::$states[App::$id][self::$id]['action'])) {

            $action = self::$states[App::$id][self::$id]['action'];
        }

        return ($state === 'uninstalled') ? '' : $action;
    }

    /**
     * Set module action.
     *
     * @since 1.0.0
     *
     * @param string $action
     */
    private function _setAction($action) {

        self::$states[App::$id][self::$id]['action'] = $action;
    }

    /**
     * Change module state.
     *
     * @since 1.0.0
     */
    public static function changeState() {

        $instance = self::getInstance();

        self::getStates();

        $state = $instance->_getState();

        switch ($state) {
            
            case 'active':
                $action = 'deactivation';
                $state = 'inactive';
                break;

            case 'inactive':
                $action = 'activation';
                $state = 'active';
                break;

            case 'uninstalled':
                $action = 'installation';
                $state = 'installed';
                break;

            case 'remove':
                $action = 'uninstallation';
                $state = 'uninstalled';
                break;
        }

        $instance->_setState($state);

        $instance->_setAction($action);

        self::_setStates();
    }

    /**
     * Delete module.
     *
     * @since 1.0.0
     *
     * @param boolean $pluginName → plugin name to delete
     * @param boolean $deleteAll  → delete the entire directory or
     *                              leave only the configuration file.
     *
     * @return boolean
     */
    public static function remove($pluginName, $deleteAll = true) {

        $instance = self::getInstance();

        self::$id = $pluginName;

        if (isset($instance->modules[App::$id][self::$id]['path'])) {

            $instance->_setState('remove');

            $instance->changeState();

            $modulePath = $instance->modules[App::$id][self::$id]['path'];

            $instance->_deleteDir($modulePath, $deleteAll);

            if ($deleteAll) {
            
                unset($this->modules[App::$id][self::$id]);
                unset(self::$states[App::$id][self::$id]);
            }

            self::_setStates();

            return true;
        }

        return false;
    }

    /**
     * Delete module.
     *
     * @since 1.0.0
     *
     * @param boolean $modulePath → module path
     * @param boolean $deleteAll  → delete the entire directory or
     *                              leave only the configuration file.
     *
     * @return boolean
     */
    private function _deleteDir($modulePath, $deleteAll) { 

        $slug = trim($this->modules[App::$id][self::$id]['folder'], App::DS);

        if (!is_dir($modulePath)) {

            return false;
        }
         
        $objects = scandir($modulePath); 
        
        foreach ($objects as $object) { 
        
            if ($object == '.' && $object == '..') {

                continue;
            }
                
            if (is_dir($modulePath . $object . App::DS)) {
            
                $this->_deleteDir($modulePath . $object, $deleteAll);
            
            } else {

                if (!$deleteAll && $object === $slug . '.php') {

                    continue;
                }

                unlink($modulePath . App::DS . $object);
            }
        }

        if (!$deleteAll) {

            $path = explode(App::DS, trim($modulePath, App::DS));

            $folder = array_pop($path);

            if ($folder === $slug) {

                return true;
            }
        }

        rmdir($modulePath);

        return true;
    }

    /**
     * Get modules info.
     *
     * @since 1.0.0
     *
     * @return array $data → modules info
     */
    public static function getModulesInfo() {

        $data = [];

        $instance = self::getInstance();

        $modules = array_keys($instance->modules[App::$id]);

        foreach ($modules as $module) {

            $module = $instance->modules[App::$id][$module];

            $name = $module['name'];

            $name = trim(implode(' ', preg_split("/(?=[A-Z])/", $name)));

            $data[] = [

                'id'          => $module['name'],
                'name'        => $name,
                'version'     => $module['version'],
                'description' => $module['description'],
                'path'        => $module['path']['root'],
                'uri'         => $module['uri'],
                'author'      => $module['author'],
                'author-uri'  => $module['author-uri'],
                'license'     => $module['license'],
                'state'       => $module['state'],
                'slug'        => trim($module['folder'], App::DS),
            ];
        }

        return $data;
    }

    /**
     * Get settings.
     *
     * @since 1.0.0
     */
    private function _getSettings() {

        $id = App::$id;

        $name = self::$id;

        $root = $this->modules[$id][$name]['path']['root'];

        $path =  $root . 'config' . App::DS;

        if (is_dir($path) && $handle = scandir($path)) {

            $files = array_slice($handle, 2);

            foreach ($files as $file) {

                $content = require($path . $file);

                $merge = array_merge($this->modules[$id][$name], $content);

                $this->modules[$id][$name] = $merge;
            }
        }

        $this->modules[$id][$name]['path']['root'] = $path;
    }
                                                                               
    /**
     * Add module routes and hooks if exists.
     *
     * @since 1.0.0
     */
    private function _addResources() {

        $config = $this->modules[App::$id][self::$id];

        if (isset($config['hooks']) && count($config['hooks'])) {

            Hook::addHook($config['hooks']);
        } 

        if (class_exists($Router = 'Josantonius\Router\Router')) {

            if (isset($config['routes']) && count($config['routes'])) {

                $Router::addRoute($config['routes']);
            }
        }
    }

    /**
     * Receives the name of the module to execute: Module::ModuleName();
     *
     * @since 1.0.0
     *
     * @param string $index  → module name
     * @param array  $params → params
     *
     * @throws ModuleException → Module not found
     *
     * @return mixed
     */
    public static function __callstatic($index, $params = '') {

        $instance = self::getInstance();

        if (!isset($instance->modules[App::$id][$index])) {

            $message = 'Module not found';

            throw new ModuleException($message . ': ' . $index . '.', 817);
        }

        self::$id = $index;

        $column[] = $instance->modules[App::$id][$index];

        if (!count($params)) {

            return (!is_null($column[0])) ? $column[0] : '';
        }

        foreach ($params as $param) {

            $column = array_column($column, $param);
        }
        
        return (isset($column[0])) ? $column[0] : '';
    }
}
