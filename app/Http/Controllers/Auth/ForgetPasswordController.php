<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ForgetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;


class ForgetPasswordController extends Controller
{
  /**
   * @OA\Post(
   * path="/api/v1/user/forget-password",
   * operationId="forgetPassword",
   * tags={"User"},
   * summary="Create token for resetting  Password",
   * description="Request password reset token",
   *     @OA\RequestBody(
   *         @OA\JsonContent(),
   *         @OA\MediaType(
   *            mediaType="application/x-www-form-urlencoded",
   *            @OA\Schema(
   *               type="object",
   *               required={"email"},
   *               @OA\Property(property="email", type="text"),
   *            ),
   *        ),
   *    ),
   *      @OA\Response(
   *          response=201,
   *          description="Password reset requested successfully",
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
  public function forgetPassword(ForgetPasswordRequest $request)
  {
    $user = (new ForgetPasswordAction($request))->execute();

    return JSON(CODE_SUCCESS, "Password reset token has been sent to {$user->email}.");
  }
}
