<?php

namespace App\Actions\Token;

use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class Jwt
{
    /**
     * @param User $user
     * 
     * @return string
     */
    public function token(User $user): string
    {
        $token = JWTAuth::fromUser($user);
        $authenticate = JWTAuth::setToken($token)->toUser();

        abort_if(!$authenticate, CODE_UNAUTHORIZED, "Unable to authenticate user.");

        $this->updateOrCreateJwtToken($authenticate);

        return $token;
    }

    /**
     * @param User $user
     * 
     * @return object
     */
    private function updateOrCreateJwtToken(User $user): object
    {
        $jwt = $user->jwtToken()->updateOrCreate(
            ['user_id' => $user->id,],
            [
                'unique_id' => Str::orderedUuid(),
                'token_title' => "User Authentication"
            ]
        );

        return $jwt;
    }
}
