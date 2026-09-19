<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'nombre');

        // Administrador
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin Consultorio',
            'email'      => 'admin@consultorio.test',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role_user')->insert([
            'user_id' => $adminId,
            'role_id' => $roles['administrador'],
        ]);

        // Paciente de prueba
        $pacienteId = DB::table('users')->insertGetId([
            'name'              => 'María López',
            'email'             => 'paciente@consultorio.test',
            'password'          => Hash::make('password'),
            'telefono'          => '987654321',
            'fecha_nacimiento'  => '1990-05-15',
            'documento_identidad' => '12345678',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
        DB::table('role_user')->insert([
            'user_id' => $pacienteId,
            'role_id' => $roles['paciente'],
        ]);
    }
}