@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Usuários') }}</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Crédito</th>
                            <th>Ações</th>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>0</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-editar-{{ $usuario->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <div class="modal" data-bs-backdrop="static" tabindex="-1" id="modal-editar-{{ $usuario->id }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar usuário - <span class="bg-warning">#{{ $usuario->name }}</span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="name" class="col-form-label">Nome</label>
                                                            <input type="text" class="form-control-plaintext" id="name" value="{{ $usuario->name }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="email" class="col-form-label">Email</label>
                                                            <input type="text" class="form-control-plaintext" id="email" value="{{ $usuario->email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success">Aplicar alterações</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
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
@endsection
