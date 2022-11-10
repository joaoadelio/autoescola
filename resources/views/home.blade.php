@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Aulas') }}
                        </div>
                        @if(!auth()->user()->hasRole('Aluno') && !auth()->user()->hasRole('Instrutor'))
                            <div class="col-6" style="text-align: end">
                                <a
                                    type="button"
                                    class="btn btn-outline-primary"
                                    href="{{ route('aulas.create') }}"
                                >
                                    <i class="fa fa-plus"></i>
                                    Cadastrar Aula
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <usuario-calendario></usuario-calendario>
                </div>
            </div>
        </div>
    </div>
@endsection
