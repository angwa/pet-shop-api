<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/user",
     * operationId="profile",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="Display User Profile",
     * description="View user profile single",
     *      @OA\Response(
     *          response=200,
     *          description="User profile displayed successfully",
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

    public function profile()
    {
        $user = new UserResource(auth()->user());

        return JSON(CODE_SUCCESS, 'User profile retrieved successfully', ['user' => $user]);
    }
}
