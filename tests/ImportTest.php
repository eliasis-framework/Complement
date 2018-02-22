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
 * Import handler tests.
 */
final class ImportTest extends TestCase
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
    }

    /**
     * Install complement.
     */
    public function testInstallComplement()
    {
        $type = $this->type;

        $complement = $this->complement;

        $complement::load($this->root . 'remote/remote-complement.jsond');

        $this->assertTrue(
            $complement::RemoteComplement()->install()
        );

        $this->assertTrue(
            File::exists($this->root . "{$type}s/remote-complement/composer.json")
        );

        $this->assertTrue(
            File::exists($this->root . "{$type}s/remote-complement/LICENSE")
        );

        $this->assertTrue(
            is_dir($this->root . "{$type}s/remote-complement/config/")
        );

        $this->assertTrue(
            is_dir($this->root . "{$type}s/remote-complement/public/")
        );

        $this->assertTrue(
            is_dir($this->root . "{$type}s/remote-complement/src/")
        );
    }

    /**
     * Remove complement.
     */
    public function testRemoveComplement()
    {
        $type = $this->type;

        $complement = $this->complement;

        $this->assertTrue(
            $complement::RemoteComplement()->remove()
        );

        $this->assertFalse(
            File::exists($this->root . "{$type}s/remote-complement/composer.json")
        );

        $this->assertFalse(
            File::exists($this->root . "{$type}s/remote-complement/LICENSE")
        );

        $this->assertFalse(
            is_dir($this->root . "{$type}s/remote-complement/config/")
        );

        $this->assertFalse(
            is_dir($this->root . "{$type}s/remote-complement/public/")
        );

        $this->assertFalse(
            is_dir($this->root . "{$type}s/remote-complement/src/")
        );
    }
}
