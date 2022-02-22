<?php

namespace Tests\Feature\Auth;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /** 
     * User can reset password
     * 
     * @return void
     */
    public function testUserCanResetPassword()
    {
        $data = $this->createToken();

        $response =  $this->postJson('/api/v1/user/reset-password-token', [
            'token' => $data['token'],
            'email' => $data['email'],
            'password' => 'newuserpassword',
            'password_confirmation' => 'newuserpassword'
        ]);

        $response->assertStatus(200);
    }

    /**
     * User cannot reset password with wrong token
     * 
     * @return void
     */
    public function testUserCanNotResetPasswordWithWrongToken()
    {
        $data = $this->createToken();

        $response =  $this->postJson('/api/v1/user/reset-password-token', [
            'token' => 'wrong_token',
            'email' => $data['email'],
            'password' => 'newuserpassword',
            'password_confirmation' => 'newuserpassword'
        ]);

        $response->assertStatus(400);
    }

    /**
     * Create token for reset password
     * 
     * @return array
     */
    private function createToken()
    {
        $token = strtoupper(Str::random(8));
        $email = User::factory()->create()->email;

        PasswordReset::create([
            'email' => $email,
            'token' => Hash::make($token),
        ]);

        $data = ['email' => $email, 'token' => $token];

        return $data;
    }
}
