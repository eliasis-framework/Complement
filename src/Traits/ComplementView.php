<?php
/**
 * PHP library for adding addition of complements for Eliasis Framework.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Eliasis-Framework/Complement
 * @since     1.0.9
 */
namespace Eliasis\Complement\Traits;

use Eliasis\Framework\App;
use Eliasis\Framework\View;
use Josantonius\File\File;

/**
 * Complement view handler.
 */
trait ComplementView
{
    /**
     * Creating files (css/js/php) in custom locations.
     *
     * @param string $filename → file name
     * @param string $type     → script|style
     * @param string $pathUrl  → path url where file will be created
     *
     * @uses \Eliasis\Framework\App::getOption()
     * @uses \Eliasis\Complement\Complement::getLibraryPath()
     * @uses \Eliasis\Complement\Complement::getLibraryVersion()
     * @uses \Eliasis\Complement\Traits\ComplementImport::createdir()
     *
     * @return string → file url
     */
    private function _setFile($filename, $type, $pathUrl)
    {
        $ext = ($type == 'script') ? 'js' : 'css';
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $url = $pathUrl ?: App::getOption('url', $ext);
        $url = empty($url) ? App::PUBLIC_URL() . $ext . '/' : $url;
        $version = str_replace('.', '-', self::getLibraryVersion());
        $path = Url::addBackSlash($documentRoot . parse_url($url)['path']);

        if (! file_exists($toPath = $path . "$filename-$version.$ext")) {
            File::createDir($path);

            $path = self::getLibraryPath();
            $from = $path . 'src/public/' . $ext . "/$filename.$ext";
            $file = file_get_contents($from);

            file_put_contents($toPath, $file);
        }

        return Url::addBackSlash($url) . "$filename-$version.$ext";
    }

    /**
     * Get complements view.
     *
     * @param string $filter   → complements category to display
     * @param array  $external → urls of the external optional complements
     * @param string $sort     → PHP sorting function to complements sort
     *
     * @uses \Eliasis\Framework\App::getCurrentID()
     * @uses \Eliasis\Complement\Complement::getLibraryPath()
     * @uses \Eliasis\Complement\Traits\ComplementHandler::getType()
     * @uses \Eliasis\Framework\View:getInstance()
     * @uses \Eliasis\Framework\View:renderizate()
     */
    private function _renderizate($filter, $external, $sort)
    {
        $data = [
            'app' => App::getCurrentID(),
            'complement' => self::getType('strtolower', false),
            'filter' => $filter,
            'language' => $this->getLanguage(),
            'external' => urlencode(json_encode($external, true)),
            'sort' => $sort,
        ];

        $View = View::getInstance();
        $path = self::getLibraryPath();

        $template = $path . 'src/public/template/';

        $View->renderizate($template, 'eliasis-complement', $data);
    }
}
