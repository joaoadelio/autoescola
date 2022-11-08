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
                            <a
                                type="button"
                                class="btn btn-outline-primary"
                                href="{{ route('usuarios.create') }}"
                            >
                                <i class="fa fa-plus"></i>
                                Usuário
                            </a>
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
                                        <a
                                            type="button"
                                            class="btn btn-outline-info"
                                            style="margin-right: 5px"
                                            href="{{ route('usuarios.edit', $usuario->id) }}"
                                        >
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" >
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

                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
