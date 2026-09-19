<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'medico_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'ocupado',
        'es_festivo',
    ];

    protected $casts = [
        'fecha'      => 'date',
        'ocupado'    => 'boolean',
        'es_festivo' => 'boolean',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function cita()
    {
        return $this->hasOne(Cita::class, 'horario_id');
    }

    public function estaDisponible(): bool
    {
        return !$this->ocupado && !$this->es_festivo;
    }

    public function bloquear(): void
    {
        $this->update(['ocupado' => true]);
    }

    public function liberar(): void
    {
        $this->update(['ocupado' => false]);
    }

    public function scopeDisponibles($query)
    {
        return $query->where('ocupado', false)->where('es_festivo', false);
    }
}