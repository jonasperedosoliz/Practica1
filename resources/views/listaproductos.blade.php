<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app-crud.css') }}" rel="stylesheet">
</head>
<body class="bg-light crud-app">
    <div class="d-flex">
        <aside class="crud-sidebar text-white">
            <h5>CRUD Productos</h5>
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <a href="{{ route('listacategorias.index') }}" class="{{ request()->routeIs('listacategorias.*') ? 'active' : '' }}">Categorías</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('listaproductos.index') }}" class="{{ request()->routeIs('listaproductos.*') ? 'active' : '' }}">Productos</a>
                </li>
            </ul>
        </aside>
        <main class="crud-main">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="crud-page-title">Productos</h1>
                    <p class="crud-page-sub mb-0">Gestión de productos en la base de datos.</p>
                </div>
                <a href="{{ route('listaproductos.create') }}" class="btn btn-new">+ Nuevo Producto</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <div class="crud-card card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td class="crud-td-desc" title="{{ $producto->descripcion }}">{{ $producto->descripcion ?? '-' }}</td>
                                    <td>{{ number_format($producto->precio, 2) }} Bs</td>
                                    <td>{{ $producto->stock }}</td>
                                    <td>{{ $producto->categoria->nombre ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('listaproductos.edit', $producto) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                                        <form action="{{ route('listaproductos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No hay productos registrados. Use «Nuevo Producto» y seleccione una categoría para registrar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
