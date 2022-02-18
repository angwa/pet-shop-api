<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
        /**
        * @OA\Get(
        * path="/api/v1/user/logout",
        * operationId="Logout",
        * security={{"bearer_token": {}}},
        * tags={"User"},
        * summary="User Logout",
        * description="User Logout here",
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
    public function logout()
    {
        Auth::logout();

        return JSON(CODE_SUCCESS, 'User logged out successfully');
    }
}
