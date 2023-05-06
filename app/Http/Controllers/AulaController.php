<?php

namespace App\Http\Controllers;

use App\Mail\ReagendarAula;
use App\Models\Aula;
use App\Models\Configuracao;
use App\Models\User;
use App\Models\UsuarioCategoriaHabilitacao;
use App\Models\Veiculo;
use App\Models\VeiculoRevisao;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retorna as aulas com base nas permissões
     *
     * @return JsonResponse
     */
    public function obterAulas(): JsonResponse
    {
        try {
            $usuario = auth()->user();

            if ($usuario->hasRole('Aluno')) {
                $aulas = Aula::withTrashed()
                    ->with([
                        'veiculo' => function($query) {
                            $query->with('instrutor');
                        },
                        'aluno',
                        'categoria'
                    ])
                    ->where('aluno_id', $usuario->id)
                    ->get();

            } else if ($usuario->hasRole('Instrutor')) {
                $veiculos = Veiculo::where('instrutor_id', $usuario->id)->pluck('id')->toArray();

                $aulas = Aula::withTrashed()
                    ->with([
                        'veiculo' => function($query) {
                            $query->with('instrutor');
                        },
                        'aluno',
                        'categoria'
                    ])
                    ->whereIn('veiculo_id', $veiculos)
                    ->get();
            } else {
                $aulas = Aula::withTrashed()
                    ->with([
                        'veiculo'  => function($query) {
                            $query->with('instrutor');
                        },
                        'aluno',
                        'categoria'
                    ])
                    ->get();
            }

            $aulasParseadas = [];

            foreach ($aulas as $aula) {
                $hora_inicio = Carbon::create("$aula->data_agendamento $aula->hora_agendamento")
                    ->format('Y-m-d H:i');

                $hora_termino = Carbon::create("$aula->data_agendamento $aula->hora_agendamento")
                    ->addMinutes(50)
                    ->format('Y-m-d H:i');

                $bg = 'bg-' . Aula::STATUS[$aula->status];

                $aulasParseadas[] = [
                    'title' => "Aula agendada ({$aula->categoria->categoria})",
                    'topic' => "Instrutor: " . $aula->veiculo->instrutor->name,
                    'description' => "
                        Status: <span class='{$bg} text-white p-1 rounded'> $aula->status </span> <br>
                        Veículo: {$aula->veiculo->descricao} <br>
                        Categoria: {$aula->categoria->categoria}
                    ",
                    'with' => "Aluno: " . $aula->aluno->name,
                    'time' => [
                        // "2022-11-16 13:00",
                        'start' => $hora_inicio,
                        'end' => $hora_termino
                    ],
                    'colorScheme' => Aula::STATUS[$aula->status],
                    'isEditable' => in_array($aula->status, Aula::STATUS_EDITAVEIS),
                    'id' => $aula->id,
                    'disableDnD' => ['month', 'week', 'day'],
                    'disableResize' => ['week', 'day'],
                ];
            }

            return response()->json([
                'message' => 'Aula obtidas com sucesso',
                'data' => $aulasParseadas
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possivel obter as Aulas',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna as aulas com status para reagendamento
     *
     * @return Factory|View|Application
     */
    public function reagendamentos(): Factory|View|Application
    {
        $aulas = Aula::with([
            'veiculo' => function($query) {
                $query->with('instrutor');
            },
            'aluno',
            'categoria'
        ])->where('status', 'Analise')->paginate(10);

        return view('aulas.reagendamento')->with([
            'aulas' => $aulas
        ]);
    }

    /**
     * @param Aula $aula
     * @return RedirectResponse
     */
    public function aprovar(Aula $aula): RedirectResponse
    {
        try {
            $aula->status = 'Agendada';
            $aula->save();

            return redirect()->back();
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        $usuario = auth()->user();

        return view('aulas.form')->with([
            'controle' => (int)$usuario->hasRole('Aluno'),
            'usuarioId' => $usuario->id
        ]);
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
            DB::beginTransaction();
            $data = $request->all();

            $veiculo = Veiculo::find($data['veiculo_id']);

            $data['categoria_habilitacaos_id'] = $veiculo->categoriaHabilitacao->id;
            $data['data_agendamento'] = Carbon::createFromFormat('d/m/Y', $data['data_agendamento']);

            $aula = Aula::create($data);

            $this->ajustarCredito($aula->aluno_id, $data['categoria_habilitacaos_id']);

            DB::commit();

            return response()->json([
                'message' => 'Aula agendada com sucesso',
                'data' => $aula
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            dd($throwable);
        }
    }

    /**
     * Atualiza o horario e data da aula
     *
     * @param Aula $aula
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Aula $aula, Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $veiculo = Veiculo::find($aula->veiculo_id);

            $usuario = User::find($aula->aluno_id);

            $aula->categoria_habilitacaos_id = $veiculo->categoriaHabilitacao->id;
            $aula->data_agendamento = Carbon::createFromFormat('d/m/Y', $data['data_agendamento']);
            $aula->status = 'Analise';
            $aula->save();

            DB::commit();

            $this->gerarTaxaReagendamento($aula->refresh());

            Mail::to($usuario)->send(new ReagendarAula($aula->refresh()->toArray()));

            return response()->json([
                'message' => 'Agendamento aula alterada, aguarde até aprovação do administrativo',
                'data' => $aula->refresh()
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();

            return response()->json([
                'message' => 'Não foi possível alterar o agendamento',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Irá gerar uma taxa toda vez que houver um reagamento
     *
     * @param Aula $aula
     * @return void
     */
    public function gerarTaxaReagendamento(Aula $aula): void
    {
        $aula->taxa = true;
        $aula->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Aula $aula
     * @return JsonResponse
     */
    public function destroy(Aula $aula): JsonResponse
    {
        try {
            DB::beginTransaction();

            $aula->status = 'Cancelada';
            $aula->save()
            ;
            $aula->delete();

            $this->ajustarCredito($aula->aluno_id, $aula->categoria_habilitacaos_id, 'delete');

            DB::commit();

            return response()->json([
                'message' => 'Aula cancelada com sucesso'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();

            return response()->json([
                'message' => 'Não foi possível cancelar aula',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Ajusta os créditos das aulas
     *
     * @param int $usuario_id
     * @param int $categoria_habilitacao_id
     * @param string $method
     * @return void
     * @throws Exception
     */
    public function ajustarCredito(int $usuario_id, int $categoria_habilitacao_id, string $method = 'store'): void
    {
        $usuarioCategoriaHabilitacao = UsuarioCategoriaHabilitacao::where([
            'usuario_id' => $usuario_id,
            'categoria_habilitacaos_id' => $categoria_habilitacao_id
        ])->first();

        if ($usuarioCategoriaHabilitacao->credito >= 20) {
            throw new Exception('Usuário não possui credito para categoria selecionada.');
        }

        if ($method === 'store') {
            $usuarioCategoriaHabilitacao->credito = $usuarioCategoriaHabilitacao->credito - 1;
        } else {
            $usuarioCategoriaHabilitacao->credito = $usuarioCategoriaHabilitacao->credito + 1;
        }

        $usuarioCategoriaHabilitacao->save();
    }

    /**
     * Retorna os horarios das aulas, tanto disponiveis quanto ocupados
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function horarios(Request $request): JsonResponse
    {
        try {
            if($request->get('aula_id')) {
                $aula = Aula::find($request->get('aula_id'));

                $data = Carbon::createFromFormat('Y-m-d', $aula->data_agendamento)->format('d/m/Y');
                $veiculo_id = $aula->veiculo_id;
            } else {
                $data = $request->get('data');
                $veiculo_id = $request->get('veiculo_id');
            }

            $configuracao = Configuracao::find(1) ?? [];

            $hora_inicial = $configuracao->items['horario_inicio'] . ':00' ?? config('horario.hora_inicial');
            $hora_final = $configuracao->items['horario_termino'] . ':00' ?? config('horario.hora_final');

            $dataInicial = Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_inicial");
            $dataFinal = Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_final");

            $veiculo = Veiculo::find($veiculo_id);
            $categoria_habilitacaos_id = $veiculo->categoriaHabilitacao->id;

            $agendamento_horas = Aula::where([
                'data_agendamento' => Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'),
                'categoria_habilitacaos_id' => $categoria_habilitacaos_id,
                'veiculo_id' => $veiculo->id
            ])
                ->pluck('hora_agendamento')
                ->toArray();

            $revisoes = VeiculoRevisao::where([
                'data_agendamento' => Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'),
                'veiculo_id' => $veiculo->id
            ])
                ->pluck('hora_agendamento')
                ->toArray();

            $horarios_reservados = array_merge($agendamento_horas, $revisoes);

            $horarios[] = [
                'data' => $data,
                'hora' => $dataInicial->format('H:i'),
                'status' => false
            ];

            for ($x = 0; $x <= $dataInicial->diffInMinutes($dataFinal) - 50; $x++) {
                $hora = $dataInicial->addMinutes(50);

                $horarios[] = [
                    'data' => $data,
                    'hora' => $hora->format('H:i'),
                    'status' => in_array($hora->format('H:i:s'), $horarios_reservados)
                ];
            }

            return response()->json($horarios);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível obter os horários das aulas',
                'error' => $throwable->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna aulas por aluno e data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function aulasDataAluno(Request $request): JsonResponse
    {
        try {
            $alunoId = $request->get('aluno_id');
            $data = $request->get('data');
            $categoriaHabilitacao = $request->get('categoria_habilitacao_id');

            $totalAulas = Aula::where([
                'aluno_id' => $alunoId,
                'data_agendamento' => Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'),
                'categoria_habilitacaos_id' => $categoriaHabilitacao
            ])->count();

            if ($totalAulas >= 3) {
                throw new \Exception('O maximo de aulas por aluno permitidas por data e categoria são 3');
            }

            return response()->json([
                'message' => 'Quantidade de aulas não excedeu o limite diario para categoria selecionada'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => $throwable->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Instrutor audita a aula
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function auditarAula(Request $request): JsonResponse
    {
        try {
            $id = $request->get('aula_id');
            $status = $request->get('status');

            $aula = Aula::findOrFail($id);
            $aula->status  = $status;
            $aula->save();

            return response()->json([
                'message' => 'Aula auditada com sucesso'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Não foi possível auditar a aula'
            ], 500);
        }
    }
}
