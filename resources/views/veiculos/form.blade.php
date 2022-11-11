@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Cadastro de Veículos') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ isset($veiculo) ? route('veiculos.update', $veiculo->id) : route('veiculos.store') }}" method="POST" id="cadastrar-veiculo">
                        @if(isset($veiculo))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="descricao" class="col-form-label">Descrição <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}"
                                    name="descricao"
                                    id="descricao"
                                    placeholder="Gol 1.4 Flex 4p 16v"
                                    value="{{ $veiculo->descricao ?? old('descricao') }}"
                                >
                                <div id="descricao" class="invalid-feedback">
                                    @if ($errors->has('descricao'))
                                        {{ $errors->first('descricao') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="placa" class="col-form-label">Placa <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('placa') ? 'is-invalid' : '' }}"
                                    id="placa"
                                    name="placa"
                                    value="{{ $veiculo->placa ?? old('placa') }}"
                                >
                                <div id="placa" class="invalid-feedback">
                                    @if ($errors->has('placa'))
                                        {{ $errors->first('placa') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="ano_modelo" class="col-form-label">Ano Modelo <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('ano_modelo') ? 'is-invalid' : '' }}"
                                    id="ano_modelo"
                                    name="ano_modelo"
                                    value="{{ $veiculo->ano_modelo ?? old('ano_modelo') }}"
                                >
                                <div id="cpf" class="invalid-feedback">
                                    @if ($errors->has('ano_modelo'))
                                        {{ $errors->first('ano_modelo') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="ano_fabricacao" class="col-form-label">
                                    Ano Fabricação
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('ano_fabricacao') ? 'is-invalid' : '' }}"
                                    id="ano_fabricacao"
                                    name="ano_fabricacao"
                                    value="{{ $veiculo->ano_fabricacao ?? old('ano_fabricacao') }}"
                                >
                                <div id="ano_fabricacao" class="invalid-feedback">
                                    @if ($errors->has('ano_fabricacao'))
                                        {{ $errors->first('ano_fabricacao') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="categoria_habilitacaos_id" class="form-label">
                                    Categoria <span class="text-danger">*</span>
                                </label>
                                <select
                                    class="form-control {{ $errors->has('categoria_habilitacaos_id') ? 'is-invalid' : '' }}"
                                    name="categoria_habilitacaos_id"
                                >
                                    <option value="">Selecione a categoria</option>
                                    @foreach($categoria_habilitacao as $categoria)
                                        <option
                                            value="{{ $categoria->id }}"
                                            @if($categoria->id == old('categoria_habilitacaos_id') || !empty($veiculo->categoria_habilitacaos_id) && $categoria->id == $veiculo->categoria_habilitacaos_id) selected @endif
                                        >
                                            {{ $categoria->categoria }} ({{ $categoria->alias }})
                                        </option>
                                    @endforeach
                                </select>
                                <div id="categoria_habilitacaos_id" class="invalid-feedback">
                                    @if ($errors->has('categoria_habilitacaos_id'))
                                        {{ $errors->first('categoria_habilitacaos_id') }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="instrutor_id" class="form-label">
                                    Instrutor
                                </label>
                                <select
                                    class="form-control {{ $errors->has('instrutor_id') ? 'is-invalid' : '' }}"
                                    name="instrutor_id"
                                >
                                    <option value="">Selecione o instrutor</option>
                                    @foreach($instrutores as $instrutor)
                                        <option
                                            value="{{ $instrutor->id }}"
                                            @if($instrutor->id == old('instrutor_id') || !empty($veiculo->instrutor_id) && $instrutor->id == $veiculo->instrutor_id) selected @endif
                                        >
                                            {{ $instrutor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="instrutor_id" class="invalid-feedback">
                                    @if ($errors->has('instrutor_id'))
                                        {{ $errors->first('instrutor_id') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success" form="cadastrar-veiculo">Salvar</button>
                    <a href="{{ route('veiculos.index') }}" class="btn btn-outline-danger">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#placa').mask('SSS0A00', {
                placeholder: "LLLNLNN / LLLNNNN"
            });
            $('#ano_fabricacao').mask('9999', {
                placeholder: "0000"
            });
            $('#ano_modelo').mask('9999', {
                placeholder: "0000"
            });
        });
    </script>
@endsection
