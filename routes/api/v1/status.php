<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
])
    ->name('statuses.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/status', [\App\Http\Controllers\StatusController::class, 'index'])->name('index');
        Route::get('/status/{id}', [\App\Http\Controllers\StatusController::class, 'show'])->name('show');
        Route::post('/status', [\App\Http\Controllers\StatusController::class, 'store'])->name('store');
        Route::patch('/status/{id}', [\App\Http\Controllers\StatusController::class, 'update'])->name('update');
        Route::delete('/status/{id}', [\App\Http\Controllers\StatusController::class, 'destroy'])->name('destroy');

    });
