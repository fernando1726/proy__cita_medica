<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisponibilidadController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AnaliticaController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Rutas para Paciente
Route::middleware(['auth', 'role:paciente'])->group(function () {
    Route::get('/disponibilidad',              [DisponibilidadController::class, 'index']);   // RF-01
    Route::post('/citas',                      [CitaController::class, 'store']);             // RF-02
    Route::put('/citas/{cita}/reprogramar',    [CitaController::class, 'reprogramar']);      // RF-03
    Route::delete('/citas/{cita}',             [CitaController::class, 'cancelar']);         // RF-03
    Route::get('/historial',                   [HistorialController::class, 'index']);       // RF-04
    Route::get('/historial/{cita}/pdf',        [HistorialController::class, 'descargarPdf']); // RF-04
});

// Rutas para Administrador
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('medicos',        MedicoController::class);         // RF-05
    Route::resource('especialidades', EspecialidadController::class);   // RF-05
    Route::resource('horarios',       HorarioController::class);        // RF-05
    Route::get('/agenda',             [HorarioController::class, 'agenda']);      // RF-06
    Route::get('/dashboard',          [DashboardController::class, 'index']);     // RF-07
    Route::get('/reportes/ingresos',  [ReporteController::class, 'ingresos']);    // RF-08
    Route::get('/analitica/demanda',  [AnaliticaController::class, 'demanda']);   // RF-09
});
// Rutas protegidas por rol
Route::middleware(['auth:sanctum', 'role:administrador'])->group(function () {
    Route::apiResource('especialidades', EspecialidadController::class);
    Route::apiResource('medicos',        MedicoController::class);
    Route::apiResource('horarios',       HorarioController::class)->except(['update']);
    Route::post('/horarios/marcar-festivo', [HorarioController::class, 'marcarFestivo']);
});