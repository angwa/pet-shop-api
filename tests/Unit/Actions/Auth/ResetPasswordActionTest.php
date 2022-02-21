<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Http\Requests\PasswordResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordActionTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new ResetPasswordAction($this->request());
    }

    /**
     * Execute method test.
     *
     * @return void
     */
    public function testExecute()
    {
        $this->assertIsObject($this->newInstanceOfClass->execute());
    }

    private function request()
    {
        $request = new PasswordResetRequest();

        $reset = $this->createToken();

        $request->merge([
            'token' =>  $reset['token'],
            'email' =>  $reset['email'],
        ]);

        return $request;
    }

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
