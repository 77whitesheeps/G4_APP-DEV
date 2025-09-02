<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleController;

//Keandra acosta here, currently we are fixing the routes and pages, so everytime the web is running, 
// it will automatically redirect to this calculator for now. We will be implementing the bootsrap designs prolly tommorrow.

Route::get('/', function () {
    return view('register');
}); 

Route::get('/register', [RegistrationController::class, 'showForm']);
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/login', [LoginController::class, 'showForm']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
use App\Http\Controllers\ResetPasswordController;
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
use App\Http\Controllers\PlantingCalculatorController;

Route::get('/', function () {
    return redirect()->route('planting.calculator');
});

Route::get('/planting-calculator', [PlantingCalculatorController::class, 'index'])->name('planting.calculator');
Route::post('/calculate-plants', [PlantingCalculatorController::class, 'calculate'])->name('calculate.plants');

