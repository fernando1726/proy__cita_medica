<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'horario_id'         => 'required|exists:horarios,id',
            'motivo_consulta'    => 'nullable|string|max:500',
            'tipo_pago'          => 'required|in:adelanto,consulta_completa',
            'referencia_pago'    => 'required|string',
            'pago_aprobado'      => 'required|boolean',
        ]);

        $paciente = $request->user();

        if (!$paciente->isPaciente()) {
            abort(403, 'Solo los pacientes pueden agendar citas.');
        }

        return DB::transaction(function () use ($data, $paciente) {
            $horario = Horario::lockForUpdate()->findOrFail($data['horario_id']);

            if (!$horario->estaDisponible()) {
                return response()->json(['message' => 'El horario ya no está disponible.'], 409);
            }

            $cita = Cita::create([
                'paciente_id'     => $paciente->id,
                'medico_id'       => $horario->medico_id,
                'horario_id'      => $horario->id,
                'fecha'           => $horario->fecha,
                'hora'            => $horario->hora_inicio,
                'estado'          => $data['pago_aprobado']
                                        ? Cita::ESTADO_CONFIRMADA
                                        : Cita::ESTADO_PENDIENTE_PAGO,
                'motivo_consulta' => $data['motivo_consulta'] ?? null,
            ]);

            $monto = $data['tipo_pago'] === Pago::TIPO_ADELANTO
                ? $horario->medico->tarifa_adelanto
                : $horario->medico->tarifa_consulta;

            $pago = Pago::create([
                'cita_id'                => $cita->id,
                'monto'                  => $monto,
                'tipo'                   => $data['tipo_pago'],
                'estado'                 => $data['pago_aprobado'] ? Pago::ESTADO_APROBADO : Pago::ESTADO_RECHAZADO,
                'referencia_transaccion' => $data['referencia_pago'],
                'pasarela'               => 'demo',
            ]);

            // M-01: solo bloquear si el pago fue aprobado
            if ($pago->estaAprobado()) {
                $horario->bloquear();
            } else {
                $cita->update(['estado' => Cita::ESTADO_CANCELADA]);
                return response()->json(['message' => 'Pago rechazado. La cita no fue confirmada.'], 402);
            }

            return response()->json([
                'message' => 'Cita agendada correctamente.',
                'cita'    => $cita->load('medico.especialidad', 'pagos'),
            ], 201);
        });
    }

    public function reprogramar(Request $request, Cita $cita)
    {
        if ($request->user()->id !== $cita->paciente_id && !$request->user()->isAdministrador()) {
            abort(403);
        }

        $data = $request->validate([
            'nuevo_horario_id' => 'required|exists:horarios,id',
        ]);

        return DB::transaction(function () use ($cita, $data) {
            $nuevo = Horario::lockForUpdate()->findOrFail($data['nuevo_horario_id']);
            if (!$nuevo->estaDisponible()) {
                return response()->json(['message' => 'El nuevo horario no está disponible.'], 409);
            }

            $cita->horario->liberar();

            $cita->update([
                'horario_id' => $nuevo->id,
                'medico_id'  => $nuevo->medico_id,
                'fecha'      => $nuevo->fecha,
                'hora'       => $nuevo->hora_inicio,
                'estado'     => Cita::ESTADO_REPROGRAMADA,
            ]);

            $nuevo->bloquear();

            return response()->json(['message' => 'Cita reprogramada.', 'cita' => $cita->fresh()]);
        });
    }

    public function cancelar(Request $request, Cita $cita)
    {
        if ($request->user()->id !== $cita->paciente_id && !$request->user()->isAdministrador()) {
            abort(403);
        }

        return DB::transaction(function () use ($cita) {
            $cita->horario->liberar();
            $cita->update(['estado' => Cita::ESTADO_CANCELADA]);

            return response()->json(['message' => 'Cita cancelada y horario liberado.']);
        });
    }
}