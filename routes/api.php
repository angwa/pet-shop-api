<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::get('/', [ProfileController::class, 'profile'])->name('profile');
    });
});