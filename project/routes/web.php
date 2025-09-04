<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TriangularCalculatorController;

Route::get('/triangular-planting', [TriangularCalculatorController::class, 'showForm']);
Route::post('/triangular-planting', [TriangularCalculatorController::class, 'calculate']);
