<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category resource routes
Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);

// Order routes
Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:30,1');
