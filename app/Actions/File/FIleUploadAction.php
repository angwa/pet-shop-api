<?php

namespace App\Actions\File;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use Str;

class FIleUploadAction
{
    private $request;

    public function __construct(FileUploadRequest $request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        $uuid = $this->generateUuid(); 
        $file = $this->uploadFile($uuid);

        return $file;
    }

    private function uploadFile($uuid)
    {
        $file = $this->request->file('file');
        $store = $file->store('pet-shop','pet_shop'); 

        $imageSize = $file->getSize();
        $size = number_format($imageSize / 1000,2).' KB';

        $upload = File::create([
            'uuid' => $uuid,
            'name' => $file->getClientOriginalName(),
            'path' => $store,
            'size' => $size,
            'type' => $file->getClientOriginalExtension()
        ]);

        abort_if(!$upload, CODE_BAD_REQUEST, 'Unable to upload image. Try again');

        return $upload;
    }

    private function generateUuid()
    {
        return Str::orderedUuid();
    }
}