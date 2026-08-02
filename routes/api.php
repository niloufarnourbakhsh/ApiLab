<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\GetCurrentUserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LogOutController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AssignRolesToUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login',LoginController::class);
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/currentUser',GetCurrentUserController::class);
    Route::delete('/logout',LogOutController::class);
    Route::apiResource('users',UserController::class);
    Route::post('/users/{user}/roles',AssignRolesToUserController::class);
    Route::apiResource('roles',RoleController::class);
    Route::apiResource('articles',ArticleController::class)->only('index');
});


