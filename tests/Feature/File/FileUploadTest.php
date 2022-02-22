<?php

namespace Tests\Feature\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use IsActiveUser;
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
            $this->activeUser()
        );

        $response->assertStatus(201);
        Storage::disk('pet_shop')->assertMissing('missing.jpg');
    }

    public function testUserCanNotUploadFileWithoutSelectingFile()
    {
        Storage::disk('pet_shop');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->postJson(
            '/api/v1/file/upload',
            [],
            $this->activeUser()
        )->assertJsonValidationErrors([
            'file'    => 'The file field is required.',
        ]);
    }
}
