<?php

use App\Http\Controllers\Admin\AdminListUserController;
use App\Http\Controllers\Auth\Admin\AdminLoginController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Brand\ListBrandsController;
use App\Http\Controllers\Category\ListCategoryController;
use App\Http\Controllers\File\FileDownloadController;
use App\Http\Controllers\File\FileUploadController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\FetchSingleProductController;
use App\Http\Controllers\Product\ShowAllProductsController;
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

    Route::group(['middleware' => ['jwt.auth', 'is_user']], function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('profile');
        Route::delete('/', [DeleteUserController::class, 'delete'])->name('delete');
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::put('/edit', [EditProfileController::class, 'update'])->name('update');
        Route::get('/orders', [OrderListController::class, 'show'])->name('order');
    });
});

Route::prefix('/v1')->group(function () {
    Route::get('/categories', [ListCategoryController::class, 'show'])->name('categories');
    Route::post('/file/upload', [FileUploadController::class, 'upload'])->name('file_upload')->middleware('jwt.auth');
    Route::get('/file/{uuid}', [FileDownloadController::class, 'download'])->name('file_download');
    Route::get('/brands', [ListBrandsController::class, 'show'])->name('show_brand');
});

Route::prefix('/v1/admin')->group(function () {
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin_login');
    Route::get('/user-listing', [AdminListUserController::class, 'show'])->name('admin_show_users')->middleware('is_admin');;
});

Route::prefix('/v1')->name('product.')->group(function () {
    Route::middleware(['jwt.auth', 'is_admin'])->group(function () {
        Route::prefix('/product')->group(function () {
            Route::post('/create', [CreateProductController::class, 'store'])->name('create');
            Route::put('/{uuid}', [UpdateProductController::class, 'update'])->name('update');
            Route::delete('/{uuid}', [DeleteProductController::class, 'delete'])->name('delete');
        });
    });
    Route::get('/product/{uuid}', [FetchSingleProductController::class, 'show'])->name('show');
    Route::get('/products', [ShowAllProductsController::class, 'showAll'])->name('show_all');
});
