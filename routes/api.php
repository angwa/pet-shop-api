<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::get('/profile', function(){
            dd(auth()->user());
        });
    });
});