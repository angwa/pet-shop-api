<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
        /**
        * @OA\Delete(
        * path="/api/v1/product/{uuid}",
        * operationId="deleteProduct",
        * security={{"bearer_token": {}}},
        * tags={"Product"},
        * summary="Delete specific product",
        * description="Delete specific product",
        *      @OA\Parameter(
        *           name="uuid",
        *           in="path",
        *           @OA\Schema(
        *           type="string"
        *       )
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
    public function delete(Product $uuid)
    {
        $uuid->delete();

        return JSON(CODE_SUCCESS, 'Product deleted successfully');
    }
}
