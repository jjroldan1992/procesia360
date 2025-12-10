<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Debe tener el nombre 'login'
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Debe tener el nombre 'dashboard'
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('censo', App\Http\Controllers\CensoController::class)->parameters([
        'censo' => 'hermano', // Le decimos a Laravel: para la URL /censo/{param}, usa 'hermano'
    ]);
});