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
use Josantonius\File\File;
use Josantonius\Json\Json;
use PHPUnit\Framework\TestCase;

/**
 * Validate local complements load from Eliasis Framework.
 */
final class LoadLocalItemsFromEliasisTest extends TestCase
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
     * If all complements have been loaded from the default directory:
     *
     * tests/sample-app/[complements]/
     */
    public function testIfAllComplementsWasLoaded()
    {
        $complement = $this->complement;

        $this->assertTrue($complement::exists('BasicLocalComplement'));
        $this->assertTrue($complement::exists('AdvancedLocalComplement'));
    }

    /**
     * If the configuration file that saves statuses and actions is generated correctly.
     *
     * tests/sample-app/[complements]/
     */
    public function testIfConfigurationFileWasGeneratedCorrectly()
    {
        $type = $this->type;

        $file = $this->root . "{$type}s/.{$type}s-states.jsond";
        $complementsStates = Json::fileToArray($file)['Default'];

        $this->assertCount(2, $complementsStates);

        $this->assertArrayHasKey('BasicLocalComplement', $complementsStates);
        $this->assertSame($complementsStates['BasicLocalComplement']['action'], '');
        $this->assertSame($complementsStates['BasicLocalComplement']['state'], 'inactive');

        $this->assertArrayHasKey('AdvancedLocalComplement', $complementsStates);
        $this->assertSame($complementsStates['AdvancedLocalComplement']['action'], '');
        $this->assertSame($complementsStates['AdvancedLocalComplement']['state'], 'active');
    }
}
