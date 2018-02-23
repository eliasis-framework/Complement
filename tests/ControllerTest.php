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
 * Get complements lists.
 */
final class ControllerTest extends TestCase
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
     * Get controller instance.
     */
    public function testGetControllerInstance()
    {
        $complement = $this->complement;

        $home = $complement::AdvancedLocalComplement()->getControllerInstance('Home');

        $this->assertInstanceOf('AdvancedLocalComplement\Controller\Home', $home);
    }

    /**
     * Get model intance from controller method.
     */
    public function testGetModelFromControllerMethod()
    {
        $complement = $this->complement;

        $home = $complement::AdvancedLocalComplement()->getControllerInstance('Home');

        $this->assertInstanceOf('AdvancedLocalComplement\Model\Home', $home->getModel());
    }

    /**
     * Force error when get view intance directly from the controller.
     *
     * @expectedException \Error
     */
    public function testErrorWhenGetViewFromControllerInstance()
    {
        $complement = $this->complement;

        $home = $complement::AdvancedLocalComplement()->getControllerInstance('Home');

        $this->assertInstanceOf('AdvancedLocalComplement\Model\Home', $home->view);
    }

    /**
     * Get view intance from controller method.
     */
    public function testGetViewFromControllerMethod()
    {
        $complement = $this->complement;

        $home = $complement::AdvancedLocalComplement()->getControllerInstance('Home');

        $this->assertInstanceOf('Eliasis\Framework\View', $home->getView());
    }
}
