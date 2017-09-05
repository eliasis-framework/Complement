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
    Josantonius\File\File,
    Eliasis\Module\Exception\ModuleException;

/**
 * Module handler class.
 *
 * @since 1.0.8
 */
trait ModuleHandler {

    /**
     * Parameters required for the module configuration file.
     *
     * @since 1.0.8
     *
     * @var array
     */
    protected $required = [
        'id',
        'name',
        'version',
        'description',
        'state',
        'category',
        'uri',
        'author',
        'author-uri',
        'license',
    ];

    /**
     * Set module.
     *
     * @since 1.0.8
     *
     * @param string $module → module settings
     * @param string $path   → module path
     *
     * @uses array   Module->_getSettings        → get module settings
     * @uses array   ModuleState->getStates()    → get modules states
     * @uses string  ModuleState->getState()     → get module state
     * @uses string  ModuleState->setState()     → set module state
     * @uses boolean ModuleAction->getAction()   → get module action
     * @uses string  ModuleAction->setAction()   → set module action
     * @uses void    ModuleAction->_addActions() → add module action hooks
     * @uses void    ModuleAction->_doActions()  → execute action hooks
     *
     * @return void
     */
    public function setModule($module, $path) {

        $this->getStates();

        $this->_setModuleParams($module, $path);

        $state = $this->getState();

        $action = $this->getAction($state);

        $this->setAction($action);

        $this->setState($state);

        $this->_getSettings();

        $states = ['active', 'outdated'];

        if (in_array($action, $this->hooks) || in_array($state, $states)) {

            $this->_addRoutes();

            $this->_addActions();

            $this->_doActions($action, $state);
        }
    }

    /**
     * Set module option/s.
     *
     * @since 1.0.8
     *
     * @param string $option → option name or options array
     * @param mixed  $value  → value/s
     *
     * @return mixed
     */
    public function set($option, $value) {

        if (!is_array($value)) {

            return $this->module[$option] = $value;
        }

        if (array_key_exists($option, $value)) {

            $this->module[$option] = array_merge_recursive(

                $this->module[$option], $value
            );
        
        } else {

            foreach ($value as $key => $value) {
            
                $this->module[$option][$key] = $value;
            }
        }

        return $this->module[$option];        
    }

    /**
     * Get module option/s.
     *
     * @since 1.0.8
     *
     * @param mixed $param/s
     *
     * @return mixed
     */
    public function get(...$params) {

        $key = array_shift($params);

        $col[] = isset($this->module[$key]) ? $this->module[$key] : 0;

        if (!count($params)) {

            return ($col[0]) ? $col[0] : '';
        }

        foreach ($params as $param) {

            $col = array_column($col, $param);
        }
        
        return (isset($col[0])) ? $col[0] : '';
    }

    /**
     * Get module controller instance.
     *
     * @since 1.0.4
     *
     * @param array $class     → class name
     * @param array $namespace → namespace index
     *
     * @return object|false → class instance or false
     */
    public function instance($class, $namespace = '') {

        if (isset($this->module['namespaces'])) {

            if (isset($this->module['namespaces'][$namespace])) {

                $namespace = $this->module['namespaces'][$namespace];

                $class = $namespace . $class . '\\' . $class;

                return call_user_func([$class, 'getInstance']);
            }

            foreach ($this->module['namespaces'] as $key => $namespace) {

                $instance = $namespace . $class . '\\' . $class;
                
                if (class_exists($instance)) {

                    return call_user_func([$instance, 'getInstance']);
                }
            }
        }

        return false;
    }

    /**
     * Check required params and set module params.
     *
     * @since 1.0.8
     *
     * @param string $module → module settings
     * @param string $path   → module path
     *
     * @uses string App::DS              → directory separator
     * @uses array  Module->$module      → module settings
     * @uses string ModuleAction->$hooks → action hooks
     *
     * @throws ModuleException → module configuration file error
     *
     * @return void
     */
    private function _setModuleParams($module, $path) {

        $params = array_intersect_key(array_flip($this->required), $module);

        $default['slug'] = explode('.',basename($module['config-file']))[0];

        $path = App::MODULES() . $default['slug'] . App::DS;

        if (count($params) != 10) {

            $message = 'The module configuration file is not correct. Path';

            throw new ModuleException($message . ': ' . $path . '.', 816);
        }

        $folder = explode(App::DS, $path);

        $default['url-import'] = '';

        $default['hooks-controller'] = 'Launcher';

        $default['path']['root'] = rtrim($path, App::DS) . App::DS;

        $default['folder'] = array_pop($folder) . App::DS;
        
        $this->module = array_merge($default, $module);

        $this->_setImage();
    }

    /**
     * Get settings.
     *
     * @since 1.0.8
     *
     * @uses array Module->$module → module settings
     *
     * @return void
     */
    private function _getSettings() {

        $_root = $this->module['path']['root'];

        $_config = $_root . 'config' . App::DS;

        if (is_dir($_config) && $handle = scandir($_config)) {

            $files = array_slice($handle, 2);

            foreach ($files as $file) {

                $content = require($_config . $file);

                $merge = array_merge($this->module, $content);

                $this->module = $merge;
            }
        }
        
        $this->module['path']['root']   = $_root;
        $this->module['path']['config'] = $_config;
    }

    /**
     * Set image url.
     *
     * @since 1.0.8
     *
     * @uses string App::DS         → directory separator
     * @uses string App::MODULES    → modules path
     * @uses array  Module->$module → module settings
     *
     * @return void
     */
    private function _setImage() {

        $file = 'public/images/' . $this->module['slug'] . '.png';

        $filepath = App::MODULES() . $this->module['slug'] . App::DS . $file;

        $url = 'https://raw.githubusercontent.com/Eliasis-Framework/Module/';

        $directory = App::MODULES_URL() . $this->module['slug'] . '/' . $file;

        $repository = rtrim($this->module['url-import'], '/') . '/' . $file;
        
        $default = $url . 'master/public/images/default.png';

        if (File::exists($filepath)) {

            $this->module['image'] = $directory;

        } else if (File::exists($repository)) {

            $this->module['image'] = $repository; 
        
        } else {

            $this->module['image'] = $default;
        }
    }

    /**
     * Add module routes if exists.
     *
     * @since 1.0.8
     *
     * @uses array Router::addRoute → add routes
     * @uses array Module->$module  → module settings
     *
     * @return void
     */
    private function _addRoutes() {

        if (class_exists($Router = 'Josantonius\Router\Router')) {

            if (isset($this->module['routes'])) {

                $Router::addRoute($this->module['routes']);
            }
        }
    }
}
