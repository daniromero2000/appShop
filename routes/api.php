<?php

use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Products\GetProductController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Users\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('products', ProductController::class);
Route::get('product/{id}', GetProductController::class);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('order', OrderController::class);
});
