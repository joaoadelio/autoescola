@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Usuários') }}
                        </div>
                        <div class="col-6" style="text-align: end">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-novo-usuario">
                                <i class="fa fa-plus"></i>
                                Usuário
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Crédito</th>
                        <th>Ações</th>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->cpf }}</td>
                                <td>{{ $usuario->rg ?? '-' }}</td>
                                <td>0</td>
                                <td>
                                    <div class="">
                                        <button
                                            type="button"
                                            class="btn btn-warning mr-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-editar-{{ $usuario->id }}"
                                        >
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>

    <usuario-form
        :categoria-habilitacao="{{ json_encode($categoria_habilitacao) }}"
        :roles="{{ json_encode($grupo_permissao) }}"
    ></usuario-form>
@endsection
