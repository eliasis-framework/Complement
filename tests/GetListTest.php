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
 * Get complements lists.
 */
final class GetListTest extends TestCase
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

        $complement = $this->complement;

        $complement::load($this->root . 'remote/remote-complement.jsond');
    }

    /**
     * Get a list of complements with filters and default sorting.
     */
    public function testGetDefaultList()
    {
        $complement = $this->complement;

        $this->assertInternalType(
            'array',
            $complements = $complement::getList()
        );

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 'AdvancedLocalComplement');
        $this->assertSame($complements[1], 'BasicLocalComplement');
        $this->assertSame($complements[2], 'RemoteComplement');
    }

    /**
     * Get complements list by caregory.
     */
    public function testGetListByCategory()
    {
        $complement = $this->complement;

        $complements = $complement::getList('advanced-local-complement');
        $this->assertCount(1, $complements);
        $complements = array_keys($complements);
        $this->assertSame($complements[0], 'AdvancedLocalComplement');

        $complements = $complement::getList('basic-local-complement');
        $this->assertCount(1, $complements);
        $complements = array_keys($complements);
        $this->assertSame($complements[0], 'BasicLocalComplement');

        $complements = $complement::getList('remote-complement');
        $this->assertCount(1, $complements);
        $complements = array_keys($complements);
        $this->assertSame($complements[0], 'RemoteComplement');
    }

    /**
     * Get complements list with asort sorting.
     */
    public function testGetListWithAsortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'asort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 'AdvancedLocalComplement');
        $this->assertSame($complements[1], 'BasicLocalComplement');
        $this->assertSame($complements[2], 'RemoteComplement');
    }

    /**
     * Get complements list with arsort sorting.
     */
    public function testGetListWithArsortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'arsort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 'RemoteComplement');
        $this->assertSame($complements[1], 'BasicLocalComplement');
        $this->assertSame($complements[2], 'AdvancedLocalComplement');
    }

    /**
     * Get complements list with krsort sorting.
     */
    public function testGetListWithKrsortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'krsort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 'RemoteComplement');
        $this->assertSame($complements[1], 'BasicLocalComplement');
        $this->assertSame($complements[2], 'AdvancedLocalComplement');
    }

    /**
     * Get complements list with ksort sorting.
     */
    public function testGetListWithKsortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'ksort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 'AdvancedLocalComplement');
        $this->assertSame($complements[1], 'BasicLocalComplement');
        $this->assertSame($complements[2], 'RemoteComplement');
    }

    /**
     * Get complements list with rsort sorting.
     */
    public function testGetListWithRsortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'rsort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 0);
        $this->assertSame($complements[1], 1);
        $this->assertSame($complements[2], 2);
    }

    /**
     * Get complements list with sort sorting.
     */
    public function testGetListWithSortSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'sort');

        $this->assertCount(3, $complements);

        $complements = array_keys($complements);

        $this->assertSame($complements[0], 0);
        $this->assertSame($complements[1], 1);
        $this->assertSame($complements[2], 2);
    }

    /**
     * Get complements list with shuffle sorting.
     */
    public function testGetListWithShuffleSorting()
    {
        $complement = $this->complement;

        $complements = $complement::getList('all', 'shuffle');

        $this->assertCount(3, $complements);
    }
}
