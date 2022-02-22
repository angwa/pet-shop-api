<?php

namespace Tests\Feature\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class FileDownloadTest extends TestCase
{
    use IsActiveUser;

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
            $this->activeUser()
        );

        $uuid = $upload['data']['file_uuid']['uuid'];
        $response =  $this->getJson('/api/v1/file/' . $uuid);

        $response->assertStatus(200);
    }
}
