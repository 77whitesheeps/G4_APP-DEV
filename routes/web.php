<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuincunxCalculatorController;

Route::get('/quincunx-calculator', [QuincunxCalculatorController::class, 'index'])->name('quincunx.calculator');
Route::post('/quincunx-calculator', [QuincunxCalculatorController::class, 'calculate'])->name('quincunx.calculate');