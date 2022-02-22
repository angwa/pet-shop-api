<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ForgetPasswordAction;
use App\Http\Requests\ForgetPasswordRequest;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgetPasswordTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $newInstanceOfClass;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new ForgetPasswordAction($this->request());
    }

    /**
     * Execute method test for forget password action
     *
     * @return void
     */
    public function testExecuteMethodOfPasswordResetActionShouldWork()
    {
        $this->assertIsObject($this->newInstanceOfClass->execute());
    }

    /**
     * @return ForgetPasswordRequest
     */
    private function request(): ForgetPasswordRequest
    {
        $request = new ForgetPasswordRequest();

        $email = User::factory()->create()->email;

        $request->merge([
            'email' =>  $email,
        ]);

        return $request;
    }
}
