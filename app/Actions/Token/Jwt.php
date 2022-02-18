<?php

namespace App\Actions\Token;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Jwt
{
    public function token(User $user)
    {
        $token = JWTAuth::fromUser($user);
        $authenticate = JWTAuth::setToken($token)->toUser();

        abort_if(!$authenticate, CODE_UNAUTHORIZED, "Unable to authenticate user."); 

        return $token;
    }
}