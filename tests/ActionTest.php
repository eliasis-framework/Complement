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
 * Action hooks tests.
 */
final class ActionTest extends TestCase
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

        $type = isset($argv[2]) ? $argv[2] : 'Component';

        $this->type = $type;

        $class = "Eliasis\\Complement\\Type\\$type";

        $this->app = new App();

        $this->complement = new $class();

        $this->assertInstanceOf($class, $this->complement);

        $app = $this->app;

        $app::run($this->root);
    }

    /**
     * Force the activation hook action.
     */
    public function testActivationHook()
    {
        $action = 'activation';

        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setAction($action);

        $currentAction = $complement::AdvancedLocalComplement()->getAction(
            $complement::AdvancedLocalComplement()->getState()
        );

        $this->assertSame($action, $currentAction);

        $complement::AdvancedLocalComplement()->doAction($action);

        global $activation;

        $this->assertSame("Response from $action hook", $activation);
    }

    /**
     * Force the deactivation hook action.
     */
    public function testDeactivationHook()
    {
        $action = 'deactivation';

        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setAction($action);

        $currentAction = $complement::AdvancedLocalComplement()->getAction(
            $complement::AdvancedLocalComplement()->getState()
        );

        $this->assertSame($action, $currentAction);

        ob_start();

        $complement::AdvancedLocalComplement()->doAction($action);

        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame("Response from $action hook", $response);
    }

    /**
     * Force the installation hook action.
     */
    public function testInstalationHook()
    {
        $action = 'installation';

        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setAction($action);

        $currentAction = $complement::AdvancedLocalComplement()->getAction(
            $complement::AdvancedLocalComplement()->getState()
        );

        $this->assertSame($action, $currentAction);

        ob_start();

        $complement::AdvancedLocalComplement()->doAction($action);

        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame("Response from $action hook", $response);
    }

    /**
     * Force the uninstallation hook action.
     */
    public function testUninstalationHook()
    {
        $action = 'uninstallation';

        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setAction($action);

        $currentAction = $complement::AdvancedLocalComplement()->getAction(
            $complement::AdvancedLocalComplement()->getState()
        );

        $this->assertSame($action, $currentAction);

        ob_start();

        $complement::AdvancedLocalComplement()->doAction($action);

        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame("Response from $action hook", $response);
    }

    /**
     * Action hooks when change states from active to inactive.
     */
    public function testWhenChangeStateFromActiveToInactive()
    {
        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setState('active');

        ob_start();

        $complement::AdvancedLocalComplement()->changeState();

        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame('Response from deactivation hook', $response);
    }

    /**
     * Action hooks when change states from inactive to active.
     */
    public function testWhenChangeStateFromInactiveToActive()
    {
        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setState('inactive');

        $complement::AdvancedLocalComplement()->changeState();

        global $activation;

        $this->assertSame('Response from activation hook', $activation);
    }

    /**
     * Action hooks when change states from uninstalled to inactive.
     */
    public function testWhenChangeStateFromUninstalledToInactive()
    {
        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setState('uninstalled');

        ob_start();

        $complement::AdvancedLocalComplement()->changeState();
        $complement::AdvancedLocalComplement()->changeState();
        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame('Response from installation hook', $response);
    }

    /**
     * Action hooks when change states from installed to uninstalled.
     */
    public function testWhenChangeStateFromUninstallToUninstalled()
    {
        $complement = $this->complement;

        $complement::AdvancedLocalComplement()->setState('uninstall');

        ob_start();

        $complement::AdvancedLocalComplement()->changeState();

        $response = ob_get_contents();

        ob_end_clean();

        $this->assertSame('Response from uninstallation hook', $response);
    }
}
