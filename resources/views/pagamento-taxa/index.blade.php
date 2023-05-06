@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Pagamento de taxa') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(count($aulas))
                        <table class="table table-hover">
                            <thead>
                            <th>Categoria</th>
                            <th>Veículo</th>
                            <th>Instrutor</th>
                            <th>Data reagendamento</th>
                            <th>Hora reagendamento</th>
                            <th>Valor taxa</th>
                            <th>Ações</th>
                            </thead>
                            <tbody>
                            @foreach($aulas as $aula)
                                <tr>
                                    <td valign="middle">{{ $aula->categoria->categoria }}</td>
                                    <td valign="middle">{{ $aula->veiculo->descricao }}</td>
                                    <td valign="middle">{{ $aula->veiculo->instrutor->name }}</td>
                                    <td valign="middle">{{ \Carbon\Carbon::create($aula->data_agendamento)->format('d/m/Y') }}</td>
                                    <td valign="middle">{{ $aula->hora_agendamento }}</td>
                                    <td valign="middle">R$ 150,00</td>
                                    <td valign="middle" style="display:flex">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-success"
                                            title="Pagar Taxa"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalPagamentoTaxa-{{ $aula->id }}"
                                            style="margin-right: 5px"
                                        >
                                            <i class="fa fa-dollar"></i>
                                        </button>

                                        <div class="modal fade" role="dialog" id="modalPagamentoTaxa-{{ $aula->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        Confirmar pagamento
                                                    </div>
                                                    <div class="modal-body">
                                                        Dados Aula<br> <br>
                                                        Categoria: {{ $aula->categoria->categoria }} <br>
                                                        Instrutor: {{ $aula->veiculo->instrutor->name }} <br>
                                                        Data: {{ \Carbon\Carbon::create($aula->data_agendamento)->format('d/m/Y') }} <br>
                                                        Hora: {{ $aula->hora_agendamento }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('pagamento-taxa.pagar', $aula->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-success">Pagar</button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Cancelar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $aulas->links() }}
                    @else
                        <div class="p-5 text-center">
                            Não há taxas
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
