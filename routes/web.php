<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AulaController;

Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }

    return view('auth/login');
});

Auth::routes();

Route::get('/inicio', [HomeController::class, 'index'])->name('home');

Route::resource('usuarios', UsuarioController::class)
    ->middleware(['role:Administrador']);

Route::resource('veiculos', VeiculoController::class)
    ->middleware(['role:Administrador']);

Route::resource('aulas', AulaController::class)
    ->middleware(['role:Administrador']);
