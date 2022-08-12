<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\UserControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function(){
    return ['pong'];
});

//Routes products
Route::namespace('Api')->group(function(){
    
    Route::prefix('products')->group(function() {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'save']);//->middleware('auth.basic');
        Route::put('/', [ProductController::class, 'update']);
        Route::patch('/', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });


    
});

