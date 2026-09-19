<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Support\Facades\DB;

class AnaliticaController extends Controller
{
    public function demanda()
    {
        // Ranking de especialidades por cantidad de citas
        $ranking = Cita::query()
            ->join('medicos', 'citas.medico_id', '=', 'medicos.id')
            ->join('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
            ->select('especialidades.nombre as especialidad', DB::raw('COUNT(*) as total'))
            ->groupBy('especialidades.id', 'especialidades.nombre')
            ->orderByDesc('total')
            ->get();

        // Heatmap: citas por día de la semana
        $heatmap = Cita::query()
            ->select(
                DB::raw('DAYOFWEEK(fecha) as dia_semana'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get();

        return response()->json([
            'ranking_especialidades' => $ranking,
            'heatmap_dias'           => $heatmap,
        ]);
    }
}