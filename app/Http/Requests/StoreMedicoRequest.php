<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombres'            => 'required|string|max:100',
            'apellidos'          => 'required|string|max:100',
            'email'              => 'required|email|unique:medicos,email',
            'telefono'           => 'nullable|string|max:20',
            'numero_colegiatura' => 'required|string|max:50|unique:medicos,numero_colegiatura',
            'especialidad_id'    => 'required|exists:especialidades,id',
            'tarifa_consulta'    => 'required|numeric|min:0',
            'tarifa_adelanto'    => 'required|numeric|min:0|lte:tarifa_consulta',
        ];
    }
}