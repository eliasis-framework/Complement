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
use PHPUnit\Framework\TestCase;

/**
 * State handler tests.
 */
final class StateTest extends TestCase
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
     * Set state test.
     */
    public function testSetState()
    {
        $complement = $this->complement;

        $this->assertSame(
            'uninstalled',
            $complement::AdvancedLocalComplement()->setState('uninstalled')
        );
    }

    /**
     * Get state test.
     */
    public function testGetState()
    {
        $complement = $this->complement;

        $this->assertSame(
            'uninstalled',
            $complement::AdvancedLocalComplement()->getState()
        );
    }

    /**
     * Get state test.
     */
    public function testGetStates()
    {
        $complement = $this->complement;

        $complement = $complement::AdvancedLocalComplement()->getStates();

        $this->assertCount(2, $complement);

        $this->assertSame('', $complement['action']);

        $this->assertSame('uninstalled', $complement['state']);
    }

    /**
     * Change state from uninstalled to installed.
     */
    public function testChangeStateFromUninstalledToInstalled()
    {
        $complement = $this->complement;

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('uninstalled', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('installed', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('installed', $state);
    }

    /**
     * Change state from installed to inactive.
     */
    public function testChangeStateFromInstalledToInactive()
    {
        $complement = $this->complement;

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('installed', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('inactive', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('inactive', $state);
    }

    /**
     * Change state from inactive to active.
     */
    public function testChangeStateFromInactiveToActive()
    {
        $complement = $this->complement;

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('inactive', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('active', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('active', $state);
    }

    /**
     * Change state from active to inactive.
     */
    public function testChangeStateFromActiveToInactive()
    {
        $complement = $this->complement;

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('active', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('inactive', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('inactive', $state);
    }

    /**
     * Change state from outdated to updated.
     */
    public function testChangeStateFromOutdatedToUpdated()
    {
        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setState('outdated');

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('outdated', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('updated', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('updated', $state);
    }

    /**
     * Change state from updated to active.
     */
    public function testChangeStateFromUpdatedToActive()
    {
        $complement = $this->complement;

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('updated', $state);

        ob_start();
        $newState = $complement::AdvancedLocalComplement()->changeState();
        ob_end_clean();

        $this->assertSame('active', $newState);

        $state = $complement::AdvancedLocalComplement()->getState();
        $this->assertSame('active', $state);
    }
}
