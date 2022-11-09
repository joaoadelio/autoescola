<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Mail\CadastroUsuario;
use App\Models\CategoriaHabilitacao;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'grupo_permissao' => User::GRUPO
        ]);
    }

    public function create(): Factory|View|Application
    {
        $categoria_habilitacao = CategoriaHabilitacao::all();

        return view('usuarios.form')->with([
            'usuario' => null,
            'categoria_habilitacao' => $categoria_habilitacao,
            'grupo_permissao' => User::GRUPO
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
            $grupo_permissao = User::GRUPO;

            if (!array_key_exists($dados['grupo'], $grupo_permissao)) {
                throw new Exception('Inserir grupo existente');
            }

            $dados['password'] = Hash::make($dados['password']);

            $usuario = User::create($dados);

            $usuario->assignRole($grupo_permissao[$dados['grupo']]);
            $usuario->categoriaHabilitacao()->sync($dados['grupo']);

            Mail::to($usuario)->send(new CadastroUsuario($dados));

            return redirect()->route('usuarios.index');
        } catch (Throwable $throwable) {
            dd($throwable);
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
            'grupo_permissao' => User::GRUPO
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
            $grupo_permissao = User::GRUPO;

            if (!array_key_exists($dados['grupo'], $grupo_permissao)) {
                throw new Exception('Inserir grupo existente');
            }

            $permissao = $grupo_permissao[$dados['grupo']];

            if (empty($dados['password'])) {
                unset($dados['password']);
            } else {
                $dados['password'] = Hash::make($dados['password']);
            }

            $usuario->fill($dados);
            $usuario->save();

            $usuario->assignRole($permissao);
            $usuario->categoriaHabilitacao()->sync($dados['categoria_habilitacao']);

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

    public function obterUsuarios(string $tipo)
    {
        try {
            $usuarios = User::role($tipo)
                ->whereHas('categoriaHabilitacao')
                ->with('categoriaHabilitacao')
                ->get();


            return response()->json([
                'message' => 'Uusários obtidos com sucesso.',
                'data' => $usuarios
            ]);
        } catch (Throwable $throwable) {
            dd($throwable);
        }
    }
}
