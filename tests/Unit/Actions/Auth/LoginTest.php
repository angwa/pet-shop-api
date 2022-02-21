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

    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new LoginAction($this->request());
    }

    /**
     * Execute method test
     *
     * @return void
     */
    public function testExecute()
    {
        $this->assertIsObject($this->newInstanceOfClass->execute());
    }

    private function request()
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
