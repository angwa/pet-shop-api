<?php

namespace App\Http\Controllers\File;

use App\Actions\File\FIleUploadAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
        /**
        * @OA\Post(
        * path="/api/v1/file/upload",
        * operationId="uploadFile",
        * security={{"bearer_token": {}}},
        * tags={"File"},
        * summary="File Upload",
        * description="User can upload file here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"file"},
        *               @OA\Property(property="file", type="file"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="File uploaded Successfully",
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
    public function upload(FileUploadRequest $request)
    {
        $file = (new FIleUploadAction($request))->execute();

        return JSON(CODE_CREATED, 'File created successfully', ['file_uuid' => new FileResource($file)]);
    }
}
