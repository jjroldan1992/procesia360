<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CensoController;
use App\Http\Controllers\CuentaContableController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NavMenuController;

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
    
    Route::get('tesoreria/contabilidad', [MovimientoController::class, 'dashboard'])->name('tesoreria.dashboard');
    
    Route::resource('movimientos', MovimientoController::class)->except(['index', 'show']);
    
    Route::get('movimientos/listado', [MovimientoController::class, 'index'])->name('movimientos.index');
    
    Route::prefix('configuracion')->name('config.')->group(function () {
        Route::get('/', [ConfigController::class, 'index'])->name('index'); 
        Route::resource('tarifas', App\Http\Controllers\CuotaTarifaController::class)->names('tarifas');
        Route::resource('cuentas', App\Http\Controllers\CuentaContableController::class)->names('cuentas');
    });
    
    Route::prefix('documentos')->name('documentos.')->group(function () {
        Route::get('/{path?}', [DocumentoController::class, 'index'])->name('index')->where('path', '.*');
        Route::post('/upload', [DocumentoController::class, 'upload'])->name('upload');
        Route::post('/mkdir', [DocumentoController::class, 'createFolder'])->name('createFolder');
        Route::delete('/delete', [DocumentoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/web')->name('admin.web.')->group(function () {
        Route::resource('paginas', PostController::class);
        Route::get('configuracion', [WebSettingController::class, 'index'])->name('config.index');
        Route::post('configuracion/update', [WebSettingController::class, 'update'])->name('config.update');
        Route::get('modulos', [ModuleController::class, 'index'])->name('modulos.index');
        Route::post('modulos/toggle/{modulo}', [ModuleController::class, 'toggle'])->name('modulos.toggle');
        Route::resource('modulos/menu', NavMenuController::class)->names('modulos.menu');
        Route::post('modulos/menu/reorder', [NavMenuController::class, 'reorder'])->name('modulos.menu.reorder');
    });
});