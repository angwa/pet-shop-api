<?php

namespace App\Actions\Token;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Jwt
{
    public function token(User $user)
    {
       return JWTAuth::fromUser($user);
    }
}