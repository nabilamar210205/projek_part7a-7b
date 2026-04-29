<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('student', StudentController::class);
