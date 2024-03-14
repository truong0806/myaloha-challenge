<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
//    'auth:api',
])
    ->name('users.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::post('/register', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
    });
