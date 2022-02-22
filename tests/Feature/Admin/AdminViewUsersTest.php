<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminViewUsersTest extends TestCase
{
    use WithFaker;

    public function testAdminCanNotViewUserstWithoutLogin()
    {
        $response = $this->getJson('/api/v1/admin/user-listing');

        $response->assertStatus(401);
    }

    public function testUserCanViewOrdersWhenLoggedIn()
    {
        $user = $this->createAdmin();
        $token = ['Authorization' => 'Bearer' . JWTAuth::fromUser($user)];

        $response = $this->getJson('/api/v1/admin/user-listing', $token);

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }

    private function createAdmin()
    {
        $response = User::create([
            'uuid' => Str::uuid(),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'is_admin' => 1,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'address' => $this->faker->address(),
            'phone_number' => '+' . $this->faker->randomDigitNotZero() . $this->faker->numerify('###-###-####'),
            'is_marketing' => '0',
        ]);

        return $response;
    }
}
