<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'recetas';

    protected $fillable = [
        'cita_id',
        'medico_id',
        'paciente_id',
        'indicaciones',
        'medicamentos',
    ];

    protected $casts = [
        'medicamentos' => 'array',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}