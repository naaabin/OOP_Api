<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectManagerController;
use App\Http\Controllers\Api\TaskManagerController;
use App\Http\Controllers\Api\FilteringController;

Route::get('/user', function (Request $request) {
    return $request->user();
});//->middleware('auth:sanctum');


Route::post('users/store', [UserController::class, 'store'])->name('users.register');

Route::resource('projects', 'App\Http\Controllers\Api\ProjectManagerController');  //to create new project
Route::get('/projectupdatehistory/{id}', [ProjectManagerController::class,'shownotes']);

Route::resource('tasks', 'App\Http\Controllers\Api\TaskManagerController');
Route::get('/taskupdatehistory/{id}', [TaskManagerController::class,'shownotes']);
Route::get('/userdashboard', [TaskManagerController::class,'userdashboard']);

Route::get('/filtering', [FilteringController::class,'filter']);
Route::post('/filtering', [FilteringController::class,'filter']);