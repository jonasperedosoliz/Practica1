<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
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
            <h1 class="crud-page-title">Editar Producto</h1>
            <p class="crud-page-sub">Modifique los datos y pulse Actualizar para guardar en la base de datos.</p>
            <div class="crud-card card">
                <div class="card-body">
                    <form action="{{ route('listaproductos.update', $listaproducto) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $listaproducto->nombre) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{ old('descripcion', $listaproducto->descripcion) }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" min="0" class="form-control" name="precio" id="precio" value="{{ old('precio', $listaproducto->precio) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" min="0" class="form-control" name="stock" id="stock" value="{{ old('stock', $listaproducto->stock) }}" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" name="categoria_id" id="categoria_id" required>
                                <option value="">-- Seleccione una categoría --</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_id', $listaproducto->categoria_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2 pt-2">
                            <a href="{{ route('listaproductos.index') }}" class="btn btn-cancel">Cancelar</a>
                            <button type="submit" class="btn btn-actualizar">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
