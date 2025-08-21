<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category resource routes
Route::apiResource('categories', CategoryController::class);

// Additional post routes (must come before resource routes)
Route::get('/posts/featured', [PostController::class, 'featured']);
Route::get('/posts/low-stock', [PostController::class, 'lowStock']);
Route::get('/posts/price-range', [PostController::class, 'byPriceRange']);
Route::get('/posts/category/{category}', [PostController::class, 'byCategory']);

// Post resource routes (must come after specific routes)
Route::apiResource('posts', PostController::class);
