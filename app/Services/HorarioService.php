<?php

namespace App\Services;

use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HorarioService
{
    public function crear(array $data): Horario
    {
        // Validar solapamiento del mismo médico en la misma fecha
        $solapa = Horario::where('medico_id', $data['medico_id'])
            ->whereDate('fecha', $data['fecha'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('hora_inicio', [$data['hora_inicio'], $data['hora_fin']])
                  ->orWhereBetween('hora_fin', [$data['hora_inicio'], $data['hora_fin']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('hora_inicio', '<=', $data['hora_inicio'])
                         ->where('hora_fin', '>=', $data['hora_fin']);
                  });
            })
            ->exists();

        if ($solapa) {
            throw new \DomainException('El horario se solapa con otro existente para el mismo médico.');
        }

        return Horario::create($data);
    }

    public function marcarFestivo(string $fecha): int
    {
        return Horario::whereDate('fecha', $fecha)
            ->update(['es_festivo' => true, 'ocupado' => true]);
    }
}