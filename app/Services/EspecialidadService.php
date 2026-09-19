<?php

namespace App\Services;

use App\Models\Especialidad;

class EspecialidadService
{
    public function listar()
    {
        return Especialidad::orderBy('nombre')->get();
    }

    public function crear(array $data): Especialidad
    {
        return Especialidad::create($data);
    }

    public function actualizar(Especialidad $especialidad, array $data): Especialidad
    {
        $especialidad->update($data);
        return $especialidad->fresh();
    }

    public function desactivar(Especialidad $especialidad): void
    {
        $especialidad->update(['activa' => false]);
    }
}