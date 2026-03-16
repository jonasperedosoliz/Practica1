<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('listacategorias', compact('categorias'));
    }

    public function create()
    {
        return view('createcategorias');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado'   => ['required', 'boolean'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 255 caracteres.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        Categoria::create($validated);
        return redirect()->route('listacategorias.index')->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Categoria $listacategoria)
    {
        return view('editcategorias', compact('listacategoria'));
    }

    public function update(Request $request, Categoria $listacategoria)
    {
        $validated = $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado'   => ['required', 'boolean'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 255 caracteres.',
            'estado.required' => 'Debe seleccionar un estado.',
        ]);

        $listacategoria->update($validated);
        return redirect()->route('listacategorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Categoria $listacategoria)
    {
        $listacategoria->delete();
        return redirect()->route('listacategorias.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
