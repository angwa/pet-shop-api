<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class FetchSingleProductController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/product/{uuid}",
     * operationId="singleProduct",
     * tags={"Products"},
     * summary="Display fetched product",
     * description="Display fetched product",
     *      @OA\Parameter(
     *           name="uuid",
     *           in="path",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Display fetched product",
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
    public function show(Product $uuid)
    {
        $product = new ProductResource($uuid);

        return JSON(CODE_SUCCESS, 'Product fetched successfully.', ['product' => $product]);
    }
}
