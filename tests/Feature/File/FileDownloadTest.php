<?php

namespace Tests\Feature\File;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FileDownloadTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    /**
     * Test for file download
     *
     * @return void
     */
    public function testUserCanDownloadFile()
    {
        Storage::disk('pet_shop');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $upload = $this->postJson(
            '/api/v1/file/upload',
            ['file' => $file],
            ['Authorization' => 'Bearer' . $this->token]
        );

        $uuid = $upload['data']['file_uuid']['uuid'];
        $response =  $this->getJson('/api/v1/file/' . $uuid);

        $response->assertStatus(200);
    }
}
