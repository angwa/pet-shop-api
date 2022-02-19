<?php

namespace App\Http\Controllers\Product;

use App\Actions\Product\CreateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class CreateProductController extends Controller
{
        /**
        * @OA\Post(
        * path="/api/v1/product/create",
        * operationId="CreateProduct",
        * security={{"bearer_token": {}}},
        * tags={"Product"},
        * summary="Create Product",
        * description="Create new Product",
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
        *          response=201,
        *          description="Product added successfully",
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
    public function store(ProductRequest $request)
    {
        $product = (new CreateProductAction($request))->execute();

        return JSON(CODE_CREATED, 'Product Created successfully', [
            'product' => new ProductResource($product),
        ]);
    }
}
