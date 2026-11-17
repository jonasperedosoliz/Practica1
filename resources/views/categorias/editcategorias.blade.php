@extends('layouts.app')

@section('title', 'Editar categoría')
@section('header', 'Editar categoría')
@section('subheader', 'Actualice la información y conserve el control del catálogo.')

@section('header_actions')
    <a href="{{ route('listacategorias.index') }}" class="btn btn-cinematic-soft">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
@endsection

@section('content')
    <section class="crud-form-shell">
        <div class="crud-form-aside">
            <span class="dash-kicker"><i class="bi bi-pencil-square"></i> Edición</span>
            <h2>Ajuste los datos de la categoría seleccionada.</h2>
            <p>Los cambios se reflejarán en el listado, los reportes y la asignación de productos.</p>
            <div class="crud-form-id">
                <span>Registro actual</span>
                <strong>#{{ $categoria->id }}</strong>
            </div>
        </div>

        <div class="crud-form-card">
            @if ($errors->any())
                <div id="alert-validacion" class="alert alert-danger alert-dismissible fade show crud-alert" role="alert">
                    <strong>Revise estos campos:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form action="{{ route('listacategorias.update', ['listacategoria' => $categoria->id]) }}" method="post" class="crud-form">
                @csrf
                @method('PUT')

                <div class="form-heading-row">
                    <h3 class="form-heading-title mb-0">Detalles de la categoría</h3>
                    <span class="record-id-badge">ID: {{ $categoria->id }}</span>
                </div>

                <div class="crud-field">
                    <label for="nombre">Nombre <span>*</span></label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="estado">Estado <span>*</span></label>
                    <select class="form-select {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado" required>
                        <option value="">-- Seleccione --</option>
                        <option value="1" {{ (int) old('estado', $categoria->estado ? 1 : 0) === 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ (int) old('estado', $categoria->estado ? 1 : 0) === 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-form-actions">
                    <a href="{{ route('listacategorias.index') }}" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-actualizar">
                        <i class="bi bi-check2-circle"></i> Actualizar categoría
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
@if ($errors->any())
<script>
    (function () {
        var alertEl = document.getElementById('alert-validacion');
        if (alertEl) setTimeout(function () { alertEl.style.display = 'none'; }, 5000);
    })();
</script>
@endif
@endpush
