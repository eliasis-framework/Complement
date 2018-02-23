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
 * Get and set options.
 */
final class OptionTest extends TestCase
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
     * Set string option.
     */
    public function testSetStringOption()
    {
        $complement = $this->complement;

        $string = 'test-value';

        $this->assertSame(
            $string,
            $complement::BasicLocalComplement()->setOption('test', $string)
        );
    }

    /**
     * Set array option.
     */
    public function testSetArrayOption()
    {
        $complement = $this->complement;

        $array = ['array' => 'test-value'];

        $this->assertSame(
            $array,
            $complement::BasicLocalComplement()->setOption('test', $array)
        );
    }

    /**
     * Set boolean option.
     */
    public function testSetBooleanOption()
    {
        $complement = $this->complement;

        $value = true;

        $this->assertSame(
            $value,
            $complement::BasicLocalComplement()->setOption('test', $value)
        );
    }

    /**
     * Set int option.
     */
    public function testSetIntOption()
    {
        $complement = $this->complement;

        $value = 8;

        $this->assertSame(
            $value,
            $complement::BasicLocalComplement()->setOption('test', $value)
        );
    }

    /**
     * Set options from multiple complements.
     */
    public function testSetOptionsFromMultipleComplements()
    {
        $complement = $this->complement;

        $value = 'Hello from BasicLocalComplement complement';

        $this->assertSame(
            $value,
            $complement::BasicLocalComplement()->setOption('test', $value)
        );

        $value = 'Hello from AdvancedLocalComplement complement';

        $this->assertSame(
            $value,
            $complement::AdvancedLocalComplement()->setOption('test', $value)
        );
    }

    /**
     * Get default options from get method.
     *
     * FROM PATHS: "/Complement/config/" & "/Complement/tests/sample-app/config/".
     */
    public function testGetDefaultOptionsFromGetMethod()
    {
        $app = $this->app;

        $type = ucwords($this->type);

        $complement = $this->complement;

        $this->assertSame(
            'advanced-local-complement',
            $complement::AdvancedLocalComplement()->getOption('slug')
        );

        $this->assertSame(
            'AdvancedLocalComplement\\Controller\\',
            $complement::AdvancedLocalComplement()->getOption('namespaces', 'controller')
        );

        $this->assertSame(
            $app::$type() . 'advanced-local-complement/src/template/layout/',
            $complement::AdvancedLocalComplement()->getOption('path', 'layout')
        );

        $this->assertSame(
            $app::$type() . 'advanced-local-complement/src/template/page/',
            $complement::AdvancedLocalComplement()->getOption('path', 'page')
        );
    }

    /**
     * Get options from multiple complements.
     */
    public function testGetOptionsFromMultipleComplements()
    {
        $complement = $this->complement;

        $value = 'Hello from BasicLocalComplement complement';
        $complement::BasicLocalComplement()->setOption('test', $value);

        $value = 'Hello from AdvancedLocalComplement complement';
        $complement::AdvancedLocalComplement()->setOption('test', $value);

        $this->assertSame(
            'Hello from BasicLocalComplement complement',
            $complement::BasicLocalComplement()->getOption('test')
        );

        $this->assertSame(
            'Hello from AdvancedLocalComplement complement',
            $complement::AdvancedLocalComplement()->getOption('test')
        );
    }
}
