<?php

namespace App\Http\Controllers\File;

use App\Actions\File\FIleDownloadAction;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/file/{uuid}",
     * operationId="downloadFile",
     * tags={"File"},
     * summary="User can download file",
     * description="User can download file",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="File downloaded successfully.",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function download(File $uuid)
    {

        $file =  (new FIleDownloadAction())->execute($uuid);

        return $file->download($uuid->path, $uuid->name);
    }
}
