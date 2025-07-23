<?php

use App\Http\Controllers\Api\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;

use App\Http\Controllers\Api\User\BannerController as UserBannerController;
use App\Http\Controllers\Api\User\CategoryController as UserCategoryController;
use App\Http\Controllers\Api\User\ProductController as UserProductController;

use App\Http\Controllers\PaymentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin Routes (Protected)
Route::prefix('admin')->group(function () {
    Route::apiResource('banners', AdminBannerController::class);
    Route::apiResource('categories', AdminCategoryController::class);
    Route::apiResource('products', AdminProductController::class);
});

// User Routes (Public or limited auth)
Route::prefix('user')->group(function () {
    Route::get('banners', [UserBannerController::class, 'index']);
    Route::get('categories', [UserCategoryController::class, 'index']);
    Route::get('products', [UserProductController::class, 'index']);
});

Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);

