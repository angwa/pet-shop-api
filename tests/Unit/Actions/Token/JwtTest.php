<?php

namespace Tests\Unit\Actions\Token;

use App\Actions\Token\Jwt;
use App\Models\User;
use Tests\TestCase;

class JwtTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->newInstanceOfClass = new Jwt();
    }

    /**
     * token method of jwt
     *
     * @return void
     */
    public function testJwtTokenShouldReturnString()
    {
        $user =  User::factory()->create();
        $this->assertIsString($this->newInstanceOfClass->token($user));
    }
}
