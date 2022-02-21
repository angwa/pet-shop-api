<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\CreateNewUser;
use App\Http\Requests\RegisterRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewUserTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    public function setUp() : void
    {
        parent::setUp();
        $this->newInstanceOfClass = new CreateNewUser();
    }
    
    /**
     * Execute method test
     *
     * @return void
     */
    public function testExecute()
    {
        $data = $this->request();

        $this->assertIsObject($this->newInstanceOfClass->execute($data));
    }

    private function request()
    {
        $request = new RegisterRequest();

        $request->merge([
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'userpassword', 
            'address' => $this->faker->address(),
            'phone_number' => '+'.$this->faker->randomDigitNotZero().$this->faker->numerify('###-###-####'),
            'is_marketing' => '0',
        ]);

        return $request;
    }

}
