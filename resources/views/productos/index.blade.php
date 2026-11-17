@extends('layouts.app')

@section('title', 'Lista de productos')
@section('header', 'Productos')
@section('subheader', 'Administre productos, precios, stock e imagen asociada.')

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listaproductos.pdf') }}" target="_blank" rel="noopener" class="btn btn-report-pdf">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <span>PDF</span>
        </a>
        <a href="{{ route('listaproductos.excel') }}" class="btn btn-excel-report">
            <i class="bi bi-file-earmark-excel-fill"></i>
            <span>Excel</span>
        </a>
        <a href="{{ route('listaproductos.create') }}" class="btn btn-cinematic">
            <i class="bi bi-plus-circle"></i>
            <span>Nuevo producto</span>
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
                <span class="crud-panel-label">Inventario</span>
                <h2>Productos registrados</h2>
                <p>Busque por nombre, descripción o categoría y gestione el inventario desde una tabla clara.</p>
            </div>
            <div class="crud-meta-pills">
                <span class="crud-pill">{{ $productos->perPage() }} por página</span>
                <span class="crud-pill">{{ $productos->total() }} total</span>
                @if($busqueda !== '')
                    <span class="crud-pill is-filter">Filtro: {{ $busqueda }}</span>
                @endif
            </div>
        </div>

        <form action="{{ route('listaproductos.index') }}" method="GET" class="crud-search">
            <div class="crud-search-field">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    name="buscar"
                    placeholder="Buscar producto, descripción o categoría"
                    value="{{ $busqueda }}"
                >
            </div>
            <button type="submit" class="btn btn-cinematic">
                <i class="bi bi-search"></i> Buscar
            </button>
            @if($busqueda !== '')
                <a href="{{ route('listaproductos.index') }}" class="btn btn-cinematic-soft">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0 crud-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td class="crud-index">{{ $productos->firstItem() + $loop->index }}</td>
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
                                        <div class="product-listing-meta">Código #{{ $producto->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="crud-desc" title="{{ $producto->descripcion }}">
                                    {{ $producto->descripcion ?: 'Sin descripción' }}
                                </div>
                            </td>
                            <td><span class="price-text">{{ number_format($producto->precio, 2) }} Bs.</span></td>
                            <td>
                                <span class="stock-badge {{ $producto->stock <= 5 ? 'is-low' : '' }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td><span class="table-category-pill">{{ $producto->categoria->nombre ?? '-' }}</span></td>
                            <td>
                                <div class="crud-actions">
                                    <a href="{{ route('listaproductos.edit', $producto) }}" class="btn btn-action-edit">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <form action="{{ route('listaproductos.destroy', $producto) }}" method="POST" class="m-0" onsubmit="return confirm('¿Eliminar este producto?');">
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
                            <td colspan="7">
                                <div class="crud-empty">
                                    <span class="crud-empty-icon"><i class="bi bi-box-seam"></i></span>
                                    <strong>
                                        @if($busqueda !== '')
                                            No se encontraron productos para "{{ $busqueda }}"
                                        @else
                                            No hay productos registrados
                                        @endif
                                    </strong>
                                    <p>
                                        @if($busqueda !== '')
                                            Pruebe con otro término o limpie el filtro.
                                        @else
                                            Use "Nuevo producto" para comenzar el inventario.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($productos->total() > 0)
            <div class="crud-footer">
                <div class="table-summary-text">
                    Mostrando {{ $productos->firstItem() }}-{{ $productos->lastItem() }} de {{ $productos->total() }}
                </div>
                <div class="pagination-shell">
                    {{ $productos->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </section>
@endsection
