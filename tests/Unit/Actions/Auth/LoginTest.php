<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new LoginAction($this->request());
    }

    /**
     * Execute method test for login Action
     *
     * @return void
     */
    public function testExecuteMethodForLoginShouldWork()
    {
        $this->assertIsObject($this->newInstanceOfClass->execute());
    }

    /**
     * @return LoginRequest
     */
    private function request(): LoginRequest
    {
        $request = new LoginRequest();

        $email = User::factory()->create()->email;

        $request->merge([
            'email' =>  $email,
            'password' => 'userpassword',
        ]);

        return $request;
    }
}
