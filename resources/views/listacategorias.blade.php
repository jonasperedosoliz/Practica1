<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
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
                    <h1 class="crud-page-title">Categorías</h1>
                    <p class="crud-page-sub mb-0">Gestión de categorías en la base de datos.</p>
                </div>
                <a href="{{ route('listacategorias.create') }}" class="btn btn-new">+ Nueva Categoría</a>
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
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td class="crud-td-desc" title="{{ $categoria->descripcion }}">{{ $categoria->descripcion ?? '-' }}</td>
                                    <td>{{ $categoria->estado ? 'Activo' : 'Inactivo' }}</td>
                                    <td class="crud-td-actions">
                                        <div class="crud-actions">
                                            <a href="{{ route('listacategorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>
                                            <form action="{{ route('listacategorias.destroy', $categoria) }}" method="POST" class="m-0" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @if($categorias->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No hay categorías registradas. Use «Nueva Categoría» para registrar.</td>
                                </tr>
                                @endif
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
