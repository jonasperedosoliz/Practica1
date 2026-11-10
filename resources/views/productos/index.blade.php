@extends('layouts.app')

@section('title', 'Lista de productos')

@section('header')
    Productos
@endsection

@section('subheader')
    Administre productos, precios, stock y categoria asociada.
@endsection

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listaproductos.pdf') }}" target="_blank" rel="noopener" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <span>Reporte PDF</span>
        </a>

        <a href="{{ route('listaproductos.excel') }}" class="btn btn-excel-report d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span>Reporte Excel</span>
        </a>

        <a href="{{ route('listaproductos.create') }}" class="btn btn-new"><i class="bi bi-plus-circle"></i> Nuevo producto</a>
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
                    <div class="table-summary-title">Catalogo de productos</div>

                    <form action="{{ route('listaproductos.index') }}" method="GET" class="product-search-form d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3">
                        <div class="input-group input-group-sm product-search-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                name="buscar"
                                class="form-control border-start-0"
                                placeholder="Buscar producto o categoria"
                                value="{{ $busqueda }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary-theme d-inline-flex align-items-center gap-1">
                            <i class="bi bi-search"></i>
                            <span>Buscar</span>
                        </button>

                        @if($busqueda !== '')
                            <a href="{{ route('listaproductos.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
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

                        <span class="badge text-bg-light table-summary-pill">{{ $productos->count() }} visibles</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                        <tr>
                            <td class="fw-semibold text-secondary">{{ $productos->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="product-listing-cell">
                                    <div class="product-listing-thumb {{ $producto->imagen_url ? '' : 'product-listing-thumb-empty' }}">
                                        @if($producto->imagen_url)
                                            <img src="{{ $producto->imagen_url }}" alt="Imagen de {{ $producto->nombre }}">
                                        @else
                                            <i class="bi bi-box-seam"></i>
                                        @endif
                                    </div>
                                    <div class="product-listing-copy">
                                        <div class="product-listing-name">{{ $producto->nombre }}</div>
                                        <div class="product-listing-meta">Codigo interno #{{ $producto->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="crud-td-desc" title="{{ $producto->descripcion }}">{{ $producto->descripcion ?? '-' }}</td>
                            <td><span class="price-text">{{ number_format($producto->precio, 2) }} Bs</span></td>
                            <td><span class="stock-badge">{{ $producto->stock }}</span></td>
                            <td><span class="table-category-pill">{{ $producto->categoria->nombre ?? '-' }}</span></td>
                            <td class="crud-td-actions">
                                <div class="crud-actions">
                                    <a href="{{ route('listaproductos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('listaproductos.destroy', $producto) }}" method="POST" class="m-0" onsubmit="return confirm('Eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                @if($busqueda !== '')
                                    No se encontraron productos para "{{ $busqueda }}"
                                @else
                                    No hay productos registrados
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productos->hasPages())
                <div class="table-footer d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 px-4 py-3 border-top">
                    <div class="table-summary-text mb-0">
                        Pagina {{ $productos->currentPage() }} de {{ $productos->lastPage() }}
                    </div>

                    <div class="pagination-shell">
                        {{ $productos->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
