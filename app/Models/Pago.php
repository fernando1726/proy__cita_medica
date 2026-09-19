<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'cita_id',
        'monto',
        'tipo',
        'estado',
        'referencia_transaccion',
        'pasarela',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public const TIPO_ADELANTO          = 'adelanto';
    public const TIPO_CONSULTA_COMPLETA = 'consulta_completa';

    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_APROBADO  = 'aprobado';
    public const ESTADO_RECHAZADO = 'rechazado';

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function estaAprobado(): bool
    {
        return $this->estado === self::ESTADO_APROBADO;
    }
}