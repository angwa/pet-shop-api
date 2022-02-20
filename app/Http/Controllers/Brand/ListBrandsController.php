<?php

namespace App\Http\Controllers\Brand;

use App\Actions\Brands\ListBrandsAction;
use App\Actions\ListActions;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class ListBrandsController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/brands",
     * operationId="allBrands",
     * tags={"Brands"},
     * summary="List all Brands",
     * description="List all Brands",
     *      @OA\Parameter(
     *           name="page",
     *           in="query",
     *           @OA\Schema(
     *           type="integer"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="limit",
     *           in="query",
     *           @OA\Schema(
     *           type="integer"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="sortBy",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="desc",
     *           in="query",
     *           @OA\Schema(
     *           type="boolean"
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="User logout",
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
    public function show()
    {
        $brands = (new ListActions(Brand::class, 'brands'))->sortWithoutAuth();

        return JSON(CODE_SUCCESS, 'Brands retrieved successfully.', [
            'brands' => BrandResource::collection($brands),
            'first_page_url' => $brands->url(1),
            'from' => $brands->firstItem(),
            'per_page' => $brands->perPage(),
            'prev_page_url' => $brands->previousPageUrl(),
            'next_page_url' => $brands->nextPageUrl(),
            'last_page' => $brands->lastPage(),
            'to' => $brands->lastItem(),
            'total' => $brands->total(),
        ]);
    }
}
