@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row flex align-items-center">
                        <div class="col-6">
                            {{ __('Cadastro de Aulas') }}
                        </div>
                    </div>
                </div>

                <aulas-cadastro></aulas-cadastro>

            </div>
        </div>
    </div>
@endsection
