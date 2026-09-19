<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
Route::middleware(['auth', 'role:paciente'])->group(function () {
    Route::get('/disponibilidad', [DisponibilidadController::class, 'index']);
    Route::post('/citas', [CitaController::class, 'store']);
    Route::get('/historial', [HistorialController::class, 'index']);
});

Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('medicos', MedicoController::class);
    Route::resource('especialidades', EspecialidadController::class);
    Route::resource('horarios', HorarioController::class);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/reportes/ingresos', [ReporteController::class, 'ingresos']);
    Route::get('/analitica/demanda', [AnaliticaController::class, 'demanda']);
});