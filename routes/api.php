<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'v1'], function () {
    Route::get('/project/search', [ProjectController::class, 'search']);
    Route::apiResource('/project', ProjectController::class);
    Route::get('/task/search', [TaskController::class, 'search']);
    Route::apiResource('/task', TaskController::class);
});
