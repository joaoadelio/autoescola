<?php

namespace App\Http\Controllers;

use App\Models\VeiculoRevisao;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VeiculoRevisaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('veiculos.revisao');
    }

    /**
     * Obtem todos os agendamentos
     *
     * @return JsonResponse
     */
    public function obterAgendamentos(): JsonResponse
    {
        try {
            $data = VeiculoRevisao::with('veiculo')->get();

            return response()->json([
                'message' => 'Revisão agendada com sucesso',
                'data' => $data
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível agendar a revisão',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            foreach ($data['hora_agendamento'] as $agendamento) {
                VeiculoRevisao::create([
                    'veiculo_id' => $data['veiculo_id'],
                    'data_agendamento' => Carbon::createFromFormat('d/m/Y', $data['data_agendamento']),
                    'hora_agendamento' => $agendamento
                ]);
            }

            return response()->json([
                'message' => 'Revisão agendada com sucesso',
                'data' => []
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível agendar a revisão',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VeiculoRevisao $veiculoRevisao
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $agendamentoRevisao = VeiculoRevisao::findOrFail($id);

            $agendamentoRevisao->forceDelete();

            return response()->json([
                'message' => 'Agendamento de revisão cancelado com sucesso'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível deletar agendamento de revisão',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }
}
