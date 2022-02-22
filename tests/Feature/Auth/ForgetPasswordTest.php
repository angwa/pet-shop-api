<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    /**
     * User cannot request for nonexisting account password reset.
     *
     * @return void
     */
    public function testUserCanReesetNoneExistingAccountPassword()
    {
        $response =  $this->postJson('/api/v1/user/forget-password', [
            'email' => 'No22Exist@status.vim',
        ]);

        $response->assertStatus(404);
    }

    /**
     * Forget Password test.
     *
     * @return void
     */
    public function testUserCanRequestResetPassword()
    {
        $email = User::factory()->create()->email;

        $response =  $this->postJson('/api/v1/user/forget-password', [
            'email' => $email,
        ]);

        $response->assertStatus(200);
    }
}
