<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;

Route::get('/users',[userController::class,'index']);

Route::get('/users/{id}',[userController::class,'show']);

Route::post('/users',[userController::class,'store']);

Route::put('/users/{id}', [userController::class,'update']);

Route::delete('/users/{id}',[userController::class,'destroy']);