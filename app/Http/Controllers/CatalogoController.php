<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request): View
    {
        $busqueda = trim((string) $request->query('buscar', ''));
        $categoriaId = $request->query('categoria');

        $productos = Producto::query()
            ->with('categoria')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('descripcion', 'like', "%{$busqueda}%")
                        ->orWhereHas('categoria', function ($categoriaQuery) use ($busqueda) {
                            $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
                        });
                });
            })
            ->when(filled($categoriaId), function ($query) use ($categoriaId) {
                $query->where('categoria_id', $categoriaId);
            })
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $categorias = Categoria::query()
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('catalogo.index', compact('productos', 'categorias', 'busqueda', 'categoriaId'));
    }
}
