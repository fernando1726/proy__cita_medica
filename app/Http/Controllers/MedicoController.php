<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicoRequest;
use App\Http\Requests\UpdateMedicoRequest;
use App\Models\Medico;
use App\Services\MedicoService;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function __construct(private MedicoService $service) {}

    public function index(Request $request)
    {
        return response()->json(
            $this->service->listar($request->only('especialidad_id', 'activo'))
        );
    }

    public function store(StoreMedicoRequest $request)
    {
        $medico = $this->service->crear($request->validated());
        return response()->json($medico->load('especialidad'), 201);
    }

    public function show(Medico $medico)
    {
        return response()->json($medico->load('especialidad', 'horarios'));
    }

    public function update(UpdateMedicoRequest $request, Medico $medico)
    {
        return response()->json(
            $this->service->actualizar($medico, $request->validated())->load('especialidad')
        );
    }

    public function destroy(Medico $medico)
    {
        $this->service->desactivar($medico);
        return response()->json(['message' => 'Médico desactivado.']);
    }
}