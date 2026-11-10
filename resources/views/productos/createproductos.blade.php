@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('header')
    Nuevo producto
@endsection

@section('subheader')
    Registre productos vinculados a categorías activas del sistema.
@endsection

@section('content')
    <p class="crud-page-sub">Complete los datos, seleccione la categoría y pulse Registrar para guardar el producto en la base de datos.</p>

    <div class="crud-card card">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errores de validación:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            @endif

            <form action="{{ route('listaproductos.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" min="0" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" name="precio" id="precio" value="{{ old('precio') }}" required>
                        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" min="0" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" name="stock" id="stock" value="{{ old('stock', 0) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    <select class="form-select {{ $errors->has('categoria_id') ? 'is-invalid' : '' }}" name="categoria_id" id="categoria_id" required>
                        <option value="">-- Seleccione una categoría --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen del producto</label>
                    <input type="file" class="form-control {{ $errors->has('imagen') ? 'is-invalid' : '' }}" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp">
                    @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Formatos permitidos: JPG, JPEG, PNG y WEBP. Tamaño máximo: 2 MB.</div>
                </div>
                <div class="product-image-panel product-image-panel-empty">
                    <div class="product-image-copy">
                        <strong>Vista previa disponible al guardar</strong>
                        <span>Cuando subas una imagen, el producto conservará su archivo dentro del almacenamiento público del proyecto.</span>
                    </div>
                </div>
                <div class="d-flex gap-2 pt-2">
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-register">Registrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
