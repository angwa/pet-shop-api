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
     * Feature test for user cannot upload file if not logged in.
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

    /** 
     * User can upload file 
     * 
     * @return void
     */
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

    /** 
     * User can upload file , without valiudation
     * 
     * @return void
     */

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
