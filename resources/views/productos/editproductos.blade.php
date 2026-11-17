@extends('layouts.app')

@section('title', 'Editar producto')
@section('header', 'Editar producto')
@section('subheader', 'Ajuste la información del producto sin perder su categoría.')

@section('header_actions')
    <a href="{{ route('listaproductos.index') }}" class="btn btn-cinematic-soft">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
@endsection

@section('content')
    <section class="crud-form-shell">
        <div class="crud-form-aside">
            <span class="dash-kicker"><i class="bi bi-pencil-square"></i> Edición</span>
            <h2>Actualice los datos del producto seleccionado.</h2>
            <p>Los cambios se reflejarán en el listado, reportes y la valuación del inventario.</p>
            <div class="crud-form-id">
                <span>Registro actual</span>
                <strong>#{{ $producto->id }}</strong>
            </div>
        </div>

        <div class="crud-form-card">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show crud-alert" role="alert">
                    <strong>Revise estos campos:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form action="{{ route('listaproductos.update', $producto->id) }}" method="post" enctype="multipart/form-data" class="crud-form">
                @csrf
                @method('PUT')

                <div class="form-heading-row">
                    <h3 class="form-heading-title mb-0">Detalles del producto</h3>
                    <span class="record-id-badge">ID: {{ $producto->id }}</span>
                </div>

                <div class="crud-field">
                    <label for="nombre">Nombre <span>*</span></label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field-grid">
                    <div class="crud-field">
                        <label for="precio">Precio (Bs.) <span>*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required>
                        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="crud-field">
                        <label for="stock">Stock <span>*</span></label>
                        <input type="number" min="0" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="crud-field">
                    <label for="categoria_id">Categoría <span>*</span></label>
                    <select class="form-select {{ $errors->has('categoria_id') ? 'is-invalid' : '' }}" name="categoria_id" id="categoria_id" required>
                        <option value="">-- Seleccione una categoría --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ (string) old('categoria_id', $producto->categoria_id) === (string) $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="imagen">Imagen del producto</label>
                    <input type="file" class="form-control {{ $errors->has('imagen') ? 'is-invalid' : '' }}" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp">
                    @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Si elige una nueva imagen, reemplazará la actual. Máximo 2 MB.</div>
                </div>

                @if($producto->imagen_url)
                    <div class="product-image-panel product-image-panel-compact">
                        <div class="product-image-thumb-wrap">
                            <img src="{{ $producto->imagen_url }}" alt="Imagen actual de {{ $producto->nombre }}" class="product-image-preview">
                        </div>
                        <div class="product-image-copy">
                            <strong>Imagen actual</strong>
                            <span>Puede mantenerla o reemplazarla con un nuevo archivo.</span>
                        </div>
                    </div>
                @else
                    <div class="product-image-panel product-image-panel-empty">
                        <div class="product-image-copy">
                            <strong>Sin imagen registrada</strong>
                            <span>Puede subir una imagen ahora para mejorar la identificación visual.</span>
                        </div>
                    </div>
                @endif

                <div class="crud-form-actions">
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-actualizar">
                        <i class="bi bi-check2-circle"></i> Actualizar producto
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
