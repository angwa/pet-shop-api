<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class OrderListingTest extends TestCase
{
    use IsActiveUser;

    public function testUserCanNotViewOrderstWithoutLogin()
    {
        $response = $this->getJson('/api/v1/user/orders');
        
        $response->assertStatus(401);
    }

    public function testUserCanViewOrdersWhenLoggedIn()
    {
        $response = $this->getJson('/api/v1/user/orders', $this->activeUser());

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
