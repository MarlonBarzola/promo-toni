<?php

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LoteController;
use App\Http\Controllers\Admin\ProductoParticipanteController;
use App\Http\Controllers\Admin\TerminosController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GanadoresSemanalesController;
use App\Http\Controllers\Cliente\CodigoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Artisan;

// --- RUTA PÚblica (LANDING) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/terminos-y-condiciones', [HomeController::class, 'terminos'])->name('terminos');

Route::get('/preguntas-frecuentes', [HomeController::class, 'faq'])->name('faq');

Route::get('/productos-participantes', [HomeController::class, 'productos'])->name('productos');

Route::get('/ganadores-semanales', [GanadoresSemanalesController::class, 'public'])->name('ganadores');

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
        Route::get('/ganadores-semanales', [GanadoresSemanalesController::class, 'index'])->name('admin.ganadores');
        Route::post('/ganadores-semanales', [GanadoresSemanalesController::class, 'store'])->name('admin.ganadores.store');
        Route::get('/terminos-y-condiciones', [TerminosController::class, 'edit'])->name('admin.terminos');
        Route::put('/terminos-y-condiciones', [TerminosController::class, 'update'])->name('admin.terminos.update');
        Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq');
        Route::post('/faq', [FaqController::class, 'store'])->name('admin.faq.store');
        Route::put('/faq/{faq}', [FaqController::class, 'update'])->name('admin.faq.update');
        Route::delete('/faq/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');
        Route::get('/productos', [ProductoParticipanteController::class, 'index'])->name('admin.productos');
        Route::post('/productos', [ProductoParticipanteController::class, 'store'])->name('admin.productos.store');
        Route::put('/productos/{producto}', [ProductoParticipanteController::class, 'update'])->name('admin.productos.update');
        Route::delete('/productos/{producto}', [ProductoParticipanteController::class, 'destroy'])->name('admin.productos.destroy');
        Route::get('/lotes', [LoteController::class, 'index'])->name('admin.lotes');
        Route::post('/lotes/import', [LoteController::class, 'import'])->name('admin.lotes.import');
    });
});

require __DIR__ . '/auth.php';
