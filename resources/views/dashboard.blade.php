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
@section('header', 'Inicio')
@section('subheader', 'Centro operativo del inventario, categorías y reportes.')

@section('header_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('listacategorias.create') }}" class="btn btn-cinematic">
            <i class="bi bi-tags"></i> Nueva categoría
        </a>
        <a href="{{ route('listaproductos.create') }}" class="btn btn-cinematic-accent">
            <i class="bi bi-box-seam"></i> Nuevo producto
        </a>
    </div>
@endsection

@section('content')
    <section class="dash-hero">
        <div class="dash-hero-copy">
            <span class="dash-kicker"><i class="bi bi-broadcast"></i> Centro operativo</span>
            <h2>Todo tu inventario, categorías y reportes en un solo lugar.</h2>
            <p>Supervisa el estado general del sistema y entra rápido a los módulos principales con una interfaz alineada al panel cinematic.</p>
            <div class="dash-hero-actions">
                <a href="{{ route('listaproductos.index') }}" class="btn btn-cinematic">Ver productos</a>
                <a href="{{ route('listacategorias.index') }}" class="btn btn-cinematic-ghost">Ver categorías</a>
            </div>
        </div>
        <div class="dash-hero-panel">
            <span>Panel listo para operar</span>
            <strong>{{ $totalProductos }}</strong>
            <small>productos · {{ $categoriasActivas }} categorías activas</small>
        </div>
    </section>

    <div class="dash-stat-grid">
        <article class="dash-stat">
            <span class="dash-stat-icon cyan"><i class="bi bi-tags"></i></span>
            <div>
                <span class="dash-stat-label">Categorías</span>
                <strong>{{ $totalCategorias }}</strong>
                <small>totales</small>
            </div>
        </article>
        <article class="dash-stat">
            <span class="dash-stat-icon teal"><i class="bi bi-box-seam"></i></span>
            <div>
                <span class="dash-stat-label">Productos</span>
                <strong>{{ $totalProductos }}</strong>
                <small>inventario</small>
            </div>
        </article>
        <article class="dash-stat">
            <span class="dash-stat-icon blue"><i class="bi bi-cash-coin"></i></span>
            <div>
                <span class="dash-stat-label">Valuación</span>
                <strong>{{ number_format((float) $valorInventario, 2) }}</strong>
                <small>Bs.</small>
            </div>
        </article>
        <article class="dash-stat">
            <span class="dash-stat-icon warn"><i class="bi bi-exclamation-triangle"></i></span>
            <div>
                <span class="dash-stat-label">Stock crítico</span>
                <strong>{{ $productosStockBajo }}</strong>
                <small>alerta</small>
            </div>
        </article>
    </div>

    <div class="dash-board-grid">
        <section class="dash-card">
            <div class="dash-card-head">
                <div>
                    <span class="dash-card-label">Actividad reciente</span>
                    <h3>Últimos productos añadidos</h3>
                </div>
                <a href="{{ route('listaproductos.index') }}" class="btn btn-cinematic-soft">Ver todos</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0 dash-table">
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
        </section>

        <aside class="dash-side">
            <section class="dash-welcome">
                <h3>¡Bienvenido de vuelta!</h3>
                <p>Tu panel ya comparte la misma línea visual del acceso cinematic: claro, profesional y listo para operar.</p>
                <a href="{{ route('listaproductos.create') }}" class="btn btn-cinematic">
                    <i class="bi bi-plus-circle"></i> Añadir producto
                </a>
            </section>

            <section class="dash-card">
                <div class="dash-card-head">
                    <div>
                        <span class="dash-card-label">Vista rápida</span>
                        <h3>Indicadores</h3>
                    </div>
                </div>
                <div class="dash-progress-list">
                    <div class="dash-progress-item">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Categorías activas</strong>
                            <span>{{ $categoriasActivas }}/{{ max($totalCategorias, 1) }}</span>
                        </div>
                        <div class="progress dash-progress">
                            <div class="progress-bar" style="width: {{ $totalCategorias > 0 ? ($categoriasActivas * 100 / $totalCategorias) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="dash-progress-item">
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Stock bajo</strong>
                            <span>{{ $productosStockBajo }}</span>
                        </div>
                        <div class="progress dash-progress warn">
                            <div class="progress-bar" style="width: {{ $totalProductos > 0 ? min(($productosStockBajo * 100 / $totalProductos), 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </div>
@endsection
