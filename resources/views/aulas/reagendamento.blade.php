@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Aprovação de Aulas') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(count($aulas))
                        <table class="table table-striped">
                            <thead>
                                <th>Aluno</th>
                                <th>Categoria</th>
                                <th>Veiculo</th>
                                <th>Data Agendamento</th>
                                <th>Hora Agendamento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </thead>
                            <tbody>
                            @foreach($aulas as $aula)
                                <tr>
                                    <td>{{ $aula->aluno->name }}</td>
                                    <td>{{ $aula->categoria->categoria }}</td>
                                    <td>{{ $aula->veiculo->descricao }}</td>
                                    <td>{{ \Carbon\Carbon::create($aula->data_agendamento)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::create($aula->hora_agendamento)->format('H:s') }}</td>
                                    <td> <span class="badge bg-warning">{{ $aula->status }}</span></td>
                                    <td style="display: flex">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#aprovar-aula-{{$aula->id}}"
                                        >
                                            <i class="fa fa-check"></i>
                                        </button>

                                        <div class="modal" id="aprovar-aula-{{$aula->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Aprovar aula #{{ $aula->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Tem certeza que deseja aprovar esta aula ?

                                                        <form action="{{ route('aulas.aprovar', $aula->id) }}" id="aprovar-{{ $aula->id }}" method="POST">
                                                            @method('PUT')
                                                            @csrf

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-outline-success" form="aprovar-{{ $aula->id }}">Aprovar</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
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
                            Não há reagendamentos
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
