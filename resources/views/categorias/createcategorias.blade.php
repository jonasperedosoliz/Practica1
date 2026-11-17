@extends('layouts.app')

@section('title', 'Nueva categoría')
@section('header', 'Nueva categoría')
@section('subheader', 'Complete el formulario para registrar una categoría.')

@section('header_actions')
    <a href="{{ route('listacategorias.index') }}" class="btn btn-cinematic-soft">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
@endsection

@section('content')
    <section class="crud-form-shell">
        <div class="crud-form-aside">
            <span class="dash-kicker"><i class="bi bi-tags"></i> Registro</span>
            <h2>Cree una categoría clara y operativa.</h2>
            <p>Defina el nombre, una descripción útil y el estado para mantener el catálogo ordenado.</p>
            <ul class="crud-form-tips">
                <li>Use nombres cortos y reconocibles.</li>
                <li>La descripción ayuda en búsquedas y reportes.</li>
                <li>Solo categorías activas se ofrecen al crear productos.</li>
            </ul>
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

            <form action="{{ route('listacategorias.store') }}" method="post" class="crud-form">
                @csrf

                <div class="crud-field">
                    <label for="nombre">Nombre <span>*</span></label>
                    <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej. Electrónica" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="4" placeholder="Detalle breve de la categoría">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-field">
                    <label for="estado">Estado <span>*</span></label>
                    <select class="form-select {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado" required>
                        <option value="">-- Seleccione --</option>
                        <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="crud-form-actions">
                    <a href="{{ route('listacategorias.index') }}" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-register">
                        <i class="bi bi-check2-circle"></i> Registrar categoría
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
