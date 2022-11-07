@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Cadastro de Usuários') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ $usuario ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}" method="POST" id="cadastrar-usuario">
                        @if(!empty($usuario))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="col-form-label">Nome <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    name="name"
                                    id="name"
                                    value="{{ $usuario->name ?? old('name') }}"
                                >
                                <div id="name" class="invalid-feedback">
                                    @if ($errors->has('name'))
                                        {{ $errors->first('name') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email"
                                    name="email"
                                    value="{{ $usuario->email ?? old('email') }}"
                                >
                                <div id="email" class="invalid-feedback">
                                    @if ($errors->has('email'))
                                        {{ $errors->first('email') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="categoria_habilitacao" class="form-label">Categoria Habilitação <span
                                        class="text-danger">*</span></label>
                                <select
                                    class="form-control {{ $errors->has('categoria_habilitacao') ? 'is-invalid' : '' }}"
                                    name="categoria_habilitacao"
                                >
                                    <option value="">Selecione a categoria habilitação</option>
                                    @foreach($categoria_habilitacao as $categoria)
                                        <option
                                            value="{{ $categoria->id }}"
                                            @if($categoria->id == old('categoria_habilitacao') || !empty($usuario->categoria_habilitacao) && $categoria->id == $usuario->categoria_habilitacao[0]['id']) selected @endif
                                        >{{ $categoria->categoria }}</option>
                                    @endforeach
                                </select>
                                <div id="categoria_habilitacao" class="invalid-feedback">
                                    @if ($errors->has('categoria_habilitacao'))
                                        {{ $errors->first('categoria_habilitacao') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="password" class="col-form-label">
                                    Senha @if(!$usuario) <span class="text-danger">*</span> @endif
                                </label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    id="password"
                                    name="password"
                                    value="{{ old('password') }}"
                                >
                                <div id="password" class="invalid-feedback">
                                    @if ($errors->has('password'))
                                        {{ $errors->first('password') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="cpf" class="col-form-label">CPF <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}"
                                    id="cpf"
                                    name="cpf"
                                    value="{{ $usuario->cpf ?? old('cpf') }}"
                                >
                                <div id="cpf" class="invalid-feedback">
                                    @if ($errors->has('cpf'))
                                        {{ $errors->first('cpf') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="rg" class="col-form-label">RG</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="rg"
                                    name="rg"
                                    value="{{ $usuario->rg ?? old('rg') }}"
                                >
                            </div>
                            <div class="col-12">
                                <label for="grupo" class="form-label">Tipo de usuário <span class="text-danger">*</span></label>
                                <select
                                    class="form-control {{ $errors->has('grupo') ? 'is-invalid' : '' }}"
                                    name="grupo"
                                >
                                    <option value="">Selecione o tipo de usuário</option>
                                    @foreach($grupo_permissao as $index => $grupo)
                                        <option
                                            value="{{ $index  }}"
                                            @if($index == old('grupo') || $index == $usuario->grupo) selected @endif
                                        >{{ $grupo }}</option>
                                    @endforeach
                                </select>
                                <div id="name" class="invalid-feedback">
                                    @if ($errors->has('grupo'))
                                        {{ $errors->first('grupo') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success" form="cadastrar-usuario">Salvar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-danger">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
