<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrador',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Administrativo',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Instrutor',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'Aluno',
            'guard_name' => 'web'
        ]);
    }
}
