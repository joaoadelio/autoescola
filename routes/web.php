<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CategoriaHabilitacaoController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\VeiculoRevisaoController;
use App\Http\Controllers\PagamentoTaxaController;

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

Route::get('veiculos/revisao/todos', [VeiculoRevisaoController::class, 'obterAgendamentos'])
    ->middleware(['role:Administrador|Administrativo']);

Route::resource('veiculos/revisao', VeiculoRevisaoController::class)
    ->middleware(['role:Administrador|Administrativo']);

Route::resource('veiculos', VeiculoController::class)
    ->middleware(['role:Administrador|Administrativo']);
/**
 * Rotas das aulas
 */
Route::post('aulas/auditar', [AulaController::class, 'auditarAula'])
    ->middleware(['role:Administrador|Administrativo|Instrutor']);

Route::get('aulas/todas', [AulaController::class, 'obterAulas'])
    ->middleware('auth');

Route::post('aulas/data/aluno', [AulaController::class, 'aulasDataAluno'])
    ->middleware('auth');

Route::get('aulas/reagendamentos', [AulaController::class, 'reagendamentos'])
    ->name('aulas.reagendamento')
    ->middleware(['role:Administrador|Administrativo']);

Route::put('aulas/{aula}/aprovar', [AulaController::class, 'aprovar'])
    ->name('aulas.aprovar')
    ->middleware(['role:Administrador|Administrativo']);

Route::post('horarios', [AulaController::class, 'horarios'])
    ->middleware('auth');

Route::resource('aulas', AulaController::class)
    ->middleware('auth');

/**
 * Rotas das categorias
 */
Route::post('categorias', [CategoriaHabilitacaoController::class, 'obterCategorias'])
    ->middleware('auth');

/**
 * Rota configurações do sistema
 */
Route::get('configuracoes', [ConfiguracoesController::class, 'index'])
    ->name('configuracoes.index')
    ->middleware(['role:Administrador|Administrativo']);

Route::any('configurações', [ConfiguracoesController::class, 'store'])
    ->name('configuracoes.store')
    ->middleware(['role:Administrador|Administrativo']);


/**
 * Rotas de Pagamento de taxas
 */
Route::get('pagamento-taxa', [PagamentoTaxaController::class, 'index'])
    ->name('pagamento-taxa.index')
    ->middleware('auth');

Route::post('pagamento-taxa/{aula}', [PagamentoTaxaController::class, 'pagar'])
    ->name('pagamento-taxa.pagar')
    ->middleware('auth');
