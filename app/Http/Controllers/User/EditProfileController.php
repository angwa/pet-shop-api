<?php

namespace App\Http\Controllers\User;

use App\Actions\User\EditProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;

class EditProfileController extends Controller
{
    /**
     * @OA\Put(
     * path="/api/v1/user/edit",
     * operationId="Edit",
     * security={{"bearer_token": {}}},
     * tags={"User"},
     * summary="Update  user profile",
     * description="User Update profile",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
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
     *          response=200,
     *          description="Profile Updated Successfully",
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
    public function update(UpdateProfileRequest $request)
    {
        (new EditProfileAction($request, auth()->user()))->execute();

        return JSON(CODE_SUCCESS, 'Profile updated success', ['user' => new UserResource(auth()->user())]);
    }
}
