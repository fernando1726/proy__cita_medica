<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEspecialidadRequest;
use App\Models\Especialidad;
use App\Services\EspecialidadService;

class EspecialidadController extends Controller
{
    public function __construct(private EspecialidadService $service) {}

    public function index()
    {
        return response()->json($this->service->listar());
    }

    public function store(StoreEspecialidadRequest $request)
    {
        $especialidad = $this->service->crear($request->validated());
        return response()->json($especialidad, 201);
    }

    public function show(Especialidad $especialidad)
    {
        return response()->json($especialidad->load('medicos'));
    }

    public function update(StoreEspecialidadRequest $request, Especialidad $especialidad)
    {
        return response()->json($this->service->actualizar($especialidad, $request->validated()));
    }

    public function destroy(Especialidad $especialidad)
    {
        $this->service->desactivar($especialidad);
        return response()->json(['message' => 'Especialidad desactivada.']);
    }
}