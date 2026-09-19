<?php

namespace App\Services;

use App\Models\Medico;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MedicoService
{
    public function listar(array $filtros = []): LengthAwarePaginator
    {
        return Medico::with('especialidad')
            ->when($filtros['especialidad_id'] ?? null, fn($q, $id) => $q->where('especialidad_id', $id))
            ->when(isset($filtros['activo']), fn($q) => $q->where('activo', $filtros['activo']))
            ->orderBy('apellidos')
            ->paginate(15);
    }

    public function crear(array $data): Medico
    {
        return Medico::create($data);
    }

    public function actualizar(Medico $medico, array $data): Medico
    {
        $medico->update($data);
        return $medico->fresh();
    }

    public function desactivar(Medico $medico): void
    {
        $medico->update(['activo' => false]);
    }
}