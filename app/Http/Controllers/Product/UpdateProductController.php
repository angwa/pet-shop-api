<?php

namespace App\Http\Controllers\Product;

use App\Actions\Product\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateProductController extends Controller
{
        /**
        * @OA\Put(
        * path="/api/v1/product/{uuid}",
        * operationId="updateProduct",
        * security={{"bearer_token": {}}},
        * tags={"Products"},
        * summary="Update product with uuid",
        * description="update Product",
        *      @OA\Parameter(
        *           name="uuid",
        *           in="path",
        *           @OA\Schema(
        *           type="string"
        *       )
        *       ),
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="application/x-www-form-urlencoded",
        *            @OA\Schema(
        *               type="object",
        *               required={"category_uuid", "title", "price", "description", "metadata"},
        *               @OA\Property(property="category_uuid", type="text"),
        *               @OA\Property(property="title", type="text"),
        *               @OA\Property(property="price", type="number"),
        *               @OA\Property(property="description", type="text"),
        *               @OA\Property(property="metadata", type="object", example={"image":"string","brand": "string"}),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=200,
        *          description="Product updated successfully",
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
    public function update(ProductRequest $request, Product $uuid)
    {
        (new UpdateProductAction($request, $uuid))->execute();

        return JSON(CODE_SUCCESS, 'Product updated successfully', ['product' => new ProductResource($uuid)]);
    }
}
