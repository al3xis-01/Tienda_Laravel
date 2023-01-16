<?php

use App\Http\Controllers\AltaProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    Route::get('/', 'InicioController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/Registro', 'RegistroController@show')->name('register.show');
        Route::post('/Registro', 'RegistroController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/Acceder', 'AccederController@show')->name('login.show');
        Route::post('/Acceder', 'AccederController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/Salir', 'LogoutController@perform')->name('logout.perform');

        Route::resource('Categoria', CategoriaController::class);
        Route::post('Categoria-Eliminar', [CategoriaController::class,'destroy']);
        Route::get('Categoria-Lista', [CategoriaController::class,'list_combo']);

        Route::resource('Proveedor', ProveedorController::class);
        Route::post('Proveedor-Eliminar', [ProveedorController::class,'destroy']);
        Route::get('Proveedor-Lista', [ProveedorController::class,'list_combo']);

        Route::resource('Producto', ProductoController::class);
        Route::post('Producto-Eliminar', [ProductoController::class,'destroy']);
        Route::get('Producto-Lista', [ProductoController::class,'list_combo']);

        Route::resource('Usuario', UsuarioController::class);
        Route::post('Usuario-Eliminar', [UsuarioController::class,'destroy']);

        Route::get('Tienda', [TiendaController::class,'index'])->name('Tienda.index');
        Route::post('Tienda', [TiendaController::class,'store'])->name('Tienda.store');
        Route::get('Tienda/Seccion', [TiendaController::class,'showSecciones'])->name('Tienda.showSecciones');
        Route::get('Tienda/Producto/Categoria/{id}', [TiendaController::class,'searchProductoByCetegoria'])->name('Tienda.producto_categoria');
        Route::get('Tienda/Ticket/{id}', [TiendaController::class,'getTicket'])->name('Tienda.ticket');

        Route::resource('AltaProducto', AltaProductoController::class);

        Route::get('Inventario-Lista',[InventarioController::class,'list_inventario']);


    });
});
