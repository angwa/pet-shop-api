<?php

namespace App\Actions\File;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use Str;

class FIleUploadAction
{
    private $request;

    /**
     * @param FileUploadRequest $request
     */
    public function __construct(FileUploadRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $uuid = $this->generateUuid();
        $file = $this->uploadFile($uuid);

        return $file;
    }

    /**
     * @param string $uuid
     * 
     * @return object
     */
    private function uploadFile(string $uuid): object
    {
        $file = $this->request->file('file');
        $store = $file->store('pet-shop', 'pet_shop');

        $imageSize = $file->getSize();
        $size = number_format($imageSize / 1000, 2) . ' KB';

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

    /**
     * @return string
     */
    private function generateUuid(): string
    {
        return Str::orderedUuid();
    }
}
