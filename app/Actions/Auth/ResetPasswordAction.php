<?php

namespace App\Actions\Auth;

use App\Http\Requests\PasswordResetRequest;
use App\Models\User;
use App\Models\PasswordReset;
use Hash;
use Illuminate\Support\Carbon;

class ResetPasswordAction
{
    private $request;

    /**
     * @param PasswordResetRequest $request
     */
    public function __construct(PasswordResetRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $user = $this->findUser();
        $token = $this->checkValidResetToken();
        $this->updateUserPassword($user);

        $token->delete();

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
     * 
     * @return bool
     */
    private function updateUserPassword(User $user): bool
    {
        $updatePassword = $user->update([
            'password' => Hash::make($this->request->password)
        ]);

        abort_if(!$updatePassword, CODE_BAD_REQUEST, "Unable to update user password");

        return $updatePassword;
    }

    /**
     * @return object
     */
    private function checkValidResetToken(): object
    {
        $interval = Carbon::now()->subMinutes(5)->toDateTimeString();

        $token = PasswordReset::where('email', $this->request->email)->first();
        abort_if(!$token, CODE_BAD_REQUEST, "Token does not exist for this user.");

        if (!Hash::check($this->request->token, $token->token)) {
            abort(CODE_BAD_REQUEST, 'Token is not valid');
        }

        if (Carbon::parse($token->created_at)->lt($interval)) {
            abort(CODE_BAD_REQUEST, "Token have expired");
        }

        return $token;
    }
}
