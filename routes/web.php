<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('listacategorias/reporte/pdf', [CategoriaController::class, 'reportePdf'])
        ->name('listacategorias.pdf');

    Route::get('listacategorias/reporte/excel', [CategoriaController::class, 'reporteExcel'])
        ->name('listacategorias.excel');

    Route::get('listaproductos/reporte/pdf', [ProductoController::class, 'reportePdf'])
        ->name('listaproductos.pdf');

    Route::get('listaproductos/reporte/excel', [ProductoController::class, 'reporteExcel'])
        ->name('listaproductos.excel');

    Route::resource('listaproductos', ProductoController::class)->names('listaproductos');
    Route::resource('listacategorias', CategoriaController::class)->names('listacategorias');
});

Route::redirect('/productos', '/listaproductos');
Route::redirect('/categorias', '/listacategorias');

require __DIR__.'/auth.php';
