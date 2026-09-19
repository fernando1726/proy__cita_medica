<?php 

public function agendar(User $paciente, array $data): Cita
{
    // Validación adicional en el servidor
    if (!$paciente->hasRole('paciente')) {
        throw new \Exception('Solo los pacientes pueden agendar citas.');
    }

    $horario = Horario::findOrFail($data['horario_id']);

    if ($horario->estaOcupado()) {
        throw new \Exception('El horario ya está ocupado.');
    }

    return DB::transaction(function () use ($paciente, $horario, $data) {
        $cita = Cita::create([
            'paciente_id' => $paciente->id,
            'medico_id'   => $horario->medico_id,
            'fecha'       => $horario->fecha,
            'hora'        => $horario->hora,
            'estado'      => 'pendiente_pago',
        ]);

        $horario->bloquear();

        return $cita;
    });
}