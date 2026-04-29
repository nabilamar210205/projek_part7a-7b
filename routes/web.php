<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API Client Routes
Route::get('/student', [StudentController::class, 'index']);
Route::post('/student', [StudentController::class, 'store']);
Route::get('/student/{id}/edit', [StudentController::class, 'edit']);
Route::put('/student/{id}', [StudentController::class, 'update']);
Route::delete('/student/{id}', [StudentController::class, 'destroy']);
