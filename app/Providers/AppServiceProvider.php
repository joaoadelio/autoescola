<?php

namespace App\Providers;

use App\Models\CategoriaHabilitacao;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();


        /**
         * Regra de negocio para que o aluno não possa selecionar categorias A e C por exemplo.
         */
        Validator::extend('categoria_habilitacao', function ($attribute, $value, $parameters, $validator) {
            if (count($value) <= 1 || $validator->getData()['grupo'] != User::ALUNO) {
                return true;
            }

            return array_diff($value, CategoriaHabilitacao::AB) == [];
        });
    }
}
