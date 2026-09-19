<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = DB::table('especialidades')->pluck('id', 'nombre');

        $medicos = [
            ['nombres' => 'Juan',   'apellidos' => 'Pérez',   'email' => 'juan.perez@consultorio.test',   'colegiatura' => 'CMP-10001', 'especialidad' => 'Cardiología',      'tarifa_consulta' => 150.00, 'tarifa_adelanto' => 50.00],
            ['nombres' => 'María',  'apellidos' => 'Gómez',   'email' => 'maria.gomez@consultorio.test',  'colegiatura' => 'CMP-10002', 'especialidad' => 'Pediatría',        'tarifa_consulta' => 120.00, 'tarifa_adelanto' => 40.00],
            ['nombres' => 'Carlos', 'apellidos' => 'Ramos',   'email' => 'carlos.ramos@consultorio.test', 'colegiatura' => 'CMP-10003', 'especialidad' => 'Dermatología',     'tarifa_consulta' => 130.00, 'tarifa_adelanto' => 45.00],
            ['nombres' => 'Ana',    'apellidos' => 'Torres',  'email' => 'ana.torres@consultorio.test',   'colegiatura' => 'CMP-10004', 'especialidad' => 'Ginecología',      'tarifa_consulta' => 140.00, 'tarifa_adelanto' => 50.00],
            ['nombres' => 'Luis',   'apellidos' => 'Vargas',  'email' => 'luis.vargas@consultorio.test',  'colegiatura' => 'CMP-10005', 'especialidad' => 'Traumatología',    'tarifa_consulta' => 160.00, 'tarifa_adelanto' => 60.00],
            ['nombres' => 'Sofía',  'apellidos' => 'Mendoza', 'email' => 'sofia.mendoza@consultorio.test','colegiatura' => 'CMP-10006', 'especialidad' => 'Medicina General', 'tarifa_consulta' => 80.00,  'tarifa_adelanto' => 30.00],
        ];

        foreach ($medicos as $m) {
            DB::table('medicos')->insert([
                'nombres'            => $m['nombres'],
                'apellidos'          => $m['apellidos'],
                'email'              => $m['email'],
                'telefono'           => '999' . rand(100000, 999999),
                'numero_colegiatura' => $m['colegiatura'],
                'especialidad_id'    => $especialidades[$m['especialidad']],
                'tarifa_consulta'    => $m['tarifa_consulta'],
                'tarifa_adelanto'    => $m['tarifa_adelanto'],
                'activo'             => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}