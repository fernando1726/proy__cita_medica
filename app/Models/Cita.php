<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'horario_id',
        'fecha',
        'hora',
        'estado',
        'motivo_consulta',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora'  => 'datetime:H:i',
    ];

    public const ESTADO_PENDIENTE_PAGO = 'pendiente_pago';
    public const ESTADO_CONFIRMADA     = 'confirmada';
    public const ESTADO_REPROGRAMADA   = 'reprogramada';
    public const ESTADO_CANCELADA      = 'cancelada';
    public const ESTADO_ATENDIDA       = 'atendida';
    public const ESTADO_AUSENTE        = 'ausente';

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'cita_id');
    }

    public function receta()
    {
        return $this->hasOne(Receta::class, 'cita_id');
    }

    public function scopeDelDia($query, $fecha = null)
    {
        return $query->whereDate('fecha', $fecha ?? today());
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', self::ESTADO_CONFIRMADA);
    }
}