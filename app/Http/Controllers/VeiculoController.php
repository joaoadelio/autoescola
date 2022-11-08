<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Models\CategoriaHabilitacao;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class VeiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $veiculos = Veiculo::paginate(10);

        return view('veiculos.index')->with([
            'veiculos' => $veiculos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $categoria_habilitacao = CategoriaHabilitacao::all();
        $instrutores = User::role('Instrutor')->get();

        return view('veiculos.form')->with([
            'categoria_habilitacao' => $categoria_habilitacao,
            'instrutores' => $instrutores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VeiculoRequest $request
     * @return RedirectResponse
     */
    public function store(VeiculoRequest $request): RedirectResponse
    {
        try {
            $dados = $request->all();

            Veiculo::create($dados);

            return redirect()->route('veiculos.index');
        } catch (Throwable $throwable) {
            dd($throwable);
            // TODO
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Veiculo $veiculo
     * @return Response
     */
    public function show(Veiculo $veiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Veiculo $veiculo
     * @return Application|Factory|View
     */
    public function edit(Veiculo $veiculo): Application|Factory|View
    {
        $categoria_habilitacao = CategoriaHabilitacao::all();
        $instrutores = User::role('Instrutor')->get();

        return view('veiculos.form')->with([
            'veiculo' => $veiculo,
            'categoria_habilitacao' => $categoria_habilitacao,
            'instrutores' => $instrutores
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VeiculoRequest $request
     * @param Veiculo $veiculo
     * @return RedirectResponse
     */
    public function update(VeiculoRequest $request, Veiculo $veiculo): RedirectResponse
    {
        try {
            $dados = $request->all();

            $veiculo->fill($dados);
            $veiculo->save();

            return redirect()->route('veiculos.index');
        } catch (Throwable $throwable) {
            dd($throwable);
            // TODO
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Veiculo $veiculo
     * @return RedirectResponse
     */
    public function destroy(Veiculo $veiculo): RedirectResponse
    {
        try {
            $veiculo->delete();

            return redirect()->back();
        } catch (Throwable $throwable) {
            dd($throwable);
            // TODO
        }
    }
}
