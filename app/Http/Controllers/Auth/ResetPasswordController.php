<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;

class ResetPasswordController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/v1/user/reset-password-token",
     * operationId="resetPassword",
     * tags={"User"},
     * summary="Provide token and change your password",
     * description="User Change password",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *               type="object",
     *               required={"token", "email", "password", "password_confirmation"},
     *               @OA\Property(property="token", type="text"),
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirmation", type="password"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="Password changed Successfully",
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
    public function resetPassword(PasswordResetRequest $request)
    {
        $user = (new ResetPasswordAction($request))->execute();

        return JSON(CODE_SUCCESS, 'Your password has been changed successfully.', ['email' => $user->email]);
    }
}
