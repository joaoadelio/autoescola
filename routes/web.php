<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AulaController;
use Illuminate\Http\Request;

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
    ->middleware(['role:Administrador']);

Route::resource('usuarios', UsuarioController::class)
    ->middleware(['role:Administrador']);


/**
 * Rotas dos veiculos
 */
Route::post('veiculos/obter', [VeiculoController::class, 'obterVeiuculos'])
    ->name('veiculos.categoria')
    ->middleware(['role:Administrador']);

Route::resource('veiculos', VeiculoController::class)
    ->middleware(['role:Administrador']);


/**
 * Rotas das aulas
 */
Route::resource('aulas', AulaController::class)
    ->middleware(['role:Administrador']);


Route::post('horarios', function (Request $request) {
    $data = $request->get('data');

    $hora_inicial = config('horario.hora_inicial');
    $hora_final = config('horario.hora_final');

    $dataInicial = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_inicial");
    $dataFinal = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_final");

    $horarios[] =[
        'data' => $data,
        'hora' => $dataInicial->format('H:i:s'),
        'status' => false
    ];

    for ($x = 0; $x <= $dataInicial->diffInMinutes($dataFinal) - 50; $x++) {
        $horarios[] = [
            'data' => $data,
            'hora' => $dataInicial->addMinutes(50)->format('H:i:s'),
            'status' => false
        ];
    }

    return response()->json($horarios);
});
