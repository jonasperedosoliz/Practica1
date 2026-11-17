@extends('layouts.app')

@section('title', 'Nuevo producto')
@section('header', 'Nuevo producto')
@section('subheader', 'Registre productos vinculados a categorías activas del sistema.')

@section('header_actions')
    <a href="{{ route('listaproductos.index') }}" class="btn btn-cinematic-soft">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
@endsection

@section('content')
    <section class="crud-form-shell">
        <div class="crud-form-aside">
            <span class="dash-kicker"><i class="bi bi-box-seam"></i> Inventario</span>
            <h2>Registre un producto listo para operar.</h2>
            <p>Complete los datos clave, asocie una categoría activa y, si desea, agregue una imagen para identificarlo más rápido.</p>
            <ul class="crud-form-tips">
                <li>El precio se expresa en Bs.</li>
                <li>El stock bajo (≤ 5) se marcará en el listado.</li>
                <li>Imagen opcional: JPG, PNG o WEBP hasta 2 MB.</li>
            </ul>
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

            <form action="{{ route('listaproductos.store') }}" method="post" enctype="multipart/form-data" class="crud-form">
                @csrf

                <div class="crud-field">
                    <label for="nombre">Nombre <span>*</span></label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej. Laptop Pro 14" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="4" placeholder="Detalle breve del producto">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field-grid">
                    <div class="crud-field">
                        <label for="precio">Precio (Bs.) <span>*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" name="precio" id="precio" value="{{ old('precio') }}" required>
                        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="crud-field">
                        <label for="stock">Stock <span>*</span></label>
                        <input type="number" min="0" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" name="stock" id="stock" value="{{ old('stock', 0) }}" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="crud-field">
                    <label for="categoria_id">Categoría <span>*</span></label>
                    <select class="form-select {{ $errors->has('categoria_id') ? 'is-invalid' : '' }}" name="categoria_id" id="categoria_id" required>
                        <option value="">-- Seleccione una categoría --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ (string) old('categoria_id') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="imagen">Imagen del producto</label>
                    <input type="file" class="form-control {{ $errors->has('imagen') ? 'is-invalid' : '' }}" name="imagen" id="imagen" accept=".jpg,.jpeg,.png,.webp">
                    @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Formatos: JPG, JPEG, PNG y WEBP. Máximo 2 MB.</div>
                </div>

                <div class="product-image-panel product-image-panel-empty">
                    <div class="product-image-copy">
                        <strong>Vista previa al guardar</strong>
                        <span>La imagen se almacenará en el disco público del proyecto para mostrarla en el inventario.</span>
                    </div>
                </div>

                <div class="crud-form-actions">
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-register">
                        <i class="bi bi-check2-circle"></i> Registrar producto
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
