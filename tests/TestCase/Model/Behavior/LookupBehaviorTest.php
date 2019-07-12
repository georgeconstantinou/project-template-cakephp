<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\LookupBehavior;
use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\LookupBehavior Test Case
 */
class LookupBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\LookupBehavior
     */
    public $Lookup;

    /**
     * Thinks table
     * @var \Cake\ORM\Table
     */
    public $things;

    /**
     * Users table
     * @var \Cake\ORM\Table
     */
    public $users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.things',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->things = TableRegistry::get('Things');
        $this->users = TableRegistry::get('Users');

        $config = [
            'lookupFields' => [
                'name'
            ]
        ];

        $this->Lookup = new LookupBehavior($this->things, $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() : void
    {
        unset($this->Lookup);
        unset($this->things);
        unset($this->users);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testBeforeFind() : void
    {
        $entity = $this->things->find();
        $event = new Event('Model.beforeFind', $this->things, [
            'entity' => $entity,
        ]);

        $options = new ArrayObject([
            'lookup' => true,
            'value' => 'Thing #2'
        ]);

        $primary = true;
        $this->Lookup->beforeFind($event, $entity, $options, $primary);
        $idResult = $entity->firstOrFail();

        $id = is_array($idResult) ?: $idResult->get('id');

        $this->assertEquals('00000000-0000-0000-0000-000000000002', $id);
    }

    public function testUsersLookup() : void
    {
        $query = $this->users->find('all')->applyOptions(['lookup' => true, 'value' => 'user-1@test.com'])->firstOrFail();

        $email = is_array($query) ?: $query->get('email');

        $this->assertSame('user-1@test.com', $email);
    }

    public function testfindLookup() : void
    {
        $query = $this->users->find('lookup', ['value' => 'user-1@test.com'])->firstOrFail();
        $email = is_array($query) ?: $query->get('email');
        $this->assertSame('user-1@test.com', $email);
    }

    public function testfindLookupWithWhere() : void
    {
        $query = $this->users->find('lookup', ['value' => 'user-1@test.com'])->where(['username' => 'user-1'])->firstOrFail();
        $email = is_array($query) ?: $query->get('email');
        $this->assertSame('user-1@test.com', $email);
    }

    public function testfindLookupIgnoreLookupFieldsInConfig() : void
    {
        $query = $this->users->find('lookup', ['value' => '00000000-0000-0000-0000-000000000002', 'lookupfields' => false])->firstOrFail();
        $email = is_array($query) ?: $query->get('email');
        $this->assertSame('user-2@test.com', $email);
    }

    public function testfindLookupWithoutValueInOptions() : void
    {
        $query = $this->users->find('lookup')->firstOrFail();
        $this->assertInstanceOf('App\Model\Entity\User', $query);
    }

    public function testfindLookupWithLookupFieldsInConfig() : void
    {
        $query = $this->users->find('lookup', ['value' => '00000000-0000-0000-0000-000000000002', 'lookupfields' => true])->first();
        $this->assertNull($query);
    }
}
