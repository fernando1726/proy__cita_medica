<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $paciente = $request->user();
        if (!$paciente->isPaciente()) {
            abort(403);
        }

        $citas = Cita::with(['medico.especialidad', 'receta', 'pagos'])
            ->where('paciente_id', $paciente->id)
            ->orderByDesc('fecha')
            ->get();

        return response()->json(['data' => $citas]);
    }

    public function descargarPdf(Request $request, Cita $cita)
    {
        if ($request->user()->id !== $cita->paciente_id) {
            abort(403, 'Acceso no autorizado.');
        }

        // Aquí se generaría el PDF con la librería elegida (DomPDF, Snappy, etc.)
        return response()->json(['message' => 'PDF generado (placeholder).']);
    }
}