<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Veiculo;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('aulas.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try  {
            $data = $request->all();

            $veiculo = Veiculo::find($data['veiculo_id']);

            $data['categoria_habilitacaos_id'] = $veiculo->categoriaHabilitacao->id;
            $data['data_agendamento'] = Carbon::createFromFormat('d/m/Y', $data['data_agendamento']);

            $aula = Aula::create($data);

            return response()->json([
                'message' => 'Aula agendada com sucesso',
                'data' => $aula
            ]);
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aula  $aula
     * @return Response
     */
    public function show(Aula $aula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aula  $aula
     * @return Response
     */
    public function edit(Aula $aula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Aula  $aula
     * @return Response
     */
    public function update(Request $request, Aula $aula)
    {
        try  {

        } catch (\Throwable $throwable) {
            dd($throwable);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aula  $aula
     * @return Response
     */
    public function destroy(Aula $aula)
    {
        //
    }

    public function horarios(Request $request)
    {
        try {
            $data = $request->get('data');
            $aluno_id  = $request->get('aluno_id');

            $hora_inicial = config('horario.hora_inicial');
            $hora_final = config('horario.hora_final');

            $dataInicial = Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_inicial");
            $dataFinal = Carbon::createFromFormat('d/m/Y H:i:s', "$data $hora_final");

            $agendamento_horas = Aula::where('data_agendamento', Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'))
                ->pluck('hora_agendamento')->toArray();

//            dd($agendamentos, Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d'));

            $horarios[] =[
                'data' => $data,
                'hora' => $dataInicial->format('H:i'),
                'status' => false
            ];

            for ($x = 0; $x <= $dataInicial->diffInMinutes($dataFinal) - 50; $x++) {
                $hora =  $dataInicial->addMinutes(50);

                $horarios[] = [
                    'data' => $data,
                    'hora' => $hora->format('H:i'),
                    'status' => in_array($hora->format('H:i:s'), $agendamento_horas)
                ];
            }

            return response()->json($horarios);
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
    }
}
