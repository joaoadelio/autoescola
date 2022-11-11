<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna as configuracoes, nesse cenario irá ser sempre 1
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $configuracao = Configuracao::find(1) ?? [];

        return view('configuracoes.index')->with([
            'configuracao' => $configuracao
        ]);
    }


    /**
     * Cadastra e atualiza o horario
     *
     * @param Request $request
     * @return View|Factory|RedirectResponse|Application
     */
    public function store(Request $request): View|Factory|RedirectResponse|Application
    {
        try {
            $dados = $request->all();

            $dados = [
                'items' => [
                    'horario_inicio' => $dados['horario_inicio'],
                    'horario_termino' => $dados['horario_termino'],
                ]
            ];

            $configuracao = Configuracao::create($dados);

            return view('configuracoes.index')->with([
                'configuracao' => $configuracao->refresh()
            ]);
        } catch (\Throwable $throwable) {
            dd($throwable);
            return back()->withInput();
        }
    }
}
