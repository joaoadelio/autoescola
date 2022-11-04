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
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modal-editar-{{ $usuario->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <div class="modal" data-bs-backdrop="static" tabindex="-1"
                                         id="modal-editar-{{ $usuario->id }}">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar usuário - <span
                                                            class="bg-warning">#{{ $usuario->name }}</span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="name" class="col-form-label">Nome <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="name"
                                                                   name="name">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="email" class="col-form-label">Email <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="email"
                                                                   name="email">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="categoria_habilitacao" class="form-label">Categoria
                                                                Habilitação <span class="text-danger">*</span></label>
                                                            <input class="form-control" list="datalistOptions"
                                                                   id="categoria_habilitacao"
                                                                   placeholder="Escolha a categoria"
                                                                   name="categoria_habilitacao">
                                                            <datalist id="datalistOptions">
                                                                @foreach($categoria_habilitacao as $categoria)
                                                                    <option
                                                                        value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="password" class="col-form-label">Senha <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="password"
                                                                   name="password">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="cpf" class="col-form-label">CPF <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="cpf" name="cpf">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="rg" class="col-form-label">RG</label>
                                                            <input type="text" class="form-control" id="rg" name="rg">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="grupo" class="form-label">Grupo <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" list="datalistOptions"
                                                                   id="grupo" name="grupo"
                                                                   placeholder="Escolha o grupo">
                                                            <datalist id="datalistOptions">
                                                                @foreach($grupo_permissao as $key => $grupo)
                                                                    <option value="{{ $key }}">{{ $grupo }}</option>
                                                                @endforeach
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success">Aplicar alterações
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close
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

                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>

    <usuario-form></usuario-form>

{{--    <div class="modal" data-bs-backdrop="static" tabindex="-1" id="modal-novo-usuario">--}}
{{--        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Criar novo usuário</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <form action="{{ route('usuarios.store') }}" method="POST" id="cadastrar-usuario">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="name" class="col-form-label">Nome <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control" id="name" name="name">--}}
{{--                            </div>--}}
{{--                            <div class="col-12 mb-2">--}}
{{--                                <label for="email" class="col-form-label">Email <span--}}
{{--                                        class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control" id="email" name="email">--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="categoria_habilitacao" class="form-label">Categoria Habilitação <span--}}
{{--                                        class="text-danger">*</span></label>--}}
{{--                                <input class="form-control" list="datalistOptions" id="categoria_habilitacao"--}}
{{--                                       placeholder="Escolha a categoria" name="categoria_habilitacao">--}}
{{--                                <datalist id="datalistOptions">--}}
{{--                                    @foreach($categoria_habilitacao as $categoria)--}}
{{--                                        <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </datalist>--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="password" class="col-form-label">Senha <span--}}
{{--                                        class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control" id="password" name="password">--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="cpf" class="col-form-label">CPF <span class="text-danger">*</span></label>--}}
{{--                                <input type="text" class="form-control" id="cpf" name="cpf">--}}
{{--                            </div>--}}
{{--                            <div class="col-12 mb-2">--}}
{{--                                <label for="rg" class="col-form-label">RG</label>--}}
{{--                                <input type="text" class="form-control" id="rg" name="rg">--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="grupo" class="form-label">Grupo <span class="text-danger">*</span></label>--}}
{{--                                <input class="form-control" list="lista-grupo" id="grupo" name="grupo"--}}
{{--                                       placeholder="Escolha o grupo">--}}
{{--                                <datalist id="lista-grupo">--}}
{{--                                    @foreach($grupo_permissao as $key => $grupo)--}}
{{--                                        <option value="{{ $grupo }}">--}}
{{--                                    @endforeach--}}
{{--                                </datalist>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="submit" class="btn btn-success" form="cadastrar-usuario">Salvar</button>--}}
{{--                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
