<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantingCalculatorController;

Route::get('/planting-calculator', [PlantingCalculatorController::class, 'index'])->name('planting.calculator');
Route::post('/calculate-plants', [PlantingCalculatorController::class, 'calculate'])->name('calculate.plants');
