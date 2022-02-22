<?php

namespace Tests\Feature\User;

use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    use IsActiveUser;

    public function testUserCanNotLogoutWithoutLogin()
    {
        $response = $this->getJson('/api/v1/user/logout');
        
        $response->assertStatus(401);
    }

    public function testUserCanLogoutWhenLoggedIn()
    {
        $response = $this->getJson('/api/v1/user/logout', $this->activeUser());

        $response->assertStatus(200);
    }
}
