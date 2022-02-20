<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ListActions;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class AdminListUserController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/admin/user-listing",
     * security={{"bearer_token": {}}},
     * operationId="allUser",
     * tags={"Admin"},
     * summary="List all Users",
     * description="List all users",
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
     *      @OA\Parameter(
     *           name="first_name",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="email",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="phone",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="address",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="created_at",
     *           in="query",
     *           @OA\Schema(
     *           type="string"
     *       )
     *       ),
     *      @OA\Parameter(
     *           name="marketing",
     *           in="query",
     *           @OA\Schema(
     *           type="string", enum={"0","1"}
     *       )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="User lists retrieved successfully.",
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
        $users = (new ListActions(User::class, 'users'))->sortWithUserFields();

        return JSON(CODE_SUCCESS, 'Users retrieved successfully.', [
            'users' => UserResource::collection($users),
            'first_page_url' => $users->url(1),
            'from' => $users->firstItem(),
            'per_page' => $users->perPage(),
            'prev_page_url' => $users->previousPageUrl(),
            'next_page_url' => $users->nextPageUrl(),
            'last_page' => $users->lastPage(),
            'to' => $users->lastItem(),
            'total' => $users->total(),
        ]);
    }
}
