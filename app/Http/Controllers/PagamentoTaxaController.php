<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PagamentoTaxaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $aulas = Aula::with([
            'veiculo' => function($query) {
                return $query->with('instrutor');
            },
            'categoria'
        ])
            ->where([
                'aluno_id' => auth()->user()->id,
                'taxa' => true
            ])
            ->paginate(10);

        return view('pagamento-taxa.index')->with([
            'aulas' => $aulas
        ]);
    }

    /**
     * Faz o pagamento da aula
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function pagar(int $id): RedirectResponse
    {
        try {
            $aula = Aula::find($id);

            $aula->status = 'Agendada';
            $aula->taxa = false;
            $aula->save();

            return redirect()->back();
        } catch (\Throwable $throwable) {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
