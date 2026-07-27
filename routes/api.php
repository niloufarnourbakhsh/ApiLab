<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login',LoginController::class);
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('users',UserController::class);
    Route::apiResource('articles',ArticleController::class)->only('index');
});


