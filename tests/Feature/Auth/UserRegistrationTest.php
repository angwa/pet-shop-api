<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCannotRegisterWithoutFillingFormProperly()
    {
        $this->postJson('/api/v1/user/create', [])
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    public function testUserCanRegisterNewAccount()
    {
        $response =  $this->postJson('/api/v1/user/create', [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'is_admin' => 0,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'userpassword', // userpassword
            'password_confirmation' => 'userpassword', // userpassword
            'address' => $this->faker->address(),
            'phone_number' => '+' . $this->faker->randomDigitNotZero() . $this->faker->numerify('###-###-####'),
            'is_marketing' => '0',
        ]);

        $response->assertStatus(201);
        $this->assertIsObject($response);
    }
}
