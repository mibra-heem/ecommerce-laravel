<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.dashboard');

// Route::resource('products', ProductController::class);

// Route::resource('banners', BannerController::class);

// Route::resource('categories', CategoryController::class);