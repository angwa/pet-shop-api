<?php

namespace App\Actions\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FIleDownloadAction
{
    /**
     * @param mixed $file
     * 
     * @return object
     */
    public function execute($file): object
    {
        $file = File::where('uuid', $file->uuid)->first();

        $storage = Storage::disk('pet_shop');
        $exist = $storage->exists($file->path);

        abort_if(!$exist, CODE_BAD_REQUEST, 'This file has been deleted or moved.');

        return $storage;
    }
}
