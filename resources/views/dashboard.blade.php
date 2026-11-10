@extends('layouts.app')

@php
    $totalCategorias = \App\Models\Categoria::count();
    $categoriasActivas = \App\Models\Categoria::where('estado', 1)->count();
    $totalProductos = \App\Models\Producto::count();
    $productosStockBajo = \App\Models\Producto::where('stock', '<=', 5)->count();
    $productosRecientes = \App\Models\Producto::with('categoria')->latest('id')->take(5)->get();
    $valorInventario = \App\Models\Producto::selectRaw('COALESCE(SUM(precio * stock), 0) as total')->value('total');
@endphp

@section('title', 'Inicio del panel')
@section('header') Inicio @endsection
@section('subheader') Gestione la información principal del sistema desde un panel más claro, profesional y rápido. @endsection

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listacategorias.create') }}" class="btn btn-new"><i class="bi bi-tags me-2"></i> Nueva categoría</a>
        <a href="{{ route('listaproductos.create') }}" class="btn btn-warning"><i class="bi bi-box-seam me-2"></i> Nuevo producto</a>
    </div>
@endsection

@section('content')
    <section class="dashboard-hero mb-4">
        <div class="dashboard-hero-copy">
            <span class="dashboard-hero-kicker">Centro operativo</span>
            <h3>Todo tu inventario, categorías y reportes en un solo lugar.</h3>
            <p>Desde aquí puedes administrar los módulos principales, vigilar el estado general del sistema y entrar rápidamente a las áreas más importantes.</p>
            <div class="dashboard-hero-actions">
                <a href="{{ route('listaproductos.index') }}" class="btn btn-light rounded-pill px-4 fw-semibold">Ver productos</a>
                <a href="{{ route('listacategorias.index') }}" class="btn btn-outline-light rounded-pill px-4 fw-semibold">Ver categorías</a>
            </div>
        </div>
        <div class="dashboard-hero-visual">
            <div class="dashboard-hero-orb orb-1"></div>
            <div class="dashboard-hero-orb orb-2"></div>
            <div class="dashboard-hero-card">
                <span>Panel listo para operar</span>
                <strong>{{ $totalProductos }} productos</strong>
                <small>{{ $categoriasActivas }} categorías activas</small>
            </div>
        </div>
    </section>

    <div class="dashboard-stat-grid dashboard-stat-grid-premium">
        <article class="dashboard-stat-card stat-cyan">
            <div class="stat-icon"><i class="bi bi-tags"></i></div>
            <div class="stat-body">
                <span class="stat-label">Categorías</span>
                <div class="stat-value-row">
                    <strong>{{ $totalCategorias }}</strong>
                    <small>totales</small>
                </div>
            </div>
        </article>

        <article class="dashboard-stat-card stat-green">
            <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="stat-body">
                <span class="stat-label">Productos</span>
                <div class="stat-value-row">
                    <strong>{{ $totalProductos }}</strong>
                    <small>inventario</small>
                </div>
            </div>
        </article>

        <article class="dashboard-stat-card stat-blue stat-valuation-card">
            <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="stat-body">
                <span class="stat-label">Valuación</span>
                <div class="stat-value-row">
                    <strong>{{ number_format((float) $valorInventario, 2) }}</strong>
                    <small>Bs.</small>
                </div>
            </div>
        </article>

        <article class="dashboard-stat-card stat-orange">
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-body">
                <span class="stat-label">Stock crítico</span>
                <div class="stat-value-row">
                    <strong>{{ $productosStockBajo }}</strong>
                    <small>alerta</small>
                </div>
            </div>
        </article>
    </div>

    <div class="dashboard-board-grid">
        <section class="crud-card card">
            <div class="card-body p-0">
                <div class="dashboard-table-head">
                    <div>
                        <span class="section-label">Actividad reciente</span>
                        <h4>Últimos productos añadidos</h4>
                    </div>
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-light rounded-pill px-3 fw-semibold">Ver todos</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 dashboard-recent-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosRecientes as $producto)
                                <tr>
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
                                                <div class="product-listing-meta">Registro #{{ $producto->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="table-category-pill">{{ $producto->categoria->nombre ?? '-' }}</span></td>
                                    <td><span class="price-text">{{ number_format($producto->precio, 2) }} Bs.</span></td>
                                    <td><span class="stock-badge">{{ $producto->stock }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Aún no hay productos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <aside class="dashboard-side-stack">
            <section class="dashboard-welcome-card">
                <h4>¡Bienvenido de vuelta!</h4>
                <p>Todo tu inventario está protegido, centralizado y listo para seguir creciendo con una interfaz más ordenada.</p>
                <a href="{{ route('listaproductos.create') }}" class="btn btn-light rounded-pill px-4 fw-semibold">
                    <i class="bi bi-plus-circle me-2"></i>Añadir producto
                </a>
            </section>

            <section class="crud-card card">
                <div class="card-body">
                    <div class="dashboard-section-head">
                        <div>
                            <span class="section-label">Vista rápida</span>
                            <h4>Indicadores del sistema</h4>
                        </div>
                    </div>
                    <div class="progress-list">
                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-2"><strong>Categorías activas</strong><span>{{ $categoriasActivas }}/{{ max($totalCategorias, 1) }}</span></div>
                            <div class="progress dashboard-progress"><div class="progress-bar bg-success" style="width: {{ $totalCategorias > 0 ? ($categoriasActivas * 100 / $totalCategorias) : 0 }}%"></div></div>
                        </div>
                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-2"><strong>Productos con stock bajo</strong><span>{{ $productosStockBajo }}</span></div>
                            <div class="progress dashboard-progress"><div class="progress-bar bg-warning" style="width: {{ $totalProductos > 0 ? min(($productosStockBajo * 100 / $totalProductos), 100) : 0 }}%"></div></div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@endsection
