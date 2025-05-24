<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Driver Management Routes
Route::get('/drivers/available', [App\Http\Controllers\DriverController::class, 'getAvailableDrivers']);
Route::post('/orders/{order}/assign-driver', [App\Http\Controllers\OrderController::class, 'assignDriver']);
Route::post('/orders/{order}/remove-driver', [App\Http\Controllers\OrderController::class, 'removeDriver']);

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
    
    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::post('/products/{product}/like', [ProductController::class, 'toggleLike']);
    Route::get('/favorites', [ProductController::class, 'favorites']);
    
    // Cart
    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/add/{product}', [CartController::class, 'add']);
    Route::post('/cart/update/{product}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove']);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}/tracking', [OrderController::class, 'tracking']);
}); 