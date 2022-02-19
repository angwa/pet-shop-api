<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\FetchSingleProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\EditProfileController;
use App\Http\Controllers\User\OrderListController;
use App\Http\Controllers\User\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1/user')->name('user.')->group(function () {
    Route::post('/create', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/reset-password-token', [ResetPasswordController::class, 'resetPassword'])->name('reset_password');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('profile');
        Route::delete('/', [DeleteUserController::class, 'delete'])->name('delete');
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::put('/edit', [EditProfileController::class, 'update'])->name('update');
        Route::get('/orders', [OrderListController::class, 'show'])->name('order');
    });
});

Route::prefix('/v1/product')->name('product.')->group(function () {
    Route::middleware(['jwt.auth'])->group(function () {
        Route::post('/create', [CreateProductController::class, 'store'])->name('create');
        Route::put('/{uuid}', [UpdateProductController::class, 'update'])->name('update');
        Route::get('/{uuid}', [FetchSingleProductController::class, 'show'])->name('show');
    });
});