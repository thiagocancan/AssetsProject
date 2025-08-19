<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\OrderController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/all-assets', [AssetController::class, 'index']);
Route::get('/assets/{id}', [AssetController::class, 'show']);

Route::get('/profile/{id}', [UserController::class, 'show']);

Route::get('/reviews/{assetId}', [ReviewController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/desactive-account', [AuthController::class, 'desactiveAccount']);
    
    // User profile routes
    Route::get('/profile', [UserController::class, 'me']);
    Route::put('/profile', [UserController::class, 'update']);
    
    // Asset routes
    Route::get('assets', [AssetController::class, 'myAssets']);
    Route::post('assets', [AssetController::class, 'store']);
    Route::put('assets/{id}', [AssetController::class, 'update']);
    Route::delete('/assets/{id}', [AssetController::class, 'destroy']);
    Route::get('/assets/{asset}/download', [AssetController::class, 'download']);

    // Review routes
    Route::post('/reviews/{assetId}', [ReviewController::class, 'store']);
    Route::get('/reviews/{id}', [ReviewController::class, 'show']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    // Order routes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/approve', [OrderController::class, 'aprrove']);
});