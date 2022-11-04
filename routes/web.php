<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
//use App\Http\Controllers\VeiculoController;
//use App\Http\Controllers\AulaController;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [UsuarioController::class, 'index'])->name('index');

Route::prefix('usuarios')->name('usuarios.')->middleware(['auth', 'verified', 'role:Administrador'])->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('index');
});

//Route::prefix('veiculos')->name('veiculos.')->middleware(['auth', 'verified'])->group(function () {
//    Route::get('/', [VeiculoController::class, 'index'])->name('index');
//});
//
//Route::prefix('aulas')->name('aulas.')->middleware(['auth', 'verified'])->group(function () {
//    Route::get('/', [AulaController::class, 'index'])->name('index');
//});
