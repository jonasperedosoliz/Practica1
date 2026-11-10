@extends('layouts.app')

@section('title', 'Lista de categorias')

@section('header')
    Categorias
@endsection

@section('subheader')
    Administre el listado de categorias disponibles dentro del sistema.
@endsection

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listacategorias.pdf') }}" target="_blank" rel="noopener" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <span>Reporte PDF</span>
        </a>

        <a href="{{ route('listacategorias.excel') }}" class="btn btn-excel-report d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span>Reporte Excel</span>
        </a>

        <a href="{{ route('listacategorias.create') }}" class="btn btn-new"><i class="bi bi-plus-circle"></i> Nueva categoria</a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="crud-card card">
        <div class="card-body p-0">
            <div class="table-toolbar px-4 py-3 border-bottom">
                <div class="table-toolbar-content mx-auto text-center">
                    <div class="table-summary-title">Catalogo de categorias</div>

                    <form action="{{ route('listacategorias.index') }}" method="GET" class="product-search-form d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3">
                        <div class="input-group input-group-sm product-search-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                name="buscar"
                                class="form-control border-start-0"
                                placeholder="Buscar categoria, descripcion o estado"
                                value="{{ $busqueda }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary-theme d-inline-flex align-items-center gap-1">
                            <i class="bi bi-search"></i>
                            <span>Buscar</span>
                        </button>

                        @if($busqueda !== '')
                            <a href="{{ route('listacategorias.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                                <i class="bi bi-x-circle"></i>
                                <span>Limpiar</span>
                            </a>
                        @endif
                    </form>

                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                        <span class="badge text-bg-light table-summary-pill">7 por pagina</span>

                        @if($busqueda !== '')
                            <span class="badge text-bg-light table-summary-pill">Filtro: {{ $busqueda }}</span>
                        @endif

                        <span class="badge text-bg-light table-summary-pill">{{ $categorias->count() }} visibles</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($categorias as $categoria)
                        <tr>
                            <td>{{ $categorias->firstItem() + $loop->index }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td class="crud-td-desc" title="{{ $categoria->descripcion }}">{{ $categoria->descripcion ?? '-' }}</td>
                            <td>
                                @if($categoria->estado)
                                    <span class="badge rounded-pill text-bg-success">Activo</span>
                                @else
                                    <span class="badge rounded-pill text-bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="crud-td-actions">
                                <div class="crud-actions">
                                    <a href="{{ route('listacategorias.edit', ['listacategoria' => $categoria->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('listacategorias.destroy', ['listacategoria' => $categoria->id]) }}" method="POST" class="m-0" onsubmit="return confirm('Eliminar esta categoria?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                @if($busqueda !== '')
                                    No se encontraron categorias para "{{ $busqueda }}"
                                @else
                                    No hay categorias registradas. Use "Nueva categoria" para comenzar.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categorias->hasPages())
                <div class="table-footer d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 px-4 py-3 border-top">
                    <div class="table-summary-text mb-0">
                        Pagina {{ $categorias->currentPage() }} de {{ $categorias->lastPage() }}
                    </div>

                    <div class="pagination-shell">
                        {{ $categorias->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
