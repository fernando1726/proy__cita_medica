<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $medicoId = $this->route('medico')->id;

        return [
            'nombres'            => 'sometimes|string|max:100',
            'apellidos'          => 'sometimes|string|max:100',
            'email'              => ['sometimes', 'email', Rule::unique('medicos', 'email')->ignore($medicoId)],
            'telefono'           => 'nullable|string|max:20',
            'numero_colegiatura' => ['sometimes', 'string', Rule::unique('medicos', 'numero_colegiatura')->ignore($medicoId)],
            'especialidad_id'    => 'sometimes|exists:especialidades,id',
            'tarifa_consulta'    => 'sometimes|numeric|min:0',
            'tarifa_adelanto'    => 'sometimes|numeric|min:0',
            'activo'             => 'sometimes|boolean',
        ];
    }
}