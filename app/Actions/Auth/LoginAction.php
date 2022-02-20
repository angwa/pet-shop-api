<?php

namespace App\Actions\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Hash;

class LoginAction
{
    private $request;

    /**
     * @param LoginRequest $request
     */
    public function __construct(LoginRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $user = $this->findUser();
        $this->verifyPassword($user);
        $this->logUser($user);

        return $user;
    }

    /**
     * @param User $user
     * 
     * @return bool
     */
    private function verifyPassword(User $user): bool
    {
        $password = Hash::check($this->request->password, $user->password);
        abort_if(!$password, CODE_UNAUTHORIZED, "Invalid login details");

        return true;
    }

    /**
     * @return object
     */
    private function findUser():object
    {
        $user =  User::where('email', $this->request->email)->first();
        abort_if(!$user, CODE_UNAUTHORIZED, "User with this email address does not exist");

        return $user;
    }

    /**
     * @param User $user
     * 
     * @return bool
     */
    private function logUser(User $user): bool
    {
        return $user->update([
            'last_login_at' => now()
        ]);
    }
}
