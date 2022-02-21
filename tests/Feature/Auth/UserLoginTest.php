<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use WithFaker;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user =  User::factory()->create();
    }

    public function testUserCannotLoginWithoutEmailAndPassword()
    {
        $this->postJson('/api/v1/user/login', [])
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $this->postJson('/api/v1/user/login', [
            'email' => $this->user->email,
            'password' => 'wrongpass'
        ])->assertStatus(401);
    }

    public function testUserCanLoginWithEmailAndPassword()
    {
        $response =  $this->postJson('/api/v1/user/login', [
            'email' => $this->user->email,
            'password' => 'userpassword'
        ]);

        $response->assertStatus(200);
    }
}
