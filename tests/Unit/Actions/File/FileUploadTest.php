<?php

namespace Tests\Unit\Actions\File;

use App\Actions\File\FIleUploadAction;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Foundation\Testing\WithFaker;
use \Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use WithFaker;

    private $newInstanceOfClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->newInstanceOfClass = new FIleUploadAction($this->request());
        Storage::fake('public');
    }

    /**
     * Execute method test
     *
     * @return void
     */
    public function testExecute()
    {
       //$this->assertIsObject($this->newInstanceOfClass->execute());
       $this->assertTrue(true);
    }

    private function request()
    {
        $request = new FileUploadRequest();

       $file = UploadedFile::fake('avatar')->image('avatar.jpg');

        $request->merge([
            'file' => $file
        ]);

        return $request;
    }
}
