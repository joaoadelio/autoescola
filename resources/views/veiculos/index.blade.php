@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Veículos') }}
                        </div>
                        <div class="col-6" style="text-align: end">
                            <a
                                type="button"
                                class="btn btn-outline-primary"
                                href="{{ route('veiculos.create') }}"
                            >
                                <i class="fa fa-plus"></i>
                                Cadastrar Veículo
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <th>Descrição</th>
                            <th>Placa</th>
                            <th>Ano Fabricação / Modelo</th>
                            <th>Categoria</th>
                            <th>Instrutor</th>
                            <th>Ações</th>
                        </thead>
                        <tbody>
                            @foreach($veiculos as $veiculo)
                                <tr>
                                    <td>{{ $veiculo->descricao }}</td>
                                    <td style="text-transform:uppercase">{{ $veiculo->placa }}</td>
                                    <td>{{ $veiculo->ano_fabricacao . ' / ' . $veiculo->ano_modelo }}</td>
                                    <td>{{ $veiculo->categoriaHabilitacao->categoria }}</td>
                                    <td>{{ $veiculo->instrutor->name ?? '-' }}</td>
                                    <td style="display: flex">
                                        <a
                                            type="button"
                                            class="btn btn-outline-info"
                                            style="margin-right: 5px"
                                            href="{{ route('veiculos.edit', $veiculo->id) }}"
                                        >
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" >
                                            @method('DELETE')
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $veiculos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
