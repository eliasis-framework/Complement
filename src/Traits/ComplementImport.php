<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Eliasis-Framework/Complement
 * @since      1.0.9
 */

namespace Eliasis\Complement\Traits;

use Eliasis\App\App,
    Josantonius\Json\Json,
    Josantonius\File\File;

/**
 * Complement import class.
 *
 * @since 1.0.9
 */
trait ComplementImport {

    /**
     * Check for new complement version.
     *
     * @since 1.0.9
     *
     * @return boolean
     */
    public function hasNewVersion() {

        return ($this->complement['version'] < $this->getRepositoryVersion());
    }

    /**
     * Get repository version.
     *
     * @since 1.0.9
     *
     * @uses array Complement->$complement → complement settings
     * @uses array Json::fileToArray       → file to array
     *
     * @return string → repository version
     */
    public function getRepositoryVersion() {

        $version = $this->complement['version'];

        isset($this->complement['config-url']) OR return $version;     

        File::exists($this->complement['config-url']) OR return $version; 

        $config = Json::fileToArray($this->complement['config-url']);

        $version = isset($config['version']) ? $config['version'] : $version;

        return $version;
    }

    /**
     * Complement installation handler.
     *
     * @since 1.0.9
     *
     * @uses string ComplementState->changeState() → change complement state
     * @uses array  Complement->$complement        → complement settings
     *
     * @return boolean
     */
    public function install() {

        if (!isset($this->complement['installation-files'])) {

            self::$errors[] = [

                'message' => $this->complement['path']['root']
            ];

            return false;
        }

        $this->_deleteDirectory();

        $this->changeState();

        $installed = $this->_installComplement(
                
            $this->complement['installation-files'],
            $this->complement['path']['root'],
            $this->complement['slug']
        );

        return ($installed) ? $this->changeState() : false;
    }

    /**
     * Delete complement.
     *
     * @since 1.0.9
     *
     * @uses string ComplementState->getState()    → get complement state
     * @uses string ComplementState->setState()    → set complement state
     * @uses string ComplementState->changeState() → change complement state
     *
     * @return string → complement state
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
     * Delete complement directory.
     *
     * @since 1.0.9
     *
     * @uses array   Complement->$complement      → complement settings
     * @uses array   Complement::$errors          → complement errors
     * @uses string  Complement::$type            → complement type
     * @uses boolean File::deleteDirRecursively() → delete directory
     *
     * @return string → complement state
     */
    private function _deleteDirectory() {

        $path = $this->complement['path']['root'];

        $this->_validateRoute($path) OR return false;

        $isUninstall = ($this->getState() === 'inactive');

        if (!File::deleteDirRecursively($path) && $isUninstall) {

            $type = ucfirst(self::$type);

            $msg = $type." doesn't exist in '$path' or couldn't be deleted.";

            self::$errors[] = ['message' => $msg];

            return false;
        } 

        return true;
    }

    /**
     * Install complement.
     *
     * @since 1.0.9
     *
     * @param array   $complement → complement files
     * @param string  $path       → complement path
     * @param string  $slug       → complement slug
     * @param boolean $root       → root folder
     *
     * @uses string  App::DS               → directory separator
     * @uses string  App::COMPLEMENT_URL() → complement url
     * @uses string  Complement::$type     → complement type
     * @uses boolean File::createDir()     → create directory
     *
     * @return boolean
     */
    private function _installComplement($complement, $path, $slug, $root = true) {

        $path = ($root) ? $path : $path . key($complement) . App::DS;

        $this->_validateRoute($path) OR return false;

        if (!File::createDir($path)) {

            $msg = "The directory exists or couldn't be created in: $path";

            self::$errors[] = ['message' => $msg];

            return false;
        }

        foreach ($complement as $folder => $file) {

            foreach ($file as $key => $val) {

                if (is_array($val)) {

                    $this->_installComplement([$key=>$val], $path, $slug, 0);

                    continue;  
                }
                
                $filePath = $path . $value;

                $complementType = strtoupper(self::$type);

                $complementPath = App::$complementType() . $slug . App::DS;

                $url = rtrim($this->complement['url-import'], '/');

                $route = str_replace($complementPath, '', $filePath);

                $fileUrl = $url . '/' . $route;

                $this->_saveRemoteFile($fileUrl, $filePath);
            }
        }

        return true;
    }

    /**
     * Save remote file.
     *
     * @since 1.0.9
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
     * Validate path to only install/remove complements in default directory.
     *
     * @since 1.0.9
     *
     * @param string $path → complement path
     *
     * @uses string App::COMPLEMENT() → complement path
     * @uses string Complement::$type → complement type
     *
     * @return boolean
     */
    private function _validateRoute($path) {

        $complementType = strtoupper(self::$type);

        $thePath = App::$complementType();

        if ($thePath == $path || strpos($path, $thePath) === false) {

            $msg = ucfirst(self::$type) . " path: '$path' isn't a valid.";

            self::$errors[] = ['message' => $msg];

            return false;
        }

        return true;
    }
}
