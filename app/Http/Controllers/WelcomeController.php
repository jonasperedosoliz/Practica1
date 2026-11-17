<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $productos = Producto::query()
            ->with('categoria')
            ->orderBy('nombre')
            ->take(auth()->check() ? 12 : 8)
            ->get();

        $totalProductos = Producto::query()->count();

        return view('welcome', compact('productos', 'totalProductos'));
    }
}
