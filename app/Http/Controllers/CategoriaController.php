<?php

namespace App\Http\Controllers;

use App\Exports\CategoriasExport;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->query('buscar', ''));

        $categorias = Categoria::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('descripcion', 'like', "%{$busqueda}%");

                    if (str_contains('activo', strtolower($busqueda))) {
                        $subquery->orWhere('estado', true);
                    }

                    if (str_contains('inactivo', strtolower($busqueda))) {
                        $subquery->orWhere('estado', false);
                    }
                });
            })
            ->orderBy('id')
            ->paginate(7)
            ->withQueryString();

        return view('categorias.index', compact('categorias', 'busqueda'));
    }

    public function create()
    {
        return view('categorias.createcategorias');
    }

    public function reportePdf()
    {
        $categorias = Categoria::query()
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('categorias.reporte-pdf', [
            'categorias' => $categorias,
            'fechaGeneracion' => Carbon::now(),
        ])->setPaper('a4');

        return $pdf->stream('reporte-categorias.pdf');
    }

    public function reporteExcel()
    {
        return Excel::download(
            CategoriasExport::makeFromDatabase(),
            'reporte-categorias.xlsx'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado'      => ['required', 'boolean'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 255 caracteres.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        Categoria::create($validated);

        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Categoria $listacategoria)
    {
        $categoria = $listacategoria;

        return view('categorias.editcategorias', compact('categoria'));
    }

    public function update(Request $request, Categoria $listacategoria)
    {
        $categoria = $listacategoria;

        $validated = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado'      => ['required', 'boolean'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 255 caracteres.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        $categoria->update($validated);

        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $listacategoria)
    {
        // Usamos destroy() para evitar el falso positivo de Intelephense con delete()
        Categoria::destroy($listacategoria->id);

        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
