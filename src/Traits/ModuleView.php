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
    Eliasis\View\View;

/**
 * Module view handler.
 *
 * @since 1.0.8
 */
trait ModuleView {

    /**
     * Creating files (css/js/php) in custom locations.
     *
     * @since 1.0.8
     *
     * @param string $filename → file name
     * @param string $type     → script|style
     * @param string $pathUrl  → path url where file will be created
     *
     * @uses string App::DS                     → directory separator
     * @uses string App::get()                  → get option
     * @uses string Module::getLibraryPath()    → get library path
     * @uses string Module::getLibraryVersion() → get library version
     * @uses string ModuleImport::_createdir()  → create directory
     *
     * @return string → file url
     */
    private function _setFile($filename, $type, $pathUrl) {

        $DS = App::DS;

        $ext = ($type == 'script') ? 'js' : 'css';

        $documentRoot = $_SERVER["DOCUMENT_ROOT"];
        
        $url = $pathUrl ?: App::get('url', $ext);

        $url = empty($url) ? App::PUBLIC_URL() . $ext . '/' : $url;

        $version = str_replace(".", "-", self::getLibraryVersion());

        $path = rtrim($documentRoot.parse_url($url)['path'], $DS) . $DS;

        if (!file_exists($toPath = $path . "$filename-$version.$ext")) {

            self::_createDir($path);

            $path = self::getLibraryPath();

            $fromPath = $path . 'public' .$DS. $ext .$DS. "$filename.$ext";

            $file = file_get_contents($fromPath);

            file_put_contents($toPath, $file);
        }

        return rtrim($url, '/') . '/' . "$filename-$version.$ext";
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
     * @uses string App::$id                 → application id
     * @uses string App::DS                  → directory separator
     * @uses string Module::getLibraryPath() → get library path
     * @uses object View:getInstance()       → View instance
     * @uses void   View:renderizate()       → render view
     *
     * @return void
     */
    private function _renderizate($filter, $external, $sort) {

        $data = [

            'app'      => App::$id,
            'filter'   => $filter,
            'external' => urlencode(json_encode($external, true)),
            'sort'     => $sort,
        ];

        $View = View::getInstance();

        $path = self::getLibraryPath();

        $template = $path . 'public' . App::DS . 'template' . App::DS;

        $View->renderizate($template, 'eliasis-module', $data);
    }
}
