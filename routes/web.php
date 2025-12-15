<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CensoController;
use App\Http\Controllers\CuentaContableController;
use App\Http\Controllers\MovimientoController;

Route::get('/', function () {
    return view('welcome');
});

// Debe tener el nombre 'login'
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Debe tener el nombre 'dashboard'
Route::middleware(['auth'])->group(function () {
    Route::get('censo/export', [CensoController::class, 'export'])->name('censo.export');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('censo', App\Http\Controllers\CensoController::class)->parameters([
        'censo' => 'hermano', // Le decimos a Laravel: para la URL /censo/{param}, usa 'hermano'
    ]);
    Route::put('/profile', [App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');
    Route::resource('cuentas', CuentaContableController::class);
    Route::get('tesoreria/contabilidad', [MovimientoController::class, 'dashboard'])->name('tesoreria.dashboard');
    Route::resource('movimientos', MovimientoController::class)->except(['index', 'show']);
    Route::get('movimientos/listado', [MovimientoController::class, 'index'])->name('movimientos.index');
});