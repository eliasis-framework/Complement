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
 * View of the module manager.
 */
final class RenderTest extends TestCase
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

        $type = $this->type;

        File::delete($this->root . "{$type}s/.{$type}s-states.jsond");

        $app::run($this->root);
    }

    /**
     * Set and get url for full script.
     *
     * If no url path is specified, will be used the setting in the configuration files:
     *
     * sample-app/public/js/
     */
    public function testSetAndGetScriptWithoutParams()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "vue+vue-resource+eliasis-complement.min-$version.js";

        $this->assertSame($complement::script(), 'http://example.org/public/js/' . $file);

        $this->assertTrue(File::exists($this->root . 'public/js/' . $file));

        File::delete($this->root . 'public/js/' . $file);
    }

    /**
     * Set and get url for full script with custom path url.
     */
    public function testSetAndGetScriptWithCustomPathUrl()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "vue+vue-resource+eliasis-complement.min-$version.js";

        $this->assertSame(
            $complement::script('http://example.org/public/js/'),
            'http://example.org/public/js/' . $file
        );

        $this->assertTrue(File::exists($this->root . 'public/js/' . $file));

        File::delete($this->root . 'public/js/' . $file);
    }

    /**
     * Set and get url for script without Vue without VueResource.
     *
     * If no url path is specified, will be used the setting in the configuration files:
     *
     * sample-app/public/js/
     */
    public function testSetAndGetScriptWithoutVueWithoutVueResource()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "eliasis-complement.min-$version.js";

        $this->assertSame(
            $complement::script(null, false, false),
            'http://example.org/public/js/' . $file
        );

        $this->assertTrue(File::exists($this->root . 'public/js/' . $file));

        File::delete($this->root . 'public/js/' . $file);
    }

    /**
     * Set and get url for script with Vue without VueResource.
     *
     * If no url path is specified, will be used the setting in the configuration files:
     *
     * sample-app/public/js/
     */
    public function testSetAndGetScriptWithVueWithoutVueResource()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "vue+eliasis-complement.min-$version.js";

        $this->assertSame(
            $complement::script(null, true, false),
            'http://example.org/public/js/' . $file
        );

        $this->assertTrue(File::exists($this->root . 'public/js/' . $file));

        File::delete($this->root . 'public/js/' . $file);
    }

    /**
     * Set and get url for script without Vue with VueResource.
     *
     * If no url path is specified, will be used the setting in the configuration files:
     *
     * sample-app/public/js/
     */
    public function testSetAndGetScriptWithoutVueWithVueResource()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "vue-resource+eliasis-complement.min-$version.js";

        $this->assertSame(
            $complement::script(null, false, true),
            'http://example.org/public/js/' . $file
        );

        $this->assertTrue(File::exists($this->root . 'public/js/' . $file));

        File::delete($this->root . 'public/js/' . $file);
    }

    /**
     * Set and get url for styles.
     *
     * If no url path is specified, will be used the setting in the configuration files:
     *
     * sample-app/public/css/
     */
    public function testSetAndGetStyleWithoutParams()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "eliasis-complement.min-$version.css";

        $this->assertSame($complement::style(), 'http://example.org/public/css/' . $file);

        $this->assertTrue(File::exists($this->root . 'public/css/' . $file));

        File::delete($this->root . 'public/css/' . $file);
    }

    /**
     * Set and get url for style with custom path url.
     */
    public function testSetAndGetStyleWithCustomPathUrl()
    {
        $complement = $this->complement;

        $version = str_replace('.', '-', $complement::getLibraryVersion());

        $file = "eliasis-complement.min-$version.css";

        $this->assertSame(
            $complement::style('http://example.org/public/css/'),
            'http://example.org/public/css/' . $file
        );

        $this->assertTrue(File::exists($this->root . 'public/css/' . $file));

        File::delete($this->root . 'public/css/' . $file);
    }

    /**
     * Renderizate complements by default.
     */
    public function testRender()
    {
        $type = $this->type;

        $complement = $this->complement;

        ob_start();

        $this->assertTrue($complement::render());

        $default = ob_get_contents();

        ob_end_clean();

        $this->assertContains('"app":"Default"', $default);
        $this->assertContains('"id":null', $default);
        $this->assertContains('"state":null', $default);
        $this->assertContains('"request":"load-complements"', $default);
        $this->assertContains("\"complement\":\"$type\"", $default);
        $this->assertContains('"filter":"all"', $default);
        $this->assertContains('"language":"en"', $default);
        $this->assertContains('"remote":null', $default);
        $this->assertContains('"nonce"', $default);
        $this->assertContains('"sort":"asort"', $default);
        $this->assertContains('"translations"', $default);
        $this->assertContains('"active":"active"', $default);
        $this->assertContains('"activate":"activate"', $default);
        $this->assertContains('"install":"install"', $default);
        $this->assertContains('"update":"update"', $default);
        $this->assertContains('"uninstall":"uninstall"', $default);
        $this->assertContains('vue-simple-notify', $default);
        $this->assertContains('vue-module-manager', $default);
    }
}
