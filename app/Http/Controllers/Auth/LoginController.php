<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Token\Jwt;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/user/login",
     * operationId="Login",
     * tags={"User"},
     * summary="User Login",
     * description="User Login here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="password"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
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
    public function login(LoginRequest $request)
    {
        $user = (new LoginAction($request))->execute();
        abort_if($user->is_admin === 1, CODE_UNAUTHORIZED, 'Admin cannot login through the user side.');

        return JSON(CODE_SUCCESS, 'Login Successful', [
            'token' => (new Jwt())->token($user),
            'login' => auth()->user()
        ]);
    }
}
