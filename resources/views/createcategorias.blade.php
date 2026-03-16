<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Categoría</title>
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
            <h1 class="crud-page-title">Nueva Categoría</h1>
            <p class="crud-page-sub">Complete los datos y pulse Registrar para guardar en la base de datos.</p>
            <div class="crud-card card">
                <div class="card-body">
                    @if ($errors->any())
                    <div id="alert-validacion" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Errores de validación:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                    @endif
                    <form action="{{ route('listacategorias.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado" required>
                                <option value="">-- Seleccione --</option>
                                <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2 pt-2">
                            <a href="{{ route('listacategorias.index') }}" class="btn btn-cancel">Cancelar</a>
                            <button type="submit" class="btn btn-register">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any())
    <script>
        (function () {
            var alertEl = document.getElementById('alert-validacion');
            if (alertEl) setTimeout(function () { alertEl.style.display = 'none'; }, 5000);
        })();
    </script>
    @endif
</body>
</html>
