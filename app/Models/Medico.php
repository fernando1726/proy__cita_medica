<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'numero_colegiatura',
        'especialidad_id',
        'tarifa_consulta',
        'tarifa_adelanto',
        'activo',
    ];

    protected $casts = [
        'tarifa_consulta' => 'decimal:2',
        'tarifa_adelanto' => 'decimal:2',
        'activo'          => 'boolean',
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'medico_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'medico_id');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'medico_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}