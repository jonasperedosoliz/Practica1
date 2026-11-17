@extends('layouts.app')

@section('title', 'Lista de categorías')
@section('header', 'Categorías')
@section('subheader', 'Administre el catálogo de categorías del sistema.')

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listacategorias.pdf') }}" target="_blank" rel="noopener" class="btn btn-report-pdf">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <span>PDF</span>
        </a>
        <a href="{{ route('listacategorias.excel') }}" class="btn btn-excel-report">
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span>Excel</span>
        </a>
        <a href="{{ route('listacategorias.create') }}" class="btn btn-cinematic">
            <i class="bi bi-plus-circle"></i>
            <span>Nueva categoría</span>
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show crud-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <section class="crud-panel">
        <div class="crud-panel-head">
            <div>
                <span class="crud-panel-label">Catálogo</span>
                <h2>Categorías registradas</h2>
                <p>Busque, revise el estado y gestione cada categoría desde una tabla clara y profesional.</p>
            </div>
            <div class="crud-meta-pills">
                <span class="crud-pill">{{ $categorias->perPage() }} por página</span>
                <span class="crud-pill">{{ $categorias->total() }} total</span>
                @if($busqueda !== '')
                    <span class="crud-pill is-filter">Filtro: {{ $busqueda }}</span>
                @endif
            </div>
        </div>

        <form action="{{ route('listacategorias.index') }}" method="GET" class="crud-search">
            <div class="crud-search-field">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    name="buscar"
                    placeholder="Buscar por nombre, descripción o estado"
                    value="{{ $busqueda }}"
                >
            </div>
            <button type="submit" class="btn btn-cinematic">
                <i class="bi bi-search"></i> Buscar
            </button>
            @if($busqueda !== '')
                <a href="{{ route('listacategorias.index') }}" class="btn btn-cinematic-soft">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0 crud-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $categoria)
                        <tr>
                            <td class="crud-index">{{ $categorias->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="crud-name">{{ $categoria->nombre }}</div>
                            </td>
                            <td>
                                <div class="crud-desc" title="{{ $categoria->descripcion }}">
                                    {{ $categoria->descripcion ?: 'Sin descripción' }}
                                </div>
                            </td>
                            <td>
                                @if($categoria->estado)
                                    <span class="status-pill is-active">Activo</span>
                                @else
                                    <span class="status-pill is-inactive">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="crud-actions">
                                    <a href="{{ route('listacategorias.edit', ['listacategoria' => $categoria->id]) }}" class="btn btn-action-edit">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('listacategorias.destroy', ['listacategoria' => $categoria->id]) }}" method="POST" class="m-0" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action-delete">
                                            <i class="bi bi-trash3"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="crud-empty">
                                    <span class="crud-empty-icon"><i class="bi bi-tags"></i></span>
                                    <strong>
                                        @if($busqueda !== '')
                                            No se encontraron categorías para "{{ $busqueda }}"
                                        @else
                                            No hay categorías registradas
                                        @endif
                                    </strong>
                                    <p>
                                        @if($busqueda !== '')
                                            Pruebe con otro término o limpie el filtro.
                                        @else
                                            Use "Nueva categoría" para comenzar el catálogo.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categorias->total() > 0)
            <div class="crud-footer">
                <div class="table-summary-text">
                    Mostrando {{ $categorias->firstItem() }}-{{ $categorias->lastItem() }} de {{ $categorias->total() }}
                </div>
                <div class="pagination-shell">
                    {{ $categorias->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </section>
@endsection
