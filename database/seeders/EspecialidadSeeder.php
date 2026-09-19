<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            ['nombre' => 'Cardiología',   'descripcion' => 'Enfermedades del corazón y sistema circulatorio.'],
            ['nombre' => 'Pediatría',     'descripcion' => 'Atención médica de niños y adolescentes.'],
            ['nombre' => 'Dermatología',  'descripcion' => 'Enfermedades de la piel, cabello y uñas.'],
            ['nombre' => 'Ginecología',   'descripcion' => 'Salud del sistema reproductor femenino.'],
            ['nombre' => 'Traumatología', 'descripcion' => 'Lesiones del sistema músculo-esquelético.'],
            ['nombre' => 'Medicina General', 'descripcion' => 'Atención médica general y preventiva.'],
        ];

        foreach ($especialidades as $esp) {
            DB::table('especialidades')->insert([
                'nombre'      => $esp['nombre'],
                'descripcion' => $esp['descripcion'],
                'activa'      => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}