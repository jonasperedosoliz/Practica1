<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use App\Models\Categoria;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim((string) $request->query('buscar', ''));

        $productos = Producto::with('categoria')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('descripcion', 'like', "%{$busqueda}%")
                        ->orWhereHas('categoria', function ($categoriaQuery) use ($busqueda) {
                            $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
                        });
                });
            })
            ->orderBy('id')
            ->paginate(7)
            ->withQueryString();

        return view('productos.index', compact('productos', 'busqueda'));
    }

    public function create()
    {
        // Solo categorias activas
        $categorias = Categoria::where('estado', '=', 1)->get();

        return view('productos.createproductos', compact('categorias'));
    }

    public function reportePdf()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('productos.reporte-pdf', [
            'productos' => $productos,
            'fechaGeneracion' => Carbon::now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('reporte-productos.pdf');
    }

    public function reporteExcel()
    {
        return Excel::download(
            ProductosExport::makeFromDatabase(),
            'reporte-productos.xlsx'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => ['required', 'string', 'max:100'],
            'descripcion'  => ['nullable', 'string'],
            'precio'       => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'imagen'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nombre.required'       => 'El nombre del producto es obligatorio.',
            'nombre.max'            => 'El nombre no puede superar 100 caracteres.',
            'precio.required'       => 'El precio es obligatorio.',
            'precio.numeric'        => 'El precio debe ser un numero valido.',
            'precio.min'            => 'El precio no puede ser negativo.',
            'stock.required'        => 'El stock es obligatorio.',
            'stock.integer'         => 'El stock debe ser un numero entero.',
            'stock.min'             => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'Debe seleccionar una categoria.',
            'categoria_id.exists'   => 'La categoria seleccionada no existe.',
            'imagen.image'          => 'El archivo debe ser una imagen valida.',
            'imagen.mimes'          => 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.',
            'imagen.max'            => 'La imagen no puede superar los 2 MB.',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $listaproducto)
    {
        $producto = $listaproducto;

        // Incluye categorias activas mas la categoria actual del producto aunque este inactiva.
        $categorias = Categoria::where('estado', '=', 1)
            ->orWhere('id', '=', $producto->categoria_id)
            ->get();

        return view('productos.editproductos', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $listaproducto)
    {
        $producto = $listaproducto;

        $validated = $request->validate([
            'nombre'       => ['required', 'string', 'max:100'],
            'descripcion'  => ['nullable', 'string'],
            'precio'       => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'imagen'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nombre.required'       => 'El nombre del producto es obligatorio.',
            'nombre.max'            => 'El nombre no puede superar 100 caracteres.',
            'precio.required'       => 'El precio es obligatorio.',
            'precio.numeric'        => 'El precio debe ser un numero valido.',
            'precio.min'            => 'El precio no puede ser negativo.',
            'stock.required'        => 'El stock es obligatorio.',
            'stock.integer'         => 'El stock debe ser un numero entero.',
            'stock.min'             => 'El stock no puede ser negativo.',
            'categoria_id.required' => 'Debe seleccionar una categoria.',
            'categoria_id.exists'   => 'La categoria seleccionada no existe.',
            'imagen.image'          => 'El archivo debe ser una imagen valida.',
            'imagen.mimes'          => 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.',
            'imagen.max'            => 'La imagen no puede superar los 2 MB.',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $listaproducto)
    {
        if ($listaproducto->imagen) {
            Storage::disk('public')->delete($listaproducto->imagen);
        }

        Producto::destroy($listaproducto->id);

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
