<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::orderedUuid(),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'is_admin' => 0,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$qf3F85r/eeHi114r9DXpXeLQmbgHieSIgpau5Ss5kgr414cuB3Z0C', // userpassword
            'address' => $this->faker->address(),
            'phone_number' => '+'.$this->faker->randomDigitNotZero().$this->faker->numerify('###-###-####'),
            'is_marketing' => '0',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
