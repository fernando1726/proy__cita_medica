<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'medico_id'       => 'nullable|exists:medicos,id',
            'fecha'           => 'required|date|after_or_equal:today',
        ]);

        $query = Horario::with(['medico.especialidad'])
            ->disponibles()
            ->whereDate('fecha', $data['fecha'])
            ->whereHas('medico', function ($q) use ($data) {
                $q->where('activo', true)
                  ->where('especialidad_id', $data['especialidad_id']);

                if (!empty($data['medico_id'])) {
                    $q->where('id', $data['medico_id']);
                }
            })
            ->orderBy('hora_inicio');

        $horarios = $query->get()->map(function ($h) {
            return [
                'horario_id'   => $h->id,
                'hora_inicio'  => $h->hora_inicio,
                'hora_fin'     => $h->hora_fin,
                'medico'       => $h->medico->nombre_completo,
                'especialidad' => $h->medico->especialidad->nombre,
            ];
        });

        if ($horarios->isEmpty()) {
            return response()->json([
                'message'  => 'No hay disponibilidad para los filtros seleccionados. Intente con otra fecha o especialidad.',
                'sugerencia' => 'Pruebe con fechas cercanas o revise otras especialidades.',
                'data'     => [],
            ], 200);
        }

        return response()->json(['data' => $horarios]);
    }
}