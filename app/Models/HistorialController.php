<?php

public function show(Request $request, Cita $cita)
{
    // Solo el paciente dueño o un admin autorizado puede ver el historial
    if ($request->user()->id !== $cita->paciente_id && !$request->user()->hasRole('administrador')) {
        abort(403, 'Acceso no autorizado.');
    }
    // ...
}