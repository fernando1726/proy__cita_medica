<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, Notifiable;     

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'fecha_nacimiento',
        'documento_identidad',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento'  => 'date',
        'password'          => 'hashed',
    ];

    // Relaciones
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'paciente_id');
    }

    // Helpers RBAC
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('nombre', $role)->exists();
    }

    public function assignRole(string $role): void
    {
        $roleModel = Role::where('nombre', $role)->firstOrFail();
        $this->roles()->syncWithoutDetaching([$roleModel->id]);
    }

    public function isAdministrador(): bool
    {
        return $this->hasRole('administrador');
    }

    public function isPaciente(): bool
    {
        return $this->hasRole('paciente');
    }
}
