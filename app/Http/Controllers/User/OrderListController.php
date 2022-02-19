<?php

namespace App\Http\Controllers\User;

use App\Actions\User\OrderListAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use Illuminate\Pipeline\Pipeline;


class OrderListController extends Controller
{
        /**
        * @OA\Get(
        * path="/api/v1/user/orders",
        * operationId="userOrders",
        * security={{"bearer_token": {}}},
        * tags={"User"},
        * summary="Show user order",
        * description="User Logout here",
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
        *          response=201,
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
        $orders = (new OrderListAction())->execute();
            
        return JSON(CODE_SUCCESS, 'User orders retrieved successfully',[
            'orders' => OrderListResource::collection($orders),
            'first_page_url' => $orders ->url(1),
            'from' => $orders->firstItem(),
            'per_page' => $orders->perPage(),
            'prev_page_url' => $orders->previousPageUrl(),
            'next_page_url' => $orders->nextPageUrl(),
            'last_page' => $orders->lastPage(),
            'to' => $orders->lastItem(),
            'total' => $orders->total(),
            
        ]);
    }
}