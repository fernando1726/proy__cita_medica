<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\HorarioController;

// Rutas públicas
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas por rol
Route::middleware(['auth:sanctum', 'role:administrador'])->group(function () {
    Route::apiResource('especialidades', EspecialidadController::class);
    Route::apiResource('medicos',        MedicoController::class);
    Route::apiResource('horarios',       HorarioController::class)->except(['update']);
    Route::post('/horarios/marcar-festivo', [HorarioController::class, 'marcarFestivo']);
});