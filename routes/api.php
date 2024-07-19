<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//register seller
Route::post('/register/seller', [\App\Http\Controllers\Api\AuthController::class, 'registerSeller']);

//login
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

//logout
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

//register buyer
Route::post('/register/buyer', [\App\Http\Controllers\Api\AuthController::class, 'registerBuyer']);

//store category
Route::post('/category/seller', [\App\Http\Controllers\Api\CategoryController::class, 'store'])->middleware('auth:sanctum');

//get all categories
Route::get('categories/seller', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');

//products
Route::apiResource('/products/seller', \App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

//update product
Route::post('/products/seller/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum');

//address
Route::apiResource('/buyer/addresses', \App\Http\Controllers\Api\AddressController::class)->middleware('auth:sanctum');