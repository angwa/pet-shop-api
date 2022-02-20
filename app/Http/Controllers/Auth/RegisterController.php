<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Actions\Auth\CreateNewUser;
use App\Actions\Token\Jwt;
use App\Http\Resources\UserResource;
use JWTAuth;

class RegisterController extends Controller
{
      /**
        * @OA\Post(
        * path="/api/v1/user/create",
        * operationId="Register",
        * tags={"User"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="application/x-www-form-urlencoded",
        *            @OA\Schema(
        *               type="object",
        *               required={"first_name", "last_name", "email", "password", "password_confirmation", "address", "phone_number"},
        *               @OA\Property(property="first_name", type="text"),
        *               @OA\Property(property="last_name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="password_confirmation", type="password"),
        *               @OA\Property(property="avatar", type="text"),
        *               @OA\Property(property="address", type="text"),
        *               @OA\Property(property="phone_number", type="text"),
        *               @OA\Property(property="is_marketing", type="text"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Registration Successful",
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
    public function register(RegisterRequest $request)
    {  
        $user = (new CreateNewUser())->execute($request);

         return JSON(CODE_CREATED, 'User account created successfully',[
            "user" => new UserResource($user),
            'token' => (new Jwt())->token($user),
            'login' => auth()->user()
        ]);
    }

}