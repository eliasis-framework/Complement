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
 * Validate configuration files.
 */
final class ConfigurationFileTest extends TestCase
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
     * If basic configuration file have been loaded correctly.
     *
     * tests/sample-app/[complement]/basic-local-complement/
     */
    public function testIfBasicConfigurationFileWasLoadedCorrectly()
    {
        $type = $this->type;

        File::delete($this->root . "{$type}s/.{$type}s-states.jsond");

        $complement = $this->complement;

        $complements = $complement::getList();
        $this->assertCount(2, $complements);

        $complement = $complements['BasicLocalComplement'];
        $this->assertCount(16, $complement);

        $this->assertSame($complement['id'], 'BasicLocalComplement');
        $this->assertSame($complement['name'], 'Basic Local Complement');
        $this->assertSame($complement['version'], '1.0.0');
        $this->assertContains('Basic Local Complement', $complement['description']);
        $this->assertSame($complement['state'], 'inactive');
        $this->assertSame($complement['category'], 'basic-local-complement');
        $this->assertContains('basic-local-complement', $complement['path']);
        $this->assertSame($complement['url'], 'https://github.com/Josantonius/');
        $this->assertSame($complement['author'], '');
        $this->assertSame($complement['author-url'], '');
        $this->assertSame($complement['license'], 'MIT');
        $this->assertSame($complement['slug'], 'basic-local-complement');
        $this->assertContains('src/static/images/default.png', $complement['image']);
        $this->assertSame($complement['hooks-controller'], 'Launcher');
        $this->assertSame($complement['url-import'], '');
        $this->assertSame($complement['extra'], []);
    }

    /**
     * If advanced configuration file have been loaded correctly.
     *
     * tests/sample-app/[complements]/advanced-local-complement/
     */
    public function testIfAdvancedConfigurationFileWasLoadedCorrectly()
    {
        $complement = $this->complement;

        $complements = $complement::getList();
        $this->assertCount(2, $complements);

        $complement = $complements['AdvancedLocalComplement'];
        $this->assertCount(16, $complement);

        $this->assertSame($complement['id'], 'AdvancedLocalComplement');
        $this->assertSame($complement['name'], 'Advanced Local Complement');
        $this->assertSame($complement['version'], '2.0.0');
        $this->assertContains('Advanced Local Complement', $complement['description']);
        $this->assertSame($complement['state'], 'active');
        $this->assertSame($complement['category'], 'advanced-local-complement');
        $this->assertContains('advanced-local-complement', $complement['path']);
        $this->assertSame($complement['url'], 'https://github.com/Josantonius/');
        $this->assertSame($complement['author'], 'Josantonius');
        $this->assertSame($complement['author-url'], 'https://josantonius.com/');
        $this->assertSame($complement['license'], 'GPL-2.0+');
        $this->assertSame($complement['slug'], 'advanced-local-complement');
        $this->assertContains('src/static/images/default.png', $complement['image']);
        $this->assertSame($complement['hooks-controller'], 'Hooks');
        $this->assertSame($complement['url-import'], '');

        $this->assertCount(3, $complement['extra']);

        $this->assertArrayHasKey('a-custom-field', $complement['extra']);
        $this->assertArrayHasKey('another-custom-field', $complement['extra']);
        $this->assertArrayHasKey('more-custom-fields', $complement['extra']);
    }

    /**
     * If remote configuration file have been loaded correctly.
     *
     * tests/sample-app/remote/
     */
    public function testIfRemoteConfigurationFileWasLoadedCorrectly()
    {
        $complement = $this->complement;

        $this->assertTrue(
            $complement::load(
                $this->root . 'remote/remote-complement.jsond'
            )
        );

        $complements = $complement::getList();
        $this->assertCount(3, $complements);

        $complement = $complements['RemoteComplement'];
        $this->assertCount(16, $complement);

        $this->assertSame($complement['id'], 'RemoteComplement');
        $this->assertSame($complement['name'], 'Remote Complement');
        $this->assertSame($complement['version'], '3.0.0');
        $this->assertContains('Remote Complement', $complement['description']);
        $this->assertSame($complement['state'], 'uninstalled');
        $this->assertSame($complement['category'], 'remote-complement');
        $this->assertContains('remote-complement', $complement['path']);
        $this->assertSame($complement['url'], 'https://github.com/Josantonius/');
        $this->assertSame($complement['author'], '');
        $this->assertSame($complement['author-url'], '');
        $this->assertSame($complement['license'], 'MIT');
        $this->assertSame($complement['slug'], 'remote-complement');
        $this->assertContains('src/static/images/default.png', $complement['image']);
        $this->assertSame($complement['hooks-controller'], 'Launcher');
        $this->assertContains('raw.githubusercontent.com', $complement['url-import']);

        $this->assertSame($complement['extra'], []);
    }
}
