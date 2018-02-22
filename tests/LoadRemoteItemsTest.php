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
 * Tests for remote complements.
 */
final class LoadRemoteItemsTest extends TestCase
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
     * Remote complements.
     *
     * @var string
     */
    protected $remote;

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

        $type = $this->type;

        File::delete($this->root . "{$type}s/.{$type}s-states.jsond");

        $app::run($this->root);
    }

    /**
     * Load remote complement.
     *
     * tests/sample-app/remote/
     */
    public function loadRemoteComplement()
    {
        $complement = $this->complement;

        $this->assertCount(2, $complement::getList());

        $this->assertTrue(
            $complement::load(
                $this->root . 'remote/remote-complement.jsond'
            )
        );

        $this->assertCount(3, $complement::getList());

        $complement::exists('BasicLocalComplement');
        $complement::exists('AdvancedLocalComplement');
        $complement::exists('RemoteComplement');
    }

    /**
     * Load wrong remote complement.
     *
     * tests/sample-app/remote/
     *
     * @expectedException \Eliasis\Complement\Exception\ComplementException
     */
    public function testLoadWrongRemoteComplement()
    {
        $complement = $this->complement;

        $complement::load(
            $this->root . 'remote/wrong-configuration.jsond'
        );
    }
}
