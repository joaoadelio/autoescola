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
                        <div class="col-6" style="text-align: end">
                            <a
                                type="button"
                                class="btn btn-outline-primary"
                                href="{{ route('aulas.create') }}"
                            >
                                <i class="fa fa-plus"></i>
                                Aula
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <usuario-calendario></usuario-calendario>
                </div>
            </div>
        </div>
    </div>
@endsection
