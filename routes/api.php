<?php

use App\Http\Controllers\ServerController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UploaderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('user', [UserController::class,'userinfo']);
    Route::get('refresh', [UserController::class,'refresh']);
    Route::post('logout', [UserController::class,'logout']);
    Route::put('update', [UserController::class,'update']);


    Route::post('server', [ServerController::class,'store']);
    Route::delete('server', [ServerController::class,'destroy']);
    Route::put('server', [ServerController::class,'update']);
    Route::get('server',[ServerController::class,'show']);
    
    Route::post('join/{code}', [SubscriptionController::class,'join']);
    Route::get('join/server',[SubscriptionController::class,'index']);
    Route::delete('leave/{code}',[SubscriptionController::class,'destroy']);
    Route::get('subscriptions/{code}',[SubscriptionController::class,'server_subscribers']);


    Route::post('task',[TaskController::class,'store']);
    Route::put('task/{id}',[TaskController::class,'update']);
    Route::delete('task/{id}',[TaskController::class,'destroy']);
    Route::get('task/{code}',[TaskController::class,'index']);
    Route::get('task/show/{id}',[TaskController::class,'show']);


    Route::post('user/task',[UserTaskController::class,'store']);
    Route::delete('user/task',[UserTaskController::class,'destroy']);
    Route::put('user/task/{task_id}',[UserTaskController::class,'update']);


    Route::post('upload',[UploaderController::class,'upload']);

    
    });



