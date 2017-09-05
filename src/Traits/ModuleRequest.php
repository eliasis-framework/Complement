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
 * Module requests handler class.
 *
 * @since 1.0.8
 */
trait ModuleRequest {
                                                          
    /**
     * HTTP request handler.
     *
     * @since 1.0.8
     *
     * @uses string App::id() → set application id
     *
     * @return void
     */
    public static function requestHandler() {

        if (!isset($_GET['vue'], 
                   $_GET['app'], 
                   $_GET['external'], 
                   $_GET['request'])) { return; }

        App::id(filter_var($_GET['app'], FILTER_SANITIZE_STRING));

        self::_loadExternalModules();
        
        switch ($_GET['request']) {

            case 'load-modules':

                self::_modulesLoadRequest();

                break;

            case 'change-state':

                self::_changeStateRequest();

                break;

            case 'install':

                self::_installRequest();

                break;

            case 'uninstall':

                self::_uninstallRequest();

                break;

            default:

                self::$errors[] = [

                    'message' => 'Unknown request: ' . $_GET['request']
                ];

                break;
        }

        die;
    }
                                                                   
    /**
     * Load external modules.
     *
     * @since 1.0.8
     *
     * @uses array  Module->$instances   → module instances
     * @uses string App::$id             → application id
     * @uses void   Module::loadModule() → load module configuration
     * @uses array Module::$errors       → module errors
     *
     * @return void
     */
    private static function _loadExternalModules() {

        $external = json_decode($_GET['external'], true);

        $modules = array_keys(self::$instances[App::$id]);

        foreach ($external as $module => $url) {

            if (!in_array($module, $modules)) {

                if ($url = filter_var($url, FILTER_VALIDATE_URL)) {
                
                    self::loadModule($url);
                
                } else {

                    self::$errors[] = [

                        'message' => 'A valid url was not received: ' . $url
                    ];
                }
            }

            self::$module()->set('config-url', $url);
        }   
    }

    /**
     * Modules load request.
     *
     * @since 1.0.8
     *
     * @uses array Module::getModulesInfo() → get modules info
     * @uses array Module::$errors          → module errors
     *
     * @return void
     */
    private static function _modulesLoadRequest() {

        $modules = [];

        if (isset($_GET['filter'], $_GET['sort'])) {

            $sort   = filter_var($_GET['sort'],   FILTER_SANITIZE_STRING);
            $filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);

            $modules = self::getModulesInfo($filter, $sort);
        
        } else {

            $msg = 'The "filter" or "sort" parameter wasn\'t received.';

            self::$errors[] = ['message' => $msg];
        }

        echo json_encode([

            'modules' => $modules,
            'errors'  => self::$errors
        ]);
    }
                                                          
    /**
     * Change state request.
     *
     * @since 1.0.8
     *
     * @uses object Module::getInstance()      → get module instance
     * @uses string ModuleState->changeState() → change module state
     * @uses array  Module::$errors            → module errors
     *
     * @return void
     */
    private static function _changeStateRequest() {

        $state = false;

        if (isset($_GET['id'])) {

            self::$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

            $that = self::getInstance();

            $state = $that->changeState();
        
        } else {

            self::$errors[] = [

                'message' => 'The "id" parameter wasn\'t received.'
            ];
        }

        echo json_encode([

            'state'   => $state,
            'errors'  => self::$errors
        ]);
    }
                                                                     
    /**
     * Install request.
     *
     * @since 1.0.8
     *
     * @uses object Module::getInstance()                → get module instance
     * @uses string ModuleImport->install()              → install module
     * @uses string ModuleImport->getRepositoryVersion() → repository version
     * @uses array Module::$errors                       → module errors
     *
     * @return void
     */
    private static function _installRequest() {

        $state = false;

        if (isset($_GET['id'])) {

            self::$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

            $that = self::getInstance();

            $state = $that->install();
        
        } else {

            self::$errors[] = [

                'message' => 'The "id" parameter wasn\'t received.'
            ];
        }

        echo json_encode([

            'state'   => $state,
            'version' => Json::fileToArray($that->module['config-file'])['version'],
            'errors'  => self::$errors
        ]);
    }

    /**
     * Uninstall request.
     *
     * @since 1.0.8
     *
     * @uses object Module::getInstance()  → get module instance
     * @uses string ModuleImport->remove() → remove module
     * @uses array Module::$errors         → module errors
     *
     * @return void
     */
    private static function _uninstallRequest() {

        $state = false;

        if (isset($_GET['id'])) {

            self::$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

            $that = self::getInstance();

            $state = $that->remove();
        
        } else {

            self::$errors[] = [

                'message' => 'The "id" parameter wasn\'t received.'
            ];
        }

        echo json_encode([

            'state'  => $state,
            'errors' => self::$errors
        ]);
    }
}
