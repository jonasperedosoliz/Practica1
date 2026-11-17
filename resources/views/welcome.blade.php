<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="view-transition" content="same-origin">
    <title>{{ config('app.name', 'AppWeb-GestionProductos') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #e8f7ff;
            --muted: rgba(196, 230, 255, 0.72);
            --navy: #070b14;
            --panel: rgba(8, 16, 32, 0.55);
            --cyan: #2de7ff;
            --cyan-soft: #7ef3ff;
            --blue: #3f78ff;
            --teal: #1db6a4;
            --glow: 0 0 28px rgba(45, 231, 255, 0.28);
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background: var(--navy);
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; }

        @view-transition {
            navigation: auto;
        }

        .video-stage {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: #050912;
            view-transition-name: cinematic-video;
        }

        html.is-bridging body {
            opacity: 0;
            transform: translateY(10px) scale(0.992);
            filter: blur(4px);
            transition: opacity .32s ease, transform .32s ease, filter .32s ease;
        }

        ::view-transition-old(cinematic-video),
        ::view-transition-new(cinematic-video) {
            animation-duration: .55s;
            animation-timing-function: ease;
        }

        ::view-transition-old(cinematic-shell),
        ::view-transition-new(cinematic-shell) {
            animation-duration: .55s;
        }

        .video-stage video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.04);
            filter: saturate(1.15) contrast(1.05);
        }

        .video-veil,
        .video-glow {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .video-veil {
            background:
                linear-gradient(180deg, rgba(4, 8, 18, 0.72) 0%, rgba(4, 10, 22, 0.45) 38%, rgba(3, 8, 18, 0.78) 100%),
                radial-gradient(circle at 75% 35%, rgba(45, 231, 255, 0.16), transparent 28%),
                radial-gradient(circle at 18% 80%, rgba(63, 120, 255, 0.18), transparent 30%);
        }

        .video-glow {
            background:
                radial-gradient(circle at 50% 0%, rgba(126, 243, 255, 0.12), transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(29, 182, 164, 0.12), transparent 35%);
            animation: aurora 12s ease-in-out infinite alternate;
        }

        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page .landing-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 18px 0 40px;
            flex: 1;
            view-transition-name: cinematic-shell;
        }

        .landing-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.2rem;
            border-radius: 22px;
            background: rgba(8, 16, 32, 0.48);
            border: 1px solid rgba(126, 243, 255, 0.18);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            animation: fadeDown 0.8s ease both;
        }

        .landing-brand {
            display: flex;
            align-items: center;
            gap: .85rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: -.02em;
        }

        .landing-mark {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            transform: rotate(18deg);
            background: linear-gradient(135deg, var(--cyan), var(--blue));
            box-shadow: var(--glow);
            animation: pulseGlow 2.8s ease-in-out infinite;
        }

        .nav-primary {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .78rem 1.25rem;
            border-radius: 999px;
            font-weight: 700;
            color: #041018;
            background: linear-gradient(135deg, var(--cyan-soft), var(--cyan) 45%, #3cc7ff);
            box-shadow: 0 14px 30px rgba(45, 231, 255, 0.28);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .nav-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(45, 231, 255, 0.38);
        }

        .hero {
            min-height: min(78vh, 720px);
            display: grid;
            align-content: end;
            padding: clamp(2.5rem, 8vh, 5.5rem) 0 1.5rem;
        }

        .hero-copy {
            max-width: 720px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .55rem .95rem;
            border-radius: 999px;
            background: rgba(45, 231, 255, 0.08);
            border: 1px solid rgba(126, 243, 255, 0.22);
            color: var(--cyan-soft);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            backdrop-filter: blur(10px);
            animation: fadeUp 0.9s ease both;
            animation-delay: .1s;
        }

        .hero-kicker i {
            color: var(--cyan);
            filter: drop-shadow(0 0 8px rgba(45, 231, 255, 0.7));
        }

        .hero-copy h1 {
            margin: 1.15rem 0 1rem;
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.8rem, 6vw, 4.8rem);
            line-height: .96;
            letter-spacing: -.05em;
            text-shadow: 0 18px 50px rgba(0, 0, 0, 0.45);
            animation: fadeUp 1s ease both;
            animation-delay: .22s;
        }

        .hero-copy h1 span {
            background: linear-gradient(120deg, var(--cyan-soft), #9ecbff 45%, #6aa7ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            filter: drop-shadow(0 0 18px rgba(45, 231, 255, 0.25));
        }

        .hero-copy p {
            margin: 0 0 2rem;
            max-width: 560px;
            color: var(--muted);
            font-size: 1.08rem;
            line-height: 1.75;
            animation: fadeUp 1s ease both;
            animation-delay: .34s;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeUp 1s ease both;
            animation-delay: .46s;
        }

        .hero-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: 1rem 1.45rem;
            border-radius: 18px;
            font-weight: 800;
            color: #041018;
            background: linear-gradient(135deg, #b7fbff, var(--cyan) 40%, #4db8ff);
            box-shadow: 0 18px 36px rgba(45, 231, 255, 0.28);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .hero-cta-primary:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 22px 40px rgba(45, 231, 255, 0.4);
        }

        .hero-cta-ghost {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: 1rem 1.35rem;
            border-radius: 18px;
            font-weight: 700;
            color: #e8f7ff;
            border: 1px solid rgba(126, 243, 255, 0.28);
            background: rgba(8, 16, 32, 0.35);
            backdrop-filter: blur(12px);
            transition: transform .25s ease, border-color .25s ease, background .25s ease;
        }

        .hero-cta-ghost:hover {
            transform: translateY(-2px);
            border-color: rgba(126, 243, 255, 0.55);
            background: rgba(45, 231, 255, 0.08);
        }

        .signal-row {
            margin-top: 2.4rem;
            display: flex;
            flex-wrap: wrap;
            gap: .8rem;
            animation: fadeUp 1s ease both;
            animation-delay: .58s;
        }

        .signal-chip {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .7rem 1rem;
            border-radius: 999px;
            background: rgba(8, 16, 32, 0.42);
            border: 1px solid rgba(126, 243, 255, 0.14);
            backdrop-filter: blur(10px);
            color: rgba(220, 245, 255, 0.88);
            font-size: .9rem;
            font-weight: 600;
        }

        .signal-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--cyan);
            box-shadow: 0 0 12px rgba(45, 231, 255, 0.9);
            animation: blink 1.8s ease-in-out infinite;
        }

        .feature-grid {
            margin-top: 1.5rem;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .feature-card {
            position: relative;
            overflow: hidden;
            padding: 1.55rem;
            border-radius: 24px;
            background: rgba(8, 16, 32, 0.52);
            border: 1px solid rgba(126, 243, 255, 0.16);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(16px);
            transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
            animation: fadeUp 0.9s ease both;
        }

        .feature-card:nth-child(1) { animation-delay: .65s; }
        .feature-card:nth-child(2) { animation-delay: .78s; }
        .feature-card:nth-child(3) { animation-delay: .91s; }

        .feature-card::before {
            content: "";
            position: absolute;
            inset: auto -20% -40% auto;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45, 231, 255, 0.18), transparent 70%);
            pointer-events: none;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(126, 243, 255, 0.42);
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.35), 0 0 30px rgba(45, 231, 255, 0.12);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: var(--cyan-soft);
            background: linear-gradient(145deg, rgba(45, 231, 255, 0.16), rgba(63, 120, 255, 0.12));
            border: 1px solid rgba(126, 243, 255, 0.2);
            box-shadow: var(--glow);
        }

        .feature-card h3 {
            margin: 0 0 .7rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.28rem;
            letter-spacing: -.02em;
        }

        .feature-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            font-size: .98rem;
        }

        .welcome-catalog {
            margin-top: 1.5rem;
            padding: 1.4rem;
            border-radius: 28px;
            background: rgba(8, 16, 32, 0.52);
            border: 1px solid rgba(126, 243, 255, 0.16);
            backdrop-filter: blur(16px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
        }

        .welcome-catalog-head {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
            margin-bottom: 1.2rem;
        }

        .welcome-catalog-head h2 {
            margin: .8rem 0 .45rem;
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.7rem, 3vw, 2.3rem);
        }

        .welcome-catalog-head p {
            margin: 0;
            max-width: 560px;
            color: var(--muted);
            line-height: 1.65;
        }

        .welcome-catalog-grid {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .welcome-product-card {
            border-radius: 20px;
            overflow: hidden;
            background: rgba(8, 16, 32, 0.55);
            border: 1px solid rgba(126, 243, 255, 0.14);
        }

        .welcome-product-media {
            height: 150px;
            display: grid;
            place-items: center;
            background: linear-gradient(160deg, rgba(45, 231, 255, 0.08), rgba(63, 120, 255, 0.12));
            overflow: hidden;
        }

        .welcome-product-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .welcome-product-media.is-empty {
            color: var(--cyan-soft);
            font-size: 1.8rem;
        }

        .welcome-product-body {
            padding: 1rem;
        }

        .welcome-product-body span {
            display: inline-block;
            margin-bottom: .45rem;
            color: var(--cyan-soft);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .welcome-product-body h3 {
            margin: 0 0 .55rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
        }

        .welcome-product-body strong {
            color: #fff;
        }

        .welcome-catalog-grid.is-locked .welcome-product-card {
            filter: blur(3px) saturate(.8);
            opacity: .55;
            pointer-events: none;
        }

        .welcome-catalog-lock {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            background: rgba(4, 10, 20, 0.55);
            backdrop-filter: blur(2px);
            text-align: center;
            z-index: 2;
        }

        .welcome-catalog-lock i {
            font-size: 1.8rem;
            color: var(--cyan);
            margin-bottom: .6rem;
        }

        .welcome-catalog-lock h3 {
            margin: 0 0 .55rem;
            font-family: 'Outfit', sans-serif;
        }

        .welcome-catalog-lock p {
            margin: 0 auto;
            max-width: 420px;
            color: var(--muted);
        }

        .welcome-catalog-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem 1rem;
            color: var(--muted);
        }

        .landing-footer {
            text-align: center;
            padding: 3.2rem 1rem 1.6rem;
            color: rgba(196, 230, 255, 0.55);
            animation: fadeUp 1s ease both;
            animation-delay: 1s;
        }

        .landing-footer h4 {
            margin: 0 0 .45rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.55rem;
            color: #eef9ff;
        }

        .landing-footer hr {
            max-width: 920px;
            margin: 1.4rem auto;
            border: 0;
            border-top: 1px solid rgba(126, 243, 255, 0.12);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 12px rgba(45, 231, 255, 0.35); }
            50% { box-shadow: 0 0 24px rgba(45, 231, 255, 0.75); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .45; transform: scale(.85); }
        }

        @keyframes aurora {
            from { opacity: .55; transform: scale(1); }
            to { opacity: 1; transform: scale(1.05); }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }
        }

        @media (max-width: 992px) {
            .welcome-catalog-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .landing-shell { width: min(100%, calc(100% - 20px)); }
            .hero { min-height: auto; padding-top: 3.5rem; }
        }

        @media (max-width: 576px) {
            .landing-nav,
            .feature-card { padding-left: 1rem; padding-right: 1rem; }
            .landing-brand { font-size: .95rem; }
            .hero-copy h1 { font-size: 2.45rem; }
            .hero-cta a { width: 100%; justify-content: center; }
            .welcome-catalog-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('partials.cinematic-video')

    <div class="page">
        <main class="landing-shell">
            <header class="landing-nav">
                <div class="landing-brand">
                    <span class="landing-mark"></span>
                    <span>AppWeb-GestionProductos</span>
                </div>

                <nav class="landing-actions">
                    @guest
                        <a href="{{ route('login') }}" class="nav-primary js-cinematic-bridge">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Ingresar
                        </a>
                    @else
                        <a href="{{ route('catalogo') }}" class="hero-cta-ghost">Catálogo</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="nav-primary">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Panel admin
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="nav-primary">Mi perfil</a>
                        @endif
                    @endguest
                </nav>
            </header>

            <section class="hero">
                <div class="hero-copy">
                    <span class="hero-kicker">
                        <i class="bi bi-broadcast"></i>
                        Catálogo y gestión de productos
                    </span>
                    <h1>Descubre el inventario y <span>explora</span> el catálogo.</h1>
                    <p>Acceso exclusivo para el administrador. Inicie sesión para gestionar categorías, productos, reportes y el catálogo.</p>

                    <div class="hero-cta">
                        @guest
                            <a href="{{ route('login') }}" class="hero-cta-primary js-cinematic-bridge">
                                Iniciar sesión
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#catalogo" class="hero-cta-ghost">Ver catálogo</a>
                        @else
                            <a href="{{ route('catalogo') }}" class="hero-cta-primary">
                                Abrir catálogo
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="hero-cta-ghost">Ir al panel</a>
                            @endif
                        @endguest
                    </div>

                    <div class="signal-row">
                        <span class="signal-chip"><span class="signal-dot"></span> {{ $totalProductos }} productos</span>
                        <span class="signal-chip"><span class="signal-dot" style="animation-delay:.4s"></span> Acceso administrador</span>
                        <span class="signal-chip"><span class="signal-dot" style="animation-delay:.8s"></span> Catálogo en vivo</span>
                    </div>
                </div>
            </section>

            <section id="catalogo" class="welcome-catalog">
                <div class="welcome-catalog-head">
                    <div>
                        <span class="hero-kicker"><i class="bi bi-grid"></i> Catálogo</span>
                        <h2>Productos destacados</h2>
                        <p>
                            @guest
                                Vista previa bloqueada. Inicie sesión como administrador para explorar el catálogo completo.
                            @else
                                Estos son algunos productos disponibles. Abra el catálogo completo para filtrar y navegar todo el inventario.
                            @endguest
                        </p>
                    </div>
                    @auth
                        <a href="{{ route('catalogo') }}" class="nav-primary">Ver catálogo completo</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-primary js-cinematic-bridge">Ingresar para ver</a>
                    @endauth
                </div>

                <div class="welcome-catalog-grid {{ auth()->check() ? '' : 'is-locked' }}">
                    @forelse($productos as $producto)
                        <article class="welcome-product-card">
                            <div class="welcome-product-media {{ $producto->imagen_url ? '' : 'is-empty' }}">
                                @if($producto->imagen_url)
                                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                                @else
                                    <i class="bi bi-box-seam"></i>
                                @endif
                            </div>
                            <div class="welcome-product-body">
                                <span>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</span>
                                <h3>{{ $producto->nombre }}</h3>
                                <strong>{{ number_format($producto->precio, 2) }} Bs.</strong>
                            </div>
                        </article>
                    @empty
                        <div class="welcome-catalog-empty">
                            <strong>Aún no hay productos publicados</strong>
                            <p>Cuando el administrador registre inventario, aparecerá aquí.</p>
                        </div>
                    @endforelse

                    @guest
                        <div class="welcome-catalog-lock">
                            <div>
                                <i class="bi bi-lock-fill"></i>
                                <h3>Catálogo exclusivo para el administrador</h3>
                                <p>Inicie sesión con la cuenta autorizada para desbloquear precios, stock e imágenes.</p>
                                <div class="hero-cta" style="justify-content:center; margin-top:1rem;">
                                    <a href="{{ route('login') }}" class="hero-cta-primary js-cinematic-bridge">Iniciar sesión</a>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </section>

            <footer class="landing-footer">
                <h4>Sistemas Informáticos · CEFTE 2026</h4>
                <p class="mb-2">Construyendo interfaces robustas sobre Laravel.</p>
                <hr>
                <small>© 2026 Todos los derechos reservados. Desarrollado para la práctica y excelencia de Software.</small>
            </footer>
        </main>
    </div>

    @include('partials.cinematic-bridge')
</body>
</html>
