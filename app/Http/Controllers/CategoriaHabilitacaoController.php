<?php

namespace App\Http\Controllers;

use App\Models\CategoriaHabilitacao;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaHabilitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna todas categorias
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function obterCategorias(Request $request): JsonResponse
    {
        try {
            $usuarioAutenticado = auth()->user();

            $aluno = $usuarioAutenticado->hasRole('Aluno') ? $usuarioAutenticado : User::find($request->get('alunoId'));

            $categorias = $aluno->categoriaHabilitacao;

            return response()->json([
                'message' => 'Categorias obtidas com sucesso',
                'data' => $categorias
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível obter as categorias',
                'error' => $throwable->getMessage(),
                'data' => []
            ]);
        }
    }
}
