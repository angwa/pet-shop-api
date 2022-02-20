<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Hash;

class LoginAction
{
    private $request;

    public function __construct(LoginRequest $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        $user = $this->findUser();
        $this->verifyPassword($user);
        $this->logUser($user);

        return $user;
    }

    private function verifyPassword(User $user): bool
    {
        $password = Hash::check($this->request->password, $user->password);
        abort_if(!$password, CODE_UNAUTHORIZED, "Invalid login details");

        return true;
    }

    private function findUser()
    {
        $user =  User::where('email', $this->request->email)->first();
        abort_if(!$user, CODE_UNAUTHORIZED, "User with this email address does not exist");

        return $user;
    }

    private function logUser(User $user)
    {
       return $user->update([
            'last_login_at' => now()
        ]);
    }

}
