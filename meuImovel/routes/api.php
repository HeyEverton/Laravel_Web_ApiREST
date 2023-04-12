<?php

use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\RealStateSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('ping', function() {
    return response()->json([
        'message' => 'pong',
    ]);
});

Route::prefix('v1')->namespace('Api')->group(function () {

    Route::post('/login', [LoginJwtController::class, 'login'])->name('login');
    Route::get('/logout', [LoginJwtController::class, 'logout'])->name('logout');
    Route::get('/refresh', [LoginJwtController::class, 'refresh'])->name('refresh');



    Route::get('/search', [RealStateSearchController::class, 'index'])->name('search');
    Route::get('/search/{real_state_id}', [RealStateSearchController::class, 'show'])->name('search_single');



    Route::prefix('real-states')->name('real_states.')->group(function(){

        Route::get('/', [RealStateController::class, 'index'])->middleware('jwt.auth')->name('index');
        Route::get('/{id}', [RealStateController::class, 'show'])->middleware('jwt.auth')->name('show');
        Route::post('/',[RealStateController::class, 'store'])->middleware('jwt.auth')->name('store');
        Route::put('/{id}',[RealStateController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::patch('/{id}',[RealStateController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::delete('/{id}',[RealStateController::class, 'destroy'])->middleware('jwt.auth')->name('destroy');
    });

    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/', [UserController::class, 'index'])->middleware('jwt.auth')->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('jwt.auth')->name('show');
        Route::post('/', [UserController::class, 'store'])->middleware('jwt.auth')->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::patch('/{id}', [UserController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('jwt.auth')->name('destroy');
    });

    Route::prefix('categories')->name('categories.')->group(function () {

        Route::get('/{id}/real-states', [CategoryController::class, 'realState']);

        Route::get('/', [CategoryController::class, 'index'])->middleware('jwt.auth')->name('index');
        Route::get('/{id}', [CategoryController::class, 'show'])->middleware('jwt.auth')->name('show');
        Route::post('/', [CategoryController::class, 'store'])->middleware('jwt.auth')->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::patch('/{id}', [CategoryController::class, 'update'])->middleware('jwt.auth')->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware('jwt.auth')->name('destroy');
    });

    Route::prefix('photos')->name('photos.')->group(function() {
        Route::delete('/{id}', [RealStatePhotoController::class, 'remove'])->name('remove');

        Route::put('/set-thumb/{photoId}/{realStateId}', [RealStatePhotoController::class, 'setThumb'])->name('setThumb');
    });

});
