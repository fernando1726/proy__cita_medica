<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function ingresos(Request $request)
    {
        $data = $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $ingresos = Pago::query()
            ->join('citas', 'pagos.cita_id', '=', 'citas.id')
            ->join('medicos', 'citas.medico_id', '=', 'medicos.id')
            ->join('especialidades', 'medicos.especialidad_id', '=', 'especialidades.id')
            ->where('pagos.estado', Pago::ESTADO_APROBADO)
            ->whereBetween('pagos.created_at', [$data['desde'], $data['hasta']])
            ->groupBy('especialidades.id', 'especialidades.nombre', 'medicos.id', 'medicos.nombres', 'medicos.apellidos')
            ->select(
                'especialidades.nombre as especialidad',
                DB::raw("CONCAT(medicos.nombres, ' ', medicos.apellidos) as medico"),
                DB::raw('SUM(pagos.monto) as total')
            )
            ->get();

        return response()->json(['data' => $ingresos]);
    }
}