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
use Josantonius\Hook\Hook;
use PHPUnit\Framework\TestCase;

/**
 * Test optional external libraries.
 */
final class ExtenalLibraryTest extends TestCase
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
     * Validate if hooks were added.
     */
    public function testCheckIfHooksWereAdded()
    {
        $this->assertTrue(
            Hook::isAction('css')
        );

        $this->assertTrue(
            Hook::isAction('js')
        );

        ob_start();

        Hook::doAction('js');

        $js = ob_get_contents();

        Hook::doAction('css');

        $css = ob_get_contents();

        ob_end_clean();

        $this->assertContains('<script></script>', $js);

        $this->assertContains('<style></style>', $css);
    }

    /**
     * Validate if routes were added.
     *
     * Simulate https://josantonius.com/my-route/.
     *
     * Response from 'AdvancedLocalComplement\Controller\Home->routes()' method.
     */
    public function testCheckIfRoutesWereAdded()
    {
        $app = $this->app;

        $_SERVER['REQUEST_URI'] = '/my-route/';

        ob_start();

        $app::run($this->root);

        $routeContent = ob_get_contents();

        ob_end_clean();

        $this->assertContains('The routes were loaded correctly', $routeContent);

        $_SERVER['REQUEST_URI'] = '/sample-app/';
    }
}
