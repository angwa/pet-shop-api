<?php

namespace Tests\Feature\File;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FileUploadTest extends TestCase
{
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    /**
     * Feature test for file upload.
     *
     * @return void
     */
    public function testUserCanNotUploadFilesWithoutLogin()
    {
        Storage::disk('pet_shop');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/v1/file/upload', ['file' => $file]);
        $response->assertStatus(401);
    }

    public function testUserCanUploadFiles()
    {
        Storage::disk('pet_shop');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson(
            '/api/v1/file/upload',
            ['file' => $file],
            ['Authorization' => 'Bearer' . $this->token]
        );

        $response->assertStatus(201);
        Storage::disk('pet_shop')->assertMissing('missing.jpg');
    }

    public function testUserCanNotUploadFileWithoutSelectingFile()
    {
        Storage::disk('pet_shop');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson(
            '/api/v1/file/upload',
            [],
            ['Authorization' => 'Bearer' . $this->token]
        )->assertJsonValidationErrors([
            'file'    => 'The file field is required.',
        ]);
    }
}
