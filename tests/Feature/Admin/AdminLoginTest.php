<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use WithFaker;

    /**User cannpt login without email and password
     * @return void
     */
    public function testAdminCannotLoginWithoutEmailAndPassword()
    {
        $this->postJson('/api/v1/admin/login', [])
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    /**
     * User cannot login with incorrect password
     * 
     * @return void
     */
    public function testAdminCannotLoginWithIncorrectPassword()
    {
        $this->postJson('/api/v1/admin/login', [
            'email' => 'admin@admin.co',
            'password' => 'wrongpass'
        ])->assertStatus(401);
    }

    public function testAdminCanLoginWithEmailAndPassword()
    {
        $admin = $this->createAdmin();

        $response =  $this->postJson('/api/v1/admin/login', [
            'email' => $admin->email,
            'password' => 'admin'
        ]);
        $response->assertStatus(200);
    }

    /**
     * Create Admin
     * 
     * @return object
     */
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
