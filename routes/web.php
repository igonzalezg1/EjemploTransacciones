<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\VentasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('verProductos', [ProductosController::class, 'verProductos'])->name('verProductos');

    Route::post('agregaracarrito', [ProductosController::class, 'agregaracarrito'])->name('agregaracarrito');

    Route::get('vercarrito', [ProductosController::class, 'vercarro'])->name('vercarrito');

    Route::post('quitardecarro', [ProductosController::class, 'quitardecarro'])->name('quitardecarro');

    Route::post('crearventa', [VentasController::class, 'crearventa'])->name('crearventa');

    Route::get('agregarTarjeta', [VentasController::class, 'agregarTarjeta'])->name('agregarTarjeta');

    Route::post('agregarTarjetap', [VentasController::class, 'agregarTarjetap'])->name('agregarTarjetap');

    Route::get('verventas', [VentasController::class, 'verventas'])->name('verventas');
});
