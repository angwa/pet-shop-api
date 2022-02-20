<?php

namespace App\Actions\User;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class EditProfileAction
{
    private $request;
    private $user;

    /**
     * @param UpdateProfileRequest $request
     * @param User $user
     */
    public function __construct(UpdateProfileRequest $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        return $this->updateProfile($this->user);
    }

    /**
     * @param User $user
     * 
     * @return bool
     */
    private function updateProfile(User $user): bool
    {
        $user = $user->update([
            'first_name' => $this->request->first_name,
            'last_name' => $this->request->last_name,
            'address' => $this->request->address,
            'avatar' => $this->request->avatar,
            'phone_number' => $this->request->phone_number,
            'is_marketing' => ($this->request->is_marketing) ? $this->request->is_marketing : false,
            'email' => $this->request->email,
            'password' => Hash::make($this->request->password),
        ]);

        abort_if(!$user, CODE_BAD_REQUEST, 'Unable to update user. Please try again.');

        return $user;
    }
}
