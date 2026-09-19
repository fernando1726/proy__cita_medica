<?php


protected $fillable = [
    'paciente_id', 'medico_id', 'fecha', 'hora', 'estado',
];

// Nunca exponer el historial completo en respuestas públicas
public function toArray()
{
    return [
        'id'        => $this->id,
        'fecha'     => $this->fecha,
        'estado'    => $this->estado,
        // No incluir notas médicas ni diagnóstico en listados generales
    ];
}