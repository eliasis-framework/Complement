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
    Josantonius\Json\Json,
    Josantonius\File\File,
    Eliasis\Module\Exception\ModuleException;

/**
 * Module class.
 *
 * @since 1.0.0
 */
final class Module { 

    use Traits\ModuleHandler,
        Traits\ModuleAction,
        Traits\ModuleImport,
        Traits\ModuleState,
        Traits\ModuleRequest,
        Traits\ModuleView;

    /**
     * Module instances.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected static $instances;

    /**
     * Available modules.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $module = [];

    /**
     * Id of current module called.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public static $id = 'unknown';

    /**
     * Errors for file management.
     *
     * @since 1.0.8
     *
     * @var string
     */
    protected static $errors = [];

    /**
     * Get module instance.
     *
     * @since 1.0.0
     *
     * @uses string App::$id → application ID
     *
     * @return object → module instance
     */
    public static function getInstance() {

        if (!isset(self::$instances[App::$id][self::$id])) { 

            self::$instances[App::$id][self::$id] = new self;
        }

        return self::$instances[App::$id][self::$id];
    }

    /**
     * Load all modules found in the directory.
     *
     * @since 1.0.0
     *
     * @uses string App::DS                         → directory separator
     * @uses string ModuleHandler->setModule()      → add module
     * @uses string ModuleRequest::requestHandler() → HTTP request handler
     *
     * @return void
     */
    public static function loadModules() {

        $path = App::MODULES();
    
        if ($paths = File::getFilesFromDir($path)) {

            foreach($paths as $path) {

                if (!$path->isDot() && $path->isDir()) {

                    $_path = rtrim($path->getPath(), App::DS) . App::DS;
                    
                    $slug = $path->getBasename();

                    $file = $_path . $slug . App::DS . $slug . '.jsond';

                    if (!File::exists($file)) { continue; }

                    self::loadModule($file, $_path);
                }
            }
        }

        self::requestHandler();
    }

    /**
     * Load module configuration from json file and set settings.
     *
     * @since 1.0.8
     *
     * @param string $file → json file name
     * @param string $path → module path
     *
     * @uses array Json::fileToArray()         → convert json file to array
     * @uses string ModuleHandler->setModule() → set module
     *
     * @return void
     */
    public static function loadModule($file, $path = false) {

        $module = Json::fileToArray($file);

        $module['config-file'] = $file;

        self::$id = isset($module['id']) ? $module['id'] : 'unknown';

        $that = self::getInstance();

        $that->setModule($module, $path);        
    }

    /**
     * Get modules info.
     *
     * @since 1.0.0
     *
     * @param string $filter → module category filter
     * @param string $ort    → module category filter
     *
     * @uses string App::$id → application ID
     *
     * @return array $data → modules info
     */
    public static function getModulesInfo($filter = 'all', $sort = 'asort') {

        $data = [];

        $id = self::$id;

        $modules = array_keys(self::$instances[App::$id]);

        foreach ($modules as $moduleID) {

            self::$id = $moduleID;

            $that = self::getInstance();

            $module = $that->module;

            $category = isset($module['category']) ? $module['category'] : 0;

            $skip = ($filter != 'all' && $category != $filter);

            if (!$category || $skip || $moduleID == 'unknown' || !$module) {

                continue;
            }

            if ($that->hasNewVersion() && $module['state'] === 'active') {

                $module['state'] = 'outdated';

                $that->setState('outdated');
            } 

            $data[$module['id']] = [

                'id'          => $module['id'],
                'name'        => $module['name'],
                'version'     => $module['version'],
                'description' => $module['description'],
                'state'       => $module['state'],
                'category'    => $module['category'],
                'path'        => $module['path']['root'],
                'uri'         => $module['uri'],
                'author'      => $module['author'],
                'author-uri'  => $module['author-uri'],
                'license'     => $module['license'],
                'state'       => $module['state'],
                'slug'        => $module['slug'],
                'image'       => $img = $module['image'],
                'image_style' => "background: url(\"$img\") center / cover;",
            ];
        }

        self::$id = $id;

        $that->module = $module;

        $sorting = '|asort|arsort|krsort|ksort|natsort|rsort|shuffle|sort|';

        strpos($sorting, $sort) ? $sort($data) : asort($data);

        return $data;
    }

    /**
     * Set and get url script and vue file.
     *
     * @since 1.0.8
     *
     * @param string $pathUrl → url where JS files will be created & loaded
     *
     * @uses string App::DS                → directory separator
     * @uses string App::PUBLIC_URL()      → public url
     * @uses string ModuleView::_setFile() → set script files
     *
     * @return array → urls of the scripts
     */
    public static function script($pathUrl = null) {

        $that = self::getInstance();

        return $that->_setFile('eliasis-module-min', 'script', $pathUrl);
    }

    /**
     * Set and get url style.
     *
     * @since 1.0.8
     *
     * @param string $pathUrl → url where CSS files will be created & loaded
     *
     * @uses ModuleView::_setFile() → set style files
     *
     * @return array → urls of the styles
     */
    public static function style($pathUrl = null) {

        $that = self::getInstance();

        return $that->_setFile('eliasis-module-min', 'style', $pathUrl);
    }

    /**
     * Check if module exists.
     *
     * @since 1.0.0
     *
     * @param string $moduleID → module id
     *
     * @uses string App::$id → application ID
     *
     * @return boolean
     */
    public static function exists($moduleID) {

        return array_key_exists($moduleID, self::$instances[App::$id]);
    }

    /**
     * Get library path.
     *
     * @since 1.0.8
     *
     * @uses string App::DS → directory separator
     *
     * @return string → library path
     */
    public static function getLibraryPath() {

        return rtrim(dirname(dirname(__FILE__)), App::DS) . App::DS;
    }

    /**
     * Get library version.
     *
     * @since 1.0.8
     *
     * @uses string App::DS            → directory separator
     * @uses array Json::fileToArray() → convert json file to array
     *
     * @return string
     */
    public static function getLibraryVersion() {

        $path = self::getLibraryPath();

        $composer = Json::fileToArray($path . 'composer.json');

        return isset($composer['version']) ? $composer['version'] : '1.0.0';
    }

    /**
     * Receives the name of the module to execute: Module::ModuleName();
     *
     * @since 1.0.0
     *
     * @param string $index  → module name
     * @param array  $params → params
     *
     * @uses string App::$id → application ID
     *
     * @throws ModuleException → module not found
     *
     * @return object
     */
    public static function __callstatic($index, $params = false) {

        if (!array_key_exists($index, self::$instances[App::$id])) {

            $message = 'Module not found';

            throw new ModuleException($message . ': ' . $index . '.', 817);
        }

        self::$id = $index;

        $that = self::getInstance();

        if (!$params) { return $that; }

        $method = (isset($params[0])) ? $params[0] : '';
        $args   = (isset($params[1])) ? $params[1] : 0;

        if (method_exists($that, $method)) {

            return call_user_func_array([$that, $method], [$args]);
        }
    }

    /**
     * Get modules view.
     *
     * @since 1.0.8
     *
     * @param string $filter   → modules category to display
     * @param array  $external → urls of the external optional modules
     * @param string $sort     → PHP sorting function to modules sort
     *
     * @uses void ModuleView::_renderizate() → convert json file to array
     *
     * @return void
     */
    public static function render($filter='all', $external=0, $sort='asort') {

        $that = self::getInstance();

        $that->_renderizate($filter, $external, $sort);
    }
}
