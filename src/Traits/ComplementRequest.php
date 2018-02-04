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
use Josantonius\Json\Json;

/**
 * Complement requests handler class.
 */
trait ComplementRequest
{
    /**
     * HTTP request handler.
     *
     * @param string $complementType → complement type
     *
     * @uses \Eliasis\Framework\App::setCurrentID()
     */
    public static function requestHandler($complementType)
    {
        if (! isset(
            $_GET['vue'],
            $_GET['app'],
            $_GET['external'],
            $_GET['request'],
            $_GET['complement']
        )) {
            return;
        }

        if ($_GET['complement'] !== $complementType) {
            return;
        }

        App::setCurrentID(filter_var($_GET['app'], FILTER_SANITIZE_STRING));

        self::loadExternalComplements();

        switch ($_GET['request']) {
            case 'load-complements':
                self::complementsLoadRequest();

                break;
            case 'change-state':
                self::changeStateRequest();

                break;
            case 'install':
                self::installRequest();

                break;
            case 'uninstall':
                self::uninstallRequest();

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
     * Load external complements.
     *
     * @uses \Eliasis\Complement\Complement->$instances
     * @uses \Eliasis\Complement\Complement::load()
     * @uses \Eliasis\Complement\Complement::$errors
     */
    private static function loadExternalComplements()
    {
        $currentID = App::getCurrentID();
        $complement = self::getType();
        $external = json_decode($_GET['external'], true);

        $complements = array_keys(self::$instances[$currentID][$complement]);

        foreach ($external as $complement => $url) {
            if (! in_array($complement, $complements, true)) {
                if ($url = filter_var($url, FILTER_VALIDATE_URL)) {
                    self::load($url);
                } else {
                    self::$errors[] = [
                        'message' => 'A valid url wasn\'t received: ' . $url
                    ];
                }
            }

            self::$complement()->set('config-url', $url);
        }
    }

    /**
     * Complements load request.
     *
     * @uses \Eliasis\Complement\Complement::getInfo()
     * @uses \Eliasis\Complement\Complement::$errors
     */
    private static function complementsLoadRequest()
    {
        $complements = [];

        if (isset($_GET['filter'], $_GET['sort'])) {
            $sort = filter_var($_GET['sort'], FILTER_SANITIZE_STRING);
            $filter = filter_var($_GET['filter'], FILTER_SANITIZE_STRING);

            $complements = self::getInfo($filter, $sort);
        } else {
            $msg = 'The "filter" or "sort" parameter wasn\'t received.';
            self::$errors[] = ['message' => $msg];
        }

        echo json_encode([
            'complements' => $complements,
            'errors' => self::$errors
        ]);
    }

    /**
     * Change state request.
     *
     * @uses \Eliasis\Complement\Complement::getInstance()
     * @uses \Eliasis\Complement\Traits\ComplementState->changeState()
     * @uses \Eliasis\Complement\Complement::$errors
     */
    private static function changeStateRequest()
    {
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
            'state' => $state,
            'errors' => self::$errors
        ]);
    }

    /**
     * Install request.
     *
     * @uses \Eliasis\Complement\Complement::getInstance()
     * @uses \Eliasis\Complement\Traits\ComplementImport->install()
     * @uses \Eliasis\Complement\Complement::$errors
     */
    private static function installRequest()
    {
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

        $config = Json::fileToArray($that->complement['config-file']);

        echo json_encode([
            'state' => $state,
            'version' => $config['version'],
            'errors' => self::$errors
        ]);
    }

    /**
     * Uninstall request.
     *
     * @uses \Eliasis\Complement\Complement::getInstance()
     * @uses \string ComplementImport->remove()
     * @uses \Eliasis\Complement\Complement::$errors
     */
    private static function uninstallRequest()
    {
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
            'state' => $state,
            'errors' => self::$errors
        ]);
    }
}
