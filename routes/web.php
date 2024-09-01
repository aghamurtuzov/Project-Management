<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/detail/{id}', [\App\Http\Controllers\DashboardController::class, 'detail']);
});
Auth::routes(['verify' => true]);
