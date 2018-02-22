<?php
/**
 * Tests for Eliasis Complement.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Eliasis-Framework/Complement
 * @since     1.1.1
 */
namespace Eliasis\Complement;

use Eliasis\Framework\App;
use Josantonius\File\File;
use PHPUnit\Framework\TestCase;

/**
 * Requests handler tests.
 */
final class RequestTest extends TestCase
{
    /**
     * App instance.
     *
     * @var object
     */
    protected $app;

    /**
     * Instance of the complement.
     *
     * @var object
     */
    protected $complement;

    /**
     * Complement type.
     *
     * @var string
     */
    protected $type;

    /**
     * Root path.
     *
     * @var string
     */
    protected $root;

    /**
     * Set up.
     */
    public function setUp()
    {
        global $argv;

        parent::setUp();

        $this->root = $_SERVER['DOCUMENT_ROOT'];

        $type = isset($argv[2]) ? ucfirst($argv[2]) : 'Component';

        $this->type = strtolower($type);

        $class = "Eliasis\\Complement\\Type\\$type";

        $this->app = new App();

        $this->complement = new $class();

        $this->assertInstanceOf($class, $this->complement);

        $app = $this->app;

        $app::run($this->root);

        $_POST['id'] = '';
        $_POST['app'] = 'Default';
        $_POST['external'] = [];
        $_POST['request'] = 'load-complements';
        $_POST['complement'] = $type;
        $_POST['nonce'] = 'test_nonce';
        $_POST['filter'] = 'all';
        $_POST['sort'] = 'asort';
        $_SESSION['efc'] = 'test_nonce';
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
    }

    /**
     * Load local complements.
     */
    public function testLoadLocalComplements()
    {
        $complement = $this->complement;

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertSame('AdvancedLocalComplement', $array['complements'][0]['id']);

        $this->assertSame('BasicLocalComplement', $array['complements'][1]['id']);
    }

    /**
     * Load local and remote complements.
     */
    public function testLoadLocalAndRemoteComplements()
    {
        $complement = $this->complement;

        $complement::load($this->root . 'remote/remote-complement.jsond');

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertCount(3, $array['complements']);

        $this->assertSame('AdvancedLocalComplement', $array['complements'][0]['id']);

        $this->assertSame('BasicLocalComplement', $array['complements'][1]['id']);

        $this->assertSame('RemoteComplement', $array['complements'][2]['id']);

        $type = $this->type;

        File::delete($this->root . "{$type}s/.{$type}s-states.jsond");
    }

    /**
     * Change state request.
     */
    public function testChangeState()
    {
        $_POST['id'] = 'BasicLocalComplement';
        $_POST['request'] = 'change-state';

        $complement = $this->complement;

        $this->assertSame('inactive', $complement::BasicLocalComplement()->getState());

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $this->assertSame('active', $complement::BasicLocalComplement()->getState());

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertSame('active', $array['state']);
    }

    /**
     * Install complement request.
     */
    public function testInstall()
    {
        $_POST['id'] = 'RemoteComplement';
        $_POST['request'] = 'install';

        $complement = $this->complement;

        $complement::load($this->root . 'remote/remote-complement.jsond');

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertCount(16, $array['complement']);
    }

    /**
     * Update complement request.
     */
    public function testUpdate()
    {
        $_POST['id'] = 'RemoteComplement';
        $_POST['request'] = 'update';

        $complement = $this->complement;

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertCount(16, $array['complement']);
    }

    /**
     * Uninstall complement request.
     */
    public function testUninstall()
    {
        $_POST['id'] = 'RemoteComplement';
        $_POST['request'] = 'uninstall';

        $complement = $this->complement;

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(0, $array['errors']);

        $this->assertSame('uninstalled', $array['state']);

        $type = $this->type;

        File::delete($this->root . "{$type}s/.{$type}s-states.jsond");
    }

    /**
     * Invalid request.
     */
    public function testInvalidRequest()
    {
        $_POST['request'] = 'unknown';

        $complement = $this->complement;

        ob_start();

        $complement::requestHandler(ucfirst($this->type));

        $json = ob_get_contents();

        ob_end_clean();

        $array = json_decode($json, true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertCount(1, $array['errors']);
    }

    /**
     * Invalid nonce.
     */
    public function testInvalidNonce()
    {
        $_POST['nonce'] = 'unknown';

        $complement = $this->complement;

        $this->assertFalse(
            $complement::requestHandler(ucfirst($this->type))
        );
    }

    /**
     * Invalid XMLHttpRequest.
     */
    public function testXMLHttpRequestInvalid()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = '';

        $complement = $this->complement;

        $this->assertFalse(
            $complement::requestHandler(ucfirst($this->type))
        );
    }

    /**
     * Invalid post params.
     */
    public function testInvalidPostParams()
    {
        $complement = $this->complement;

        unset($_POST);

        $this->assertFalse(
            $complement::requestHandler(ucfirst($this->type))
        );
    }
}
