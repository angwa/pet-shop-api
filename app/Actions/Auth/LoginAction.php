<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;

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
        abort_if(!$user, CODE_UNAUTHORIZED, "User with this email address does not exist");

        $password = $this->verifyPassword($user);
        abort_if(!$password, CODE_UNAUTHORIZED, "Invalid login details");

        $this->logUser($user);

        return $user;
    }

    private function verifyPassword(User $user): bool
    {
        return Hash::check($this->request->password, $user->password);
    }

    private function findUser()
    {
        return User::where('email', $this->request->email)->first();
    }

    private function logUser(User $user)
    {
       return $user->update([
            'last_login_at' => now()
        ]);
    }

}
