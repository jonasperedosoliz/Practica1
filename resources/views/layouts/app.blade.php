<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'AppWeb-GestionProductos'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside id="adminDrawer" class="admin-drawer" aria-label="Menú principal">
            <div class="drawer-inner">
                <div class="drawer-top">
                    <div class="drawer-brand">
                        <span class="drawer-brand-mark"></span>
                        <div>
                            <strong>AppWeb-GestionProductos</strong>
                            <small>Panel administrador</small>
                        </div>
                    </div>
                    <button type="button" class="drawer-close d-lg-none" data-drawer-close aria-label="Cerrar menú">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <nav class="drawer-nav">
                    <span class="drawer-nav-label">Navegación</span>

                    @if(auth()->user()?->isAdmin())
                        <a href="{{ route('dashboard') }}" class="drawer-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                            <span class="drawer-link-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                            <span class="drawer-link-text">Inicio</span>
                        </a>

                        <a href="{{ route('listacategorias.index') }}" class="drawer-link {{ request()->routeIs('listacategorias.*') ? 'is-active' : '' }}">
                            <span class="drawer-link-icon"><i class="bi bi-tags"></i></span>
                            <span class="drawer-link-text">Categorías</span>
                        </a>

                        <a href="{{ route('listaproductos.index') }}" class="drawer-link {{ request()->routeIs('listaproductos.*') ? 'is-active' : '' }}">
                            <span class="drawer-link-icon"><i class="bi bi-box-seam"></i></span>
                            <span class="drawer-link-text">Productos</span>
                        </a>
                    @endif

                    <a href="{{ route('catalogo') }}" class="drawer-link {{ request()->routeIs('catalogo') ? 'is-active' : '' }}">
                        <span class="drawer-link-icon"><i class="bi bi-grid"></i></span>
                        <span class="drawer-link-text">Catálogo</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="drawer-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">
                        <span class="drawer-link-icon"><i class="bi bi-person-circle"></i></span>
                        <span class="drawer-link-text">Perfil</span>
                    </a>
                </nav>

                <div class="drawer-footer">
                    @auth
                        <div class="drawer-user">
                            <span class="drawer-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(Auth::user()->name, 0, 2)) }}</span>
                            <div>
                                <strong>{{ Auth::user()->name }}</strong>
                                <small>{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="drawer-logout">
                                <i class="bi bi-box-arrow-right"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </aside>

        <div class="drawer-backdrop d-lg-none" data-drawer-close></div>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button type="button" class="drawer-toggle d-lg-none" data-drawer-open aria-label="Abrir menú">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <div class="admin-topbar-kicker">Área administrativa</div>
                        <h1 class="admin-topbar-title">@yield('header', 'Panel de control')</h1>
                        <p class="admin-topbar-sub">@yield('subheader', 'Interfaz administrativa y operativa')</p>
                    </div>
                </div>
                <div class="admin-topbar-right">
                    @hasSection('header_actions')
                        <div class="admin-topbar-actions">@yield('header_actions')</div>
                    @endif
                    @auth
                        <span class="admin-user-chip">
                            <i class="bi bi-shield-check"></i>
                            {{ Auth::user()->name }}
                        </span>
                    @endauth
                </div>
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const shell = document.querySelector('.admin-shell');
            if (!shell) return;

            const open = () => shell.classList.add('drawer-open');
            const close = () => shell.classList.remove('drawer-open');

            document.querySelectorAll('[data-drawer-open]').forEach((btn) => btn.addEventListener('click', open));
            document.querySelectorAll('[data-drawer-close]').forEach((btn) => btn.addEventListener('click', close));
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) close();
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
