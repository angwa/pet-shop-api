<?php

namespace Tests\Unit\Actions\Sort;

use App\Actions\ListActions;
use App\Models\User;
use App\Models\Order;
use Tests\TestCase;

class ListHelpersTest extends TestCase
{

    private $newInstanceOfClass;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Execute method test
     *
     * @return void
     */
    public function testSortWithAuth()
    {
        $user = new User([
            'id' => 1,
            'first_name' => 'Fake user'
        ]);

        $this->be($user);

        $this->newInstanceOfClass = new ListActions(Order::class, 'users');
        $this->assertIsObject($this->newInstanceOfClass->sortWithAuth());
    }
    /**
     * Execute method test
     *
     * @return void
     */

    public function testSortWithoutAuth()
    {
        $this->newInstanceOfClass = new ListActions(Order::class, 'orders');
        $this->assertIsObject($this->newInstanceOfClass->sortWithoutAuth());
    }
    /**
     * Execute method test
     *
     * @return void
     */
    public function testSortWithUserFields()
    {
        $this->newInstanceOfClass = new ListActions(User::class, 'users');
        $this->assertIsObject($this->newInstanceOfClass->sortWithUserFields());
    }
}
