<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::apiResource('/product', ProductController::class);

    Route::apiResource('/quote', QuoteController::class);
});
