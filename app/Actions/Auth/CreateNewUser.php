<?php

namespace App\Actions\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;

class CreateNewUser
{
    public function execute(RegisterRequest $request)
    {
            $user = $this->createUser($request);

            abort_if(!$user, CODE_BAD_REQUEST, "Error occured. Please try again");

            return $user;
    }

    private function createUser(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $this->sentenceCase($request->first_name),
            'last_name' => $this->sentenceCase($request->last_name),
            'address' => $request->address,
            'avatar' => $request->avatar,
            'phone_number' => $request->phone_number,
            'is_marketing' => ($request->is_marketing) ? $request->is_marketing : false, 
            'uuid' => Str::orderedUuid(),
            'email' => $request->email,
            'password' => Hash::make($request->password),
          ]);

        return $user;
    }

    private function sentenceCase($text)
    {
        return ucwords(strtolower($text));
    }
}
