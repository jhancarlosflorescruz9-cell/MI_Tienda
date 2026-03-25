<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\ServicioController; // ← AGREGA ESTA LÍNEA

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS — CLIENTE
|--------------------------------------------------------------------------
*/

Route::get('/', [ClienteController::class, 'index'])->name('home');
// Crear nuevo pedido (POST)
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
Route::post('/pedidos/archivo', [PedidoController::class, 'subirArchivo'])->name('pedidos.archivo');
Route::get('/pedidos/{codigo}/success', [ClienteController::class, 'success'])->name('pedidos.success');



/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS — SEGUIMIENTO
|--------------------------------------------------------------------------
*/

Route::get('/seguimiento', [SeguimientoController::class, 'index'])->name('seguimiento.index');
Route::get('/seguimiento/{codigo}', [SeguimientoController::class, 'buscar'])->name('seguimiento.buscar');

/*
|--------------------------------------------------------------------------
| RUTAS ADMIN — PROTEGIDAS POR MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('pedidos');
    Route::patch('/pedidos/{id}/estado', [AdminController::class, 'cambiarEstado'])->name('pedidos.estado');
    Route::delete('/pedidos/{id}', [AdminController::class, 'eliminar'])->name('pedidos.eliminar');
    Route::get('/exportar/csv', [AdminController::class, 'exportarCSV'])->name('exportar.csv');
    Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('estadisticas');

    // RUTAS DE SERVICIOS
    Route::resource('servicios', ServicioController::class)->except(['show']);
    Route::patch('/servicios/{servicio}/toggle', [ServicioController::class, 'toggle'])->name('servicios.toggle');
});