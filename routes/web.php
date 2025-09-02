<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantingCalculatorController;

Route::get('/', function () {
    return redirect()->route('planting.calculator');
});

Route::get('/planting-calculator', [PlantingCalculatorController::class, 'index'])->name('planting.calculator');
Route::post('/calculate-plants', [PlantingCalculatorController::class, 'calculate'])->name('calculate.plants');
