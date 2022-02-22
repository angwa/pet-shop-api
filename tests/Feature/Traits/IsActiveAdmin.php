<?php

namespace Tests\Feature\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

trait IsActiveAdmin
{
    /**
     * @return array
     */
    public function activeAdmin()
    {
        $user = $this->createAdmin();
        $token = ['Authorization' => 'Bearer' . JWTAuth::fromUser($user)] ;

        return $token;
    }
    
    /**
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
