<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;


class CalificacionesController extends Controller
{
    public function index(): View
    {
        return view('calificaciones.index');
    }

    public function create(): View
    {
        return view('calificaciones.crear');
    }

    public function edit(int $id): View
    {
        return view('calificaciones.editar', ['id' => $id]);
    }

    public function saludo(Request $request, string $nombre='Invitado'): string{

    $ip=$request->ip();
    return "Hola mundo, soy: $nombre, tu dirección IP es $ip";
    }
}
