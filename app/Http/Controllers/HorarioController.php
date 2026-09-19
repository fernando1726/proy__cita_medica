<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHorarioRequest;
use App\Models\Horario;
use App\Models\Medico;
use App\Services\HorarioService;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function __construct(private HorarioService $service) {}

    public function index(Request $request)
    {
        $data = $request->validate([
            'medico_id' => 'nullable|exists:medicos,id',
            'fecha'     => 'nullable|date',
        ]);

        $query = Horario::with('medico')
            ->when($data['medico_id'] ?? null, fn($q, $id) => $q->where('medico_id', $id))
            ->when($data['fecha'] ?? null, fn($q, $f) => $q->whereDate('fecha', $f))
            ->orderBy('fecha')
            ->orderBy('hora_inicio');

        return response()->json($query->get());
    }

    public function store(StoreHorarioRequest $request)
    {
        try {
            $horario = $this->service->crear($request->validated());
            return response()->json($horario->load('medico'), 201);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Horario $horario)
    {
        if ($horario->ocupado) {
            return response()->json(['message' => 'No se puede eliminar un horario ocupado.'], 409);
        }
        $horario->delete();
        return response()->json(['message' => 'Horario eliminado.']);
    }

    /**
     * Bloquear un día completo como festivo (RF-05).
     */
    public function marcarFestivo(Request $request)
    {
        $data = $request->validate([
            'fecha' => 'required|date',
        ]);

        $total = $this->service->marcarFestivo($data['fecha']);

        return response()->json([
            'message' => "Día {$data['fecha']} marcado como festivo. Horarios afectados: {$total}.",
        ]);
    }

    /**
     * Panel de agenda por médico (RF-06, reutilizado aquí para el admin).
     */
    public function agenda(Medico $medico)
    {
        return response()->json(
            $medico->load('especialidad')->horarios()->orderBy('fecha')->orderBy('hora_inicio')->get()
        );
    }
}