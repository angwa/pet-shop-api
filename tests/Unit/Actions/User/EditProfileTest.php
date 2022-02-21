<?php

namespace Tests\Unit\Actions\User;

use App\Actions\User\EditProfileAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EditProfileTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    public function setUp() : void
    {
        parent::setUp();
        $user =  User::factory()->create();
        $this->newInstanceOfClass = new EditProfileAction($this->request(), $user);
    }
    
    /**
     * Execute method test
     *
     * @return void
     */
    public function testExecute()
    {
        $data = $this->request();

        $this->assertTrue($this->newInstanceOfClass->execute($data));
    }

    private function request()
    {
        $request = new UpdateProfileRequest();

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
