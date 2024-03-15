<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth:sanctum',
])
    ->name('users.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'listUsers'])
            ->name('listUsers')
            ->withoutMiddleware('auth');
        Route::get('/users/info', [\App\Http\Controllers\UserController::class, 'infoUser'])
            ->name('infoUser')
            ->withoutMiddleware('auth');

        Route::get('/users/{user_id}', [\App\Http\Controllers\UserController::class, 'show'])
            ->name('show')
            ->whereNumber('user');

        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('store');

        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');

        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });
