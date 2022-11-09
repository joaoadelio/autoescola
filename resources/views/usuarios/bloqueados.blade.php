@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Usuários bloqueados') }}
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
                                <tr >
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->cpf }}</td>
                                    <td>{{ $usuario->rg !== '' ? $usuario->rg : '-' }}</td>
                                    <td>0</td>
                                    <td style="display:flex">
                                        <form action="{{ route('usuarios.restaurar', $usuario->id) }}" method="POST">
                                            @method('put')
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-outline-primary"
                                                title="Restaurar Usuários"
                                            >
                                                <i class="fa fa-rotate-right"></i>
                                            </button>
                                        </form>
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
@endsection
