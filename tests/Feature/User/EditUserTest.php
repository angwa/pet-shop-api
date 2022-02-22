<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use WithFaker, IsActiveUser;

    public function testUserCanUpdateProfileWithoutLogin()
    {
        $response =  $this->putJson(
            '/api/v1/user/edit',
            [
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
            ],
        );

        $response->assertStatus(401);
        $this->assertIsObject($response);
    }

    public function testUserCanUpdateProfile()
    {
        $response =  $this->putJson(
            '/api/v1/user/edit',
            [
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
            ],
            $this->activeUser()
        );

        $response->assertStatus(200);
        $this->assertIsObject($response);
    }
}
