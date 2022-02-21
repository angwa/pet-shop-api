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

    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new ForgetPasswordAction($this->request());
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
        $request = new ForgetPasswordRequest();

        $email = User::factory()->create()->email;

        $request->merge([
            'email' =>  $email,
        ]);

        return $request;
    }
}
