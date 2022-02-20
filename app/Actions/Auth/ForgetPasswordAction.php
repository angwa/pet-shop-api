<?php

namespace App\Actions\Auth;

use App\Http\Requests\ForgetPasswordRequest;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use App\Models\PasswordReset;
use Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordAction
{
    private $request;

    /**
     * @param ForgetPasswordRequest $request
     */
    public function __construct(ForgetPasswordRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $user = $this->findUser();
        abort_if(!$user, CODE_BAD_REQUEST, "User with this email address does not exist");

        $token = $this->generateToken();
        $this->logUserRequestForPassword($user, $token);

        Mail::to($user->email)->send(new ForgetPasswordMail($user, $token));

        return $user;
    }

    /**
     * @return object
     */
    private function findUser(): object
    {
        return User::where('email', $this->request->email)->first();
    }

    /**
     * @param User $user
     * @param mixed $token
     * 
     * @return oject
     */
    private function logUserRequestForPassword(User $user, string $token): object
    {
        $createToken = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()],
        );

        abort_if(!$createToken, CODE_BAD_REQUEST, "Unable to request for reset password");

        return $createToken;
    }

    /**
     * @return string
     */
    private function generateToken(): string
    {
        return strtoupper(Str::random(8));
    }
}
