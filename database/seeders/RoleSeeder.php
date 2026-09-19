<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'paciente',      'descripcion' => 'Paciente que agenda citas',       'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'administrador', 'descripcion' => 'Administrador del consultorio',   'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}