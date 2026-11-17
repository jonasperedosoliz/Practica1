<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catálogo de productos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="catalog-body">
    @include('partials.cinematic-video')

    <div class="catalog-page">
        <header class="catalog-nav">
            <a href="{{ route('welcome') }}" class="catalog-brand">
                <span class="landing-mark"></span>
                <span>AppWeb-GestionProductos</span>
            </a>
            <div class="catalog-nav-actions">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn btn-cinematic-soft">Panel admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-cinematic-soft">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-cinematic">Cerrar sesión</button>
                    </form>
                @endauth
            </div>
        </header>

        <main class="catalog-shell">
            <section class="catalog-hero-panel">
                <div>
                    <span class="dash-kicker"><i class="bi bi-grid"></i> Catálogo</span>
                    <h1>Explore nuestros productos</h1>
                    <p>Inventario disponible con categorías, precios y stock actualizado.</p>
                </div>
            </section>

            <form method="GET" action="{{ route('catalogo') }}" class="catalog-filters">
                <div class="crud-search-field">
                    <i class="bi bi-search"></i>
                    <input type="text" name="buscar" value="{{ $busqueda }}" placeholder="Buscar producto o categoría">
                </div>
                <select name="categoria" class="form-select catalog-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected((string) $categoriaId === (string) $categoria->id)>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-cinematic">Filtrar</button>
                @if($busqueda !== '' || filled($categoriaId))
                    <a href="{{ route('catalogo') }}" class="btn btn-cinematic-soft">Limpiar</a>
                @endif
            </form>

            <div class="catalog-grid">
                @forelse($productos as $producto)
                    <article class="catalog-card">
                        <div class="catalog-card-media {{ $producto->imagen_url ? '' : 'is-empty' }}">
                            @if($producto->imagen_url)
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                            @else
                                <i class="bi bi-box-seam"></i>
                            @endif
                        </div>
                        <div class="catalog-card-body">
                            <span class="catalog-card-category">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</span>
                            <h3>{{ $producto->nombre }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($producto->descripcion ?: 'Sin descripción', 90) }}</p>
                            <div class="catalog-card-meta">
                                <strong>{{ number_format($producto->precio, 2) }} Bs.</strong>
                                <span>Stock: {{ $producto->stock }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="catalog-empty">
                        <strong>No hay productos para mostrar</strong>
                        <p>
                            @if(auth()->user()?->isAdmin())
                                Aún no hay inventario publicado. Cree productos desde el panel admin para verlos aquí.
                            @else
                                El catálogo está vacío por ahora. Vuelva más tarde cuando haya productos disponibles.
                            @endif
                        </p>
                        @if(auth()->user()?->isAdmin())
                            <div style="margin-top: 1rem;">
                                <a href="{{ route('listaproductos.create') }}" class="btn btn-cinematic">
                                    <i class="bi bi-plus-circle"></i> Nuevo producto
                                </a>
                            </div>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($productos->total() > 0)
                <div class="catalog-footer">
                    <div class="table-summary-text">
                        Mostrando {{ $productos->firstItem() }}-{{ $productos->lastItem() }} de {{ $productos->total() }}
                    </div>
                    <div class="pagination-shell">
                        {{ $productos->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
