<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;

use \App\Http\Controllers\PasswordResetController;

Route::prefix('/v1')->group(function () {
    Route::apiResource('/product', ProductController::class);

    Route::apiResource('/quote', QuoteController::class);

    Route::get('/quote/{quote_id}/product/{product_id}', [QuoteController::class, 'getProduct']);
    Route::get('/quote/{quote_id}/product', [QuoteController::class, 'getAllProducts']);

    Route::post('/quote/{quote_id}/product', [QuoteController::class, 'addProducts']);
    Route::delete('/quote/{quote_id}/product/{product_id}', [QuoteController::class, 'deleteProduct']);

    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('/register', [RegisterController::class, 'register']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/me', [AuthController::class, 'me']);
        });
    });

    Route::prefix('/user')->middleware('auth:sanctum')->group(function () {
        Route::delete('/', [UserController::class, 'deleteAccount']);
        Route::post('/password/change', [UserController::class, 'changePassword']);
        Route::post('/profile', [UserController::class, 'updateProfile']);
    });
});

Route::get('/send', [PasswordResetController::class, 'sendResetLinkEmail']);
