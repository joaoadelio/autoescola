<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\CategoriaHabilitacao;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Mockery\Exception;
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
     */
    public function index(): Factory|View|Application
    {
        $usuarios = User::with('categoriaHabilitacao')->paginate(10);

        $categoria_habilitacao = CategoriaHabilitacao::all();

        return view('usuarios.index')->with([
            'usuarios' => $usuarios,
            'categoria_habilitacao' => $categoria_habilitacao,
            'grupo_permissao' => User::grupo
        ]);
    }

    public function create(): Factory|View|Application
    {
        $categoria_habilitacao = CategoriaHabilitacao::all();

        return view('usuarios.form')->with([
            'categoria_habilitacao' => $categoria_habilitacao,
            'grupo_permissao' => User::grupo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UsuarioRequest $request
     * @return RedirectResponse
     */
    public function store(UsuarioRequest $request): RedirectResponse
    {
        try {
            $dados = $request->all();
            $grupo_permissao = User::grupo;

            if (!array_key_exists($dados['grupo'], $grupo_permissao)) {
                throw new Exception('Inserir grupo existente');
            }

            $usuario = User::create($dados);

            $usuario->assignRole($grupo_permissao[$dados['grupo']]);
            $usuario->categoriaHabilitacao()->sync($dados['grupo']);

            return redirect()->route('usuarios.index');
        } catch (Throwable $throwable) {
            // TODO
        }
    }

    public function edit(User $usuario): Factory|View|Application
    {
        $categoria_habilitacao = CategoriaHabilitacao::all();
        $usuario->categoria_habilitacao = $usuario->categoriaHabilitacao ?? null;

        return view('usuarios.form')->with([
            'usuario' => $usuario,
            'categoria_habilitacao' => $categoria_habilitacao,
            'grupo_permissao' => User::grupo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UsuarioRequest $request
     * @param User $usuario
     * @return RedirectResponse
     */
    public function update(UsuarioRequest $request, User $usuario): RedirectResponse
    {
        try {
            $dados = $request->all();
            $grupo_permissao = User::grupo;

            if (!array_key_exists($dados['grupo'], $grupo_permissao)) {
                throw new Exception('Inserir grupo existente');
            }

            $permissao = $grupo_permissao[$dados['grupo']];
            $permissao_id = (int)$dados['grupo'];

//            dd($permissao, $permissao_id);

            if (empty($dados['password'])) {
                unset($dados['password']);
            }

            $usuario->fill($dados);
            $usuario->save();

            $usuario->assignRole($permissao);
            $usuario->categoriaHabilitacao()->sync([$permissao_id]);

            return redirect()->route('usuarios.index');
        } catch (Throwable $throwable) {
            dd($throwable);
            // TODO
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $usuario
     * @return RedirectResponse
     */
    public function destroy(User $usuario): RedirectResponse
    {
        try {
            $usuario->delete();

            return redirect()->back();
        } catch (Throwable $throwable) {
            dd($throwable);
            // TODO
        }
    }
}
