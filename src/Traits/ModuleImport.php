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
    Josantonius\Json\Json,
    Josantonius\File\File;

/**
 * Module import class.
 *
 * @since 1.0.8
 */
trait ModuleImport {

    /**
     * Check for new module version.
     *
     * @since 1.0.8
     *
     * @return boolean
     */
    public function hasNewVersion() {

        return ($this->module['version'] < $this->getRepositoryVersion());
    }

    /**
     * Get repository version.
     *
     * @since 1.0.8
     *
     * @uses array Module->$module   → module settings
     * @uses array Json::fileToArray → file to array
     *
     * @return string → repository version
     */
    public function getRepositoryVersion() {

        $version = $this->module['version'];

        if (!isset($this->module['config-url'])) { return $version; }     

        if (!File::exists($this->module['config-url'])) { return $version; }

        $config = Json::fileToArray($this->module['config-url']);

        $version = isset($config['version']) ? $config['version'] : $version;

        return $version;
    }

    /**
     * Module installation handler.
     *
     * @since 1.0.8
     *
     * @uses string ModuleState->changeState() → change module state
     * @uses array  Module->$module            → module settings
     *
     * @return boolean
     */
    public function install() {

        if (!isset($this->module['installation-files'])) {

            self::$errors[] = [

                'message' => $this->module['path']['root']
            ];

            return false;
        }

        $this->_deleteDirectory();

        $this->changeState();

        $installed = $this->_installModule(
                
            $this->module['installation-files'],
            $this->module['path']['root'],
            $this->module['slug']
        );

        return ($installed) ? $this->changeState() : false;
    }

    /**
     * Delete module.
     *
     * @since 1.0.8
     *
     * @uses string ModuleState->getState()    → get module state
     * @uses string ModuleState->setState()    → set module state
     * @uses string ModuleState->changeState() → change module state
     *
     * @return string → module state
     */
    public function remove() {

        $state = $this->getState();

        if (!$this->_deleteDirectory()) {

            $state = $this->setState('uninstalled');
        
        } else {

            $this->setState('uninstall');

            $state = $this->changeState();
        }

        return $state;
    }

    /**
     * Delete module directory.
     *
     * @since 1.0.8
     *
     * @uses array   Module->$module              → module settings
     * @uses array   Module::$errors              → module errors
     * @uses boolean File::deleteDirRecursively() → delete directory
     *
     * @return string → module state
     */
    private function _deleteDirectory() {

        $path = $this->module['path']['root'];

        if (!$this->_validateRoute($path)) { return false; }

        $isUninstall = ($this->getState() === 'inactive');

        if (!File::deleteDirRecursively($path) && $isUninstall) {

            $msg = "Module doesn't exist in '$path' or couldn't be deleted.";

            self::$errors[] = ['message' => $msg];

            return false;
        } 

        return true;
    }

    /**
     * Install module.
     *
     * @since 1.0.8
     *
     * @param array   $module → module files
     * @param string  $path   → module path
     * @param string  $slug   → module slug
     * @param boolean $root   → root folder
     *
     * @uses string  App::DS           → directory separator
     * @uses boolean File::createDir() → create directory
     *
     * @return boolean
     */
    private function _installModule($module, $path, $slug, $root = true) {

        $path = ($root) ? $path : $path . key($module) . App::DS;

        if (!$this->_validateRoute($path)) { return false; }

        if (!File::createDir($path)) {

            $msg = "The directory exists or couldn't be created in: $path";

            self::$errors[] = ['message' => $msg];

            return false;
        }

        foreach ($module as $folder => $file) {

            foreach ($file as $key => $value) {

                if (is_array($value)) {

                    $this->_installModule([$key => $value], $path, $slug, 0);

                    continue;  
                }
                
                $filePath = $path . $value;

                $modulePath = App::MODULES() . $slug . App::DS;

                $route = str_replace($modulePath, '', $filePath);

                $fileUrl = rtrim($this->module['url-import'], '/')."/$route";

                $this->_saveRemoteFile($fileUrl, $filePath);
            }
        }

        return true;
    }

    /**
     * Save remote file.
     *
     * @since 1.0.8
     *
     * @param string $fileUrl  → remote file url
     * @param string $filePath → file path to save
     *
     * @return boolean
     */
    private function _saveRemoteFile($fileUrl, $filePath) {
         
        if (!$file = @file_get_contents($fileUrl)) {

            self::$errors[] = [

                'message' => 'Error to download file: ' . $fileUrl
            ];

            return false;
        }

        if (!@file_put_contents($filePath, $file)) {

            self::$errors[] = [

                'message' => 'Failed to save file to: ' . $filePath
            ];

            return false;
        }

        return true;
    }

    /**
     * Validate path to only install/remove modules in the default directory.
     *
     * @since 1.0.8
     *
     * @param string $path → module path
     *
     * @uses string App::MODULES() → modules path
     *
     * @return boolean
     */
    private function _validateRoute($path) {

        $modulesPath = App::MODULES();

        if ($modulesPath == $path || strpos($path, $modulesPath) === false) {

            self::$errors[] = [

                'message' => "The module path: '$path' isn't a valid route."
            ];

            return false;
        }

        return true;
    }
}
