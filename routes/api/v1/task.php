<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth:sanctum',
])
    ->name('tasks.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('index');
        Route::get('/tasks/{id}', [\App\Http\Controllers\TaskController::class, 'show'])->name('show');
        Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('store');
        Route::patch('/tasks/{id}', [\App\Http\Controllers\TaskController::class, 'update'])->name('update');
        Route::patch('/tasks/status/{id}', [\App\Http\Controllers\TaskController::class, 'updateStatus'])
            ->name('updateStatus');
        Route::delete('/tasks/{id}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('destroy');
        
    });
