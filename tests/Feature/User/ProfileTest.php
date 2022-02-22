<?php

namespace Tests\Feature\User;

use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use IsActiveUser;

    public function testUserCanNotViewProfileWithoutLogin()
    {
        $response = $this->getJson('/api/v1/user');

        $response->assertStatus(401);
    }

    public function testUserCanViewProfileWhenLoggedIn()
    {
        $response = $this->getJson('/api/v1/user', $this->activeUser());

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
