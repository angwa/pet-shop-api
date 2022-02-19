<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeleteUserController extends Controller
{
        /**
        * @OA\Delete(
        * path="/api/v1/user",
        * operationId="DeleteUser",
        * security={{"bearer_token": {}}},
        * tags={"User"},
        * summary="User delete account",
        * description="User delete account",
        *      @OA\Response(
        *          response=201,
        *          description="User deleted successfully.",
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
    public function delete()
    {
        $user = Auth::user();
        $user->delete();
        
        Auth::logout();

        return JSON(CODE_SUCCESS, 'User account deleted successfully');
    }
}
