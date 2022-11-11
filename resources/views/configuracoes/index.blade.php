@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Definir Expediente') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('configuracoes.store') }}" method="POST" id="cadastrar-configuracao-horario">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="horario_inicio" class="col-form-label">Horário Inicio <span class="text-danger">*</span></label>
                                <input
                                    type="time"
                                    class="form-control {{ $errors->has('horario_inicio') ? 'is-invalid' : '' }}"
                                    name="horario_inicio"
                                    id="horario_inicio"
                                    value="{{ $configuracao->items['horario_inicio'] ?? old('horario_inicio') }}"
                                >
                                <div id="horario_inicio" class="invalid-feedback">
                                    @if ($errors->has('horario_inicio'))
                                        {{ $errors->first('horario_inicio') }}
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="horario_termino" class="col-form-label">Horário Termino <span class="text-danger">*</span></label>
                                <input
                                    type="time"
                                    class="form-control {{ $errors->has('horario_termino') ? 'is-invalid' : '' }}"
                                    name="horario_termino"
                                    id="horario_termino"
                                    value="{{ $configuracao->items['horario_termino'] ?? old('horario_termino') }}"
                                >
                                <div id="horario_termino" class="invalid-feedback">
                                    @if ($errors->has('horario_termino'))
                                        {{ $errors->first('horario_termino') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success" style="margin-right: 10px" form="cadastrar-configuracao-horario">Salvar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-danger">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
