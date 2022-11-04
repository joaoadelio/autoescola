<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\CategoriaHabilitacao;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index(): Factory|View|Application
    {
        $usuarios = User::paginate(10);
        $categoria_habilitacao = CategoriaHabilitacao::all();

        return view('usuarios.index')->with([
            'usuarios' => $usuarios,
            'categoria_habilitacao' => $categoria_habilitacao,
            'grupo_permissao' => User::grupo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UsuarioRequest $request
     * @return Response
     */
    public function store(UsuarioRequest $request)
    {
        try {
            $dados = $request->all();

            dd($dados);

        } catch (Throwable $throwable) {

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
