<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = today();

        $citasHoy = Cita::delDia($hoy)->count();
        $confirmadasHoy = Cita::delDia($hoy)->confirmadas()->count();
        $ausentesHoy = Cita::delDia($hoy)->where('estado', Cita::ESTADO_AUSENTE)->count();

        $tasaAusentismo = $citasHoy > 0
            ? round(($ausentesHoy / $citasHoy) * 100, 2)
            : 0;

        return response()->json([
            'citas_hoy'        => $citasHoy,
            'confirmadas_hoy'  => $confirmadasHoy,
            'ausentes_hoy'     => $ausentesHoy,
            'tasa_ausentismo'  => $tasaAusentismo,
        ]);
    }
}