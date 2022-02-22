<?php

namespace Tests\Feature\Traits;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait IsActiveUser
{
    public function activeUser()
    {
        $user = User::factory()->create();
        $token = ['Authorization' => 'Bearer' . JWTAuth::fromUser($user)] ;

        return $token;
    }
}
