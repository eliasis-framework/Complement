<?php
/**
 * Tests for Eliasis Complement.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - Eliasis Complement
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/complement
 * @since     1.1.1
 */
namespace Eliasis\Complement;

use Eliasis\Framework\App;
use PHPUnit\Framework\TestCase;

/**
 * Version handler tests.
 */
final class VersionTest extends TestCase
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
     * Get repository version.
     */
    public function testGetRepositoryVersion()
    {
        $complement = $this->complement;

        $complement::load($this->root . 'remote/remote-complement.jsond');

        $this->assertSame(
            '3.0.0',
            $complement::RemoteComplement()->getRepositoryVersion()
        );
    }

    /**
     * Check for new complement version.
     */
    public function testHasNewVersion()
    {
        $complement = $this->complement;

        $this->assertFalse($complement::RemoteComplement()->hasNewVersion());
    }
}
