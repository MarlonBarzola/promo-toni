<?php
use App\Http\Controllers\Cliente\CodigoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- RUTA PÚBLICA (LANDING) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- RUTAS PROTEGIDAS (DEBEN ESTAR LOGUEADOS) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rutas para el CLIENTE (HINCHA)
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [CodigoController::class, 'index'])->name('dashboard');
        Route::post('/enviar-codigo', [CodigoController::class, 'store'])->name('codigo.store');
    });

    // Rutas para el ADMINISTRADOR
    Route::middleware(['can:access-admin'])->prefix('admin')->group(function () {
        Route::get('/revision', [AdminController::class, 'index'])->name('admin.index');
        Route::patch('/validar-codigo/{codigo}', [AdminController::class, 'update'])->name('admin.validar');
    });
});

require __DIR__.'/auth.php';
