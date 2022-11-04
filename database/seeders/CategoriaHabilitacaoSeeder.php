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
            'descricao' => 'Motos'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'B',
            'descricao' => 'Carros e veículos de carga leve (até 3.500 kg ou 8 lugares para passageiros)'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'AB',
            'descricao' => 'Carros, Motos e veículos de carga leve (até 3.500 kg ou 8 lugares para passageiros)'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'C',
            'descricao' => 'Caminhões pequenos e outros veículos de carga entre 3.500 e 6000 kgs de peso total)'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'D',
            'descricao' => 'Ônibus e microônibus com mais de 8 lugares para passageiros'
        ]);

        CategoriaHabilitacao::create([
            'categoria' => 'E',
            'descricao' => 'Todos os veículos das categorias B,C e D, além de veículos com reboque '
        ]);
    }
}
