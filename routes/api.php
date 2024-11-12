<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\AuthController;

// Registration and login routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('products', [ProductAPIController::class, 'store']);   // Create
    Route::put('products/{id}', [ProductAPIController::class, 'update']); // Update
    Route::delete('products/{id}', [ProductAPIController::class, 'destroy']); // Delete
});

Route::get('products', [ProductAPIController::class, 'index']); // Read All
Route::get('products/{id}', [ProductAPIController::class, 'show']); // Read Single