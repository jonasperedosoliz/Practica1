<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-shell d-lg-flex min-vh-100">
        <aside class="sidebar-panel text-white p-3 p-lg-4 d-flex flex-column justify-content-between">
            <div>
                <div class="brand-panel mb-4">
                    <div class="sidebar-brand-mark mb-3">
                        <span class="brand-mark-dot"></span>
                        <span class="brand-mark-line"></span>
                    </div>
                    <span class="badge brand-badge fw-semibold px-3 py-2 mb-3">ADMIN PANEL</span>
                    <h1 class="h2 fw-bold mb-2">Dashboard</h1>
                    <p class="mb-0 text-white-50">Gestión corporativa integral para categorías, productos y perfil.</p>
                </div>

                <div class="sidebar-nav-card">
                    <div class="sidebar-nav-label mb-3">Menú principal</div>

                    <nav class="nav flex-column gap-2">
                        <a href="{{ route('dashboard') }}" class="sidebar-link nav-link rounded-4 px-3 py-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="sidebar-link-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                            <span class="sidebar-link-copy"><strong>Inicio</strong><small>Vista general del sistema</small></span>
                        </a>
                        <a href="{{ route('listacategorias.index') }}" class="sidebar-link nav-link rounded-4 px-3 py-3 {{ request()->routeIs('listacategorias.*') ? 'active' : '' }}">
                            <span class="sidebar-link-icon"><i class="bi bi-tags"></i></span>
                            <span class="sidebar-link-copy"><strong>Categorías</strong><small>Organización del catálogo</small></span>
                        </a>
                        <a href="{{ route('listaproductos.index') }}" class="sidebar-link nav-link rounded-4 px-3 py-3 {{ request()->routeIs('listaproductos.*') ? 'active' : '' }}">
                            <span class="sidebar-link-icon"><i class="bi bi-box-seam"></i></span>
                            <span class="sidebar-link-copy"><strong>Productos</strong><small>Inventario y precios</small></span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="sidebar-link nav-link rounded-4 px-3 py-3 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <span class="sidebar-link-icon"><i class="bi bi-person-circle"></i></span>
                            <span class="sidebar-link-copy"><strong>Perfil</strong><small>Cuenta y seguridad</small></span>
                        </a>
                    </nav>
                </div>
            </div>

            <div>
                @auth
                    <div class="user-card user-card-shell mb-3">
                        <div class="user-card-head">
                            <span class="user-avatar-badge">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 2)) }}</span>
                            <div>
                                <div class="text-uppercase user-card-label mb-1">Sesión activa</div>
                                <div class="fw-semibold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-white-50 small">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-logout-panel w-100 rounded-4 py-3 fw-semibold">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <div class="content-shell flex-grow-1 p-3 p-lg-4">
            <div class="container-fluid px-0">
                <div class="top-adminbar mb-4">
                    <div class="topbar-left">
                        <span class="topbar-square"><i class="bi bi-columns-gap"></i></span>
                        <span class="topbar-square"><i class="bi bi-grid"></i></span>
                        <div>
                            <div class="top-adminbar-title">Módulo {{ trim($__env->yieldContent('header', 'Panel de control')) }}</div>
                            <div class="top-adminbar-user">Interfaz administrativa y operativa</div>
                        </div>
                    </div>
                    <div class="topbar-right">
                        @auth
                            <span class="topbar-user-chip">{{ Auth::user()->name }}</span>
                        @endauth
                    </div>
                </div>

                <div class="page-header-card mb-4">
                    <div class="page-header-body d-flex flex-column flex-xl-row justify-content-between align-items-start align-items-xl-center gap-3">
                        <div>
                            <div class="text-uppercase fw-semibold section-label mb-2">Área administrativa</div>
                            <h2 class="display-5 fw-bold section-title mb-1">@yield('header', 'Panel administrativo')</h2>
                            <p class="header-subtitle mb-0">@yield('subheader', 'Gestione la información principal del sistema desde este panel')</p>
                        </div>
                        <div class="ms-xl-auto header-actions-wrap">@yield('header_actions')</div>
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
