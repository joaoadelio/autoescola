<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CategoriaHabilitacaoController;

Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }

    return view('auth/login');
});

/**
 * Rotas de autenticacao
 */
Auth::routes();

/**
 * Rota inicial
 */
Route::get('/inicio', [HomeController::class, 'index'])->name('home');

/**
 * Rotas dos usuarios
 */
Route::get('usuarios/obter/{role}', [UsuarioController::class, 'obterUsuarios'])
    ->name('usuarios.tipo')
    ->middleware(['role:Administrador|Administrativo']);

Route::get('usuarios/bloqueados', [UsuarioController::class, 'usuariosBloqueados'])
    ->name('usuarios.bloqueados')
    ->middleware(['role:Administrador|Administrativo']);

Route::put('usuarios/{usuario}/restaurar', [UsuarioController::class, 'restaurar'])
    ->name('usuarios.restaurar')
    ->middleware(['role:Administrador|Administrativo']);

Route::resource('usuarios', UsuarioController::class)
    ->middleware(['role:Administrador|Administrativo']);

/**
 * Rotas dos veiculos
 */
Route::post('veiculos/obter', [VeiculoController::class, 'obterVeiuculos'])
    ->middleware('auth');

Route::resource('veiculos', VeiculoController::class)
    ->middleware(['role:Administrador|Administrativo']);
/**
 * Rotas das aulas
 */
Route::get('aulas/todas', [AulaController::class, 'obterAulas'])
    ->middleware('auth');

Route::post('aulas/data/aluno', [AulaController::class, 'aulasDataAluno'])
    ->middleware('auth');

Route::post('horarios', [AulaController::class, 'horarios'])
    ->middleware('auth');

Route::resource('aulas', AulaController::class)
    ->middleware('auth');

/**
 * Rotas das categorias
 */
Route::post('categorias', [CategoriaHabilitacaoController::class, 'obterCategorias'])
    ->middleware('auth');

