<?php

namespace Tests\Unit\Actions\Token;

use App\Actions\Token\Jwt;
use App\Models\User;
use Tests\TestCase;

class JwtTest extends TestCase
{


    public function setUp(): void
    {
        parent::setUp();
  
        $this->newInstanceOfClass = new Jwt();
    }

    /**
     * Execute method test
     *
     * @return void
     */
    public function testToken()
    {
        $user =  User::factory()->create();
        $this->assertIsString($this->newInstanceOfClass->token($user));
    }

}
