<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::get('usetdetail','userDetails');
});

Route::controller(UserController::class)->group(function(){
    Route::get('userlist','userlist');
});

Route::post('messages',[MessageController::class,'messages'])->name('sendmessages');
Route::get('getmessages',[MessageController::class,'getmessages'])->name('getmessages');
