<?php

namespace Database\Seeders;

use App\Models\CategoriaHabilitacao;
use Illuminate\Database\Seeder;

class CategoriaHabilitacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaHabilitacao::create([
            'categoria' => 'A',
            'alias' => 'Motos',
            'descricao' => 'Motos'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'B',
            'alias' => 'Carros',
            'descricao' => 'Carros e veículos de carga leve (até 3.500 kg ou 8 lugares para passageiros)'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'C',
            'alias' => 'Caminhões',
            'descricao' => 'Caminhões pequenos e outros veículos de carga entre 3.500 e 6000 kgs de peso total)'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'D',
            'alias' => 'Ônibus e Microônibus',
            'descricao' => 'Ônibus e microônibus com mais de 8 lugares para passageiros'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'E',
            'alias' => 'Veículos B, C e D e Reboque',
            'descricao' => 'Todos os veículos das categorias B,C e D, além de veículos com reboque '
        ]);
    }
}
