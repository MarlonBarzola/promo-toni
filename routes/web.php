<?php

use App\Http\Controllers\Cliente\CodigoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Artisan;

// --- RUTA PÚBLICA (LANDING) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/terminos-y-condiciones', function () {
    return Inertia::render('Terminos');
})->name('terminos');

Route::get('/preguntas-frecuentes', function () {
    return Inertia::render('Faq');
})->name('faq');

Route::get('/ganadores-semanales', function () {
    return Inertia::render('Ganadores');
})->name('ganadores');

// --- RUTAS PROTEGIDAS (DEBEN ESTAR LOGUEADOS) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Rutas para el CLIENTE (HINCHA)
    Route::prefix('ingresar-codigo')->group(function () {
        Route::get('/', [CodigoController::class, 'index'])->name('dashboard');
        Route::post('/enviar-codigo', [CodigoController::class, 'store'])->name('codigo.store');
    });

    // Rutas para el ADMINISTRADOR
    Route::middleware(['can:access-admin'])->prefix('admin')->group(function () {
        Route::get('/revision', [AdminController::class, 'index'])->name('admin.index');
        Route::patch('/validar-codigo/{codigo}', [AdminController::class, 'update'])->name('admin.validar');
        Route::get('/reportes', [AdminController::class, 'reportes'])->name('admin.reportes');
        Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    });
});

require __DIR__ . '/auth.php';
