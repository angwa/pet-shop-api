<?php

namespace Tests\Feature\User;

use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use IsActiveUser;

    public function testUserCanNotLogoutWithoutLogin()
    {
        $response = $this->deleteJson('/api/v1/user');

        $response->assertStatus(401);
    }

    public function testUserCanDeleteAccountWhenLoggedIn()
    {
        $response = $this->deleteJson('/api/v1/user', [], $this->activeUser());

        $response->assertStatus(200);
    }
}
