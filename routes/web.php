<?php

use App\Http\Controllers\CalculatorController;
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

Route::get('/', function () {
    return view('welcome');
});



Route::controller(CalculatorController::class)->group(function () {
    Route::get('addition/{a}/{b}' ,'addition');
    Route::get('subtract/{a}/{b}' ,'subtract');
});

Route::get('/home', function(){
    return view('home');
});
