@props([
    'heroTitle' => 'Acceso seguro',
    'heroText' => 'Ingresa a tu cuenta para continuar con la gestión del sistema.',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="view-transition" content="same-origin">

    <title>{{ config('app.name', 'AppWeb-GestionProductos') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #e8f7ff;
            --ink-dark: #0b1524;
            --muted: rgba(196, 230, 255, 0.72);
            --slate: #6b849c;
            --navy: #070b14;
            --cyan: #2de7ff;
            --cyan-soft: #7ef3ff;
            --blue: #3f78ff;
            --teal: #1db6a4;
            --danger: #ff6b8a;
            --success: #3ddea8;
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
                linear-gradient(180deg, rgba(4, 8, 18, 0.72) 0%, rgba(4, 10, 22, 0.42) 40%, rgba(3, 8, 18, 0.82) 100%),
                radial-gradient(circle at 78% 30%, rgba(45, 231, 255, 0.14), transparent 28%),
                radial-gradient(circle at 16% 78%, rgba(63, 120, 255, 0.16), transparent 30%);
        }

        .video-glow {
            background:
                radial-gradient(circle at 50% 0%, rgba(126, 243, 255, 0.12), transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(29, 182, 164, 0.12), transparent 35%);
            animation: aurora 12s ease-in-out infinite alternate;
        }

        .guest-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        .guest-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            min-height: 100vh;
            padding: 18px 0 28px;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(340px, 0.95fr);
            gap: 1.1rem;
            align-items: stretch;
            view-transition-name: cinematic-shell;
        }

        .guest-showcase,
        .guest-form-side {
            display: flex;
        }

        .guest-showcase-card,
        .guest-form-card {
            width: 100%;
            border-radius: 28px;
            background: rgba(8, 16, 32, 0.52);
            border: 1px solid rgba(126, 243, 255, 0.16);
            box-shadow: 0 22px 48px rgba(0, 0, 0, 0.32), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(18px);
            overflow: hidden;
        }

        .guest-showcase-card {
            padding: 1.6rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.5rem;
            animation: fadeUp .8s ease both;
        }

        .guest-brand-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .guest-brand {
            display: flex;
            align-items: center;
            gap: .8rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .guest-brand-mark {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            transform: rotate(18deg);
            background: linear-gradient(135deg, var(--cyan), var(--blue));
            box-shadow: var(--glow);
            animation: pulseGlow 2.8s ease-in-out infinite;
        }

        .guest-nav {
            display: flex;
            gap: .7rem;
            flex-wrap: wrap;
        }

        .guest-nav a {
            padding: .72rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            color: rgba(232, 247, 255, 0.92);
            border: 1px solid rgba(126, 243, 255, 0.18);
            background: rgba(8, 16, 32, 0.35);
            transition: transform .2s ease, border-color .2s ease, background .2s ease;
        }

        .guest-nav a:hover,
        .guest-nav a.is-active {
            transform: translateY(-1px);
            border-color: rgba(126, 243, 255, 0.45);
            background: rgba(45, 231, 255, 0.12);
        }

        .guest-kicker {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .9rem;
            border-radius: 999px;
            background: rgba(45, 231, 255, 0.08);
            border: 1px solid rgba(126, 243, 255, 0.22);
            color: var(--cyan-soft);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .guest-copy h1 {
            margin: 0 0 .9rem;
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.6rem, 5vw, 4.2rem);
            line-height: .96;
            letter-spacing: -.05em;
        }

        .guest-copy h1 span {
            background: linear-gradient(120deg, var(--cyan-soft), #9ecbff 45%, #6aa7ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .guest-copy p {
            margin: 0;
            max-width: 520px;
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .guest-feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .85rem;
        }

        .guest-feature {
            padding: 1rem;
            border-radius: 18px;
            background: rgba(8, 16, 32, 0.42);
            border: 1px solid rgba(126, 243, 255, 0.12);
        }

        .guest-feature strong {
            display: block;
            font-family: 'Outfit', sans-serif;
            margin-bottom: .4rem;
        }

        .guest-feature span {
            display: block;
            color: var(--muted);
            line-height: 1.55;
            font-size: .9rem;
        }

        .guest-form-side {
            animation: fadeUp .9s ease both;
            animation-delay: .12s;
        }

        .guest-form-card {
            display: flex;
            flex-direction: column;
            background: rgba(246, 252, 255, 0.92);
            color: var(--ink-dark);
            border-color: rgba(126, 243, 255, 0.28);
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.28), 0 0 40px rgba(45, 231, 255, 0.08);
        }

        .guest-form-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.15rem 1.35rem;
            border-bottom: 1px solid rgba(15, 35, 55, 0.08);
            background: linear-gradient(180deg, rgba(235, 248, 255, 0.95), rgba(255, 255, 255, 0.88));
        }

        .guest-form-topbar strong {
            display: block;
            font-family: 'Outfit', sans-serif;
            font-size: 1.02rem;
            color: var(--ink-dark);
        }

        .guest-form-topbar small {
            display: block;
            margin-top: .2rem;
            color: var(--slate);
        }

        .guest-back-link {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            min-height: 40px;
            padding: .65rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            color: var(--ink-dark);
            background: rgba(15, 35, 55, 0.06);
            border: 1px solid rgba(45, 231, 255, 0.18);
            transition: transform .2s ease, background .2s ease;
        }

        .guest-back-link:hover {
            transform: translateY(-1px);
            background: rgba(45, 231, 255, 0.12);
        }

        .guest-form-body {
            padding: 1.7rem;
        }

        .auth-eyebrow {
            display: inline-block;
            margin-bottom: .7rem;
            color: #1aa9c4;
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .78rem;
            font-weight: 800;
        }

        .auth-title {
            margin: 0 0 .5rem;
            font-family: 'Outfit', sans-serif;
            font-size: 2.15rem;
            line-height: 1;
            color: var(--ink-dark);
        }

        .auth-copy,
        .auth-footer {
            color: var(--slate);
        }

        .auth-stack {
            display: grid;
            gap: 1rem;
        }

        .auth-field {
            display: grid;
            gap: .45rem;
        }

        .auth-label {
            font-weight: 700;
            color: var(--ink-dark);
        }

        .auth-control {
            width: 100%;
            min-height: 56px;
            border-radius: 16px;
            border: 1px solid rgba(15, 35, 55, 0.12);
            background: rgba(255, 255, 255, 0.96);
            padding: 0 1rem;
            font: inherit;
            color: var(--ink-dark);
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .auth-control:focus {
            outline: none;
            border-color: rgba(45, 231, 255, 0.55);
            box-shadow: 0 0 0 .2rem rgba(45, 231, 255, 0.12);
        }

        .auth-submit {
            width: 100%;
            min-height: 56px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #b7fbff, var(--cyan) 40%, #4db8ff);
            color: #041018;
            font-weight: 800;
            box-shadow: 0 16px 30px rgba(45, 231, 255, 0.28);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .auth-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 34px rgba(45, 231, 255, 0.38);
        }

        .auth-link {
            color: #1788a8;
            font-weight: 700;
        }

        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            color: var(--slate);
            font-weight: 600;
        }

        .auth-check input {
            width: 18px;
            height: 18px;
        }

        .auth-alert {
            padding: .95rem 1rem;
            border-radius: 16px;
            background: rgba(61, 222, 168, 0.12);
            border: 1px solid rgba(61, 222, 168, 0.22);
            color: #148a64;
            font-weight: 600;
        }

        .invalid-copy {
            color: var(--danger);
            font-size: .92rem;
            margin-top: 6px;
        }

        .mb-0 { margin-bottom: 0; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1.5rem; }

        html.is-bridging body {
            opacity: 0;
            transform: translateY(10px) scale(0.992);
            filter: blur(4px);
            transition: opacity .32s ease, transform .32s ease, filter .32s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 12px rgba(45, 231, 255, 0.35); }
            50% { box-shadow: 0 0 24px rgba(45, 231, 255, 0.75); }
        }

        @keyframes aurora {
            from { opacity: .55; transform: scale(1); }
            to { opacity: 1; transform: scale(1.05); }
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

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }
        }

        @media (max-width: 1100px) {
            .guest-feature-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 992px) {
            .guest-shell {
                grid-template-columns: 1fr;
                width: min(100%, calc(100% - 20px));
            }
        }

        @media (max-width: 576px) {
            .guest-showcase-card,
            .guest-form-body { padding: 1.2rem; }
            .guest-form-topbar { padding: 1rem; }
            .guest-copy h1 { font-size: 2.4rem; }
            .auth-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @include('partials.cinematic-video')

    <div class="guest-page">
        <main class="guest-shell">
            <section class="guest-showcase">
                <div class="guest-showcase-card">
                    <div>
                        <div class="guest-brand-row">
                            <div class="guest-brand">
                                <span class="guest-brand-mark"></span>
                                <span>AppWeb-GestionProductos</span>
                            </div>

                            <nav class="guest-nav">
                                <a href="{{ route('welcome') }}" class="js-cinematic-bridge {{ request()->routeIs('welcome') ? 'is-active' : '' }}">Inicio</a>
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="js-cinematic-bridge {{ request()->routeIs('login') ? 'is-active' : '' }}">Ingresar</a>
                                @endif
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="js-cinematic-bridge {{ request()->routeIs('register') ? 'is-active' : '' }}">Registrarse</a>
                                @endif
                            </nav>
                        </div>

                        <div class="guest-copy" style="margin-top: 2rem;">
                            <span class="guest-kicker">
                                <i class="bi bi-shield-lock"></i>
                                Panel administrativo y operativo
                            </span>
                            <h1>{{ $heroTitle }}</h1>
                            <p>{{ $heroText }}</p>
                        </div>
                    </div>

                    <div class="guest-feature-grid">
                        <article class="guest-feature">
                            <strong>Inventario centralizado</strong>
                            <span>Gestione productos, stock e imágenes con una interfaz clara y consistente.</span>
                        </article>
                        <article class="guest-feature">
                            <strong>Categorías organizadas</strong>
                            <span>Mantenga el catálogo limpio con filtros, estados y módulos bien estructurados.</span>
                        </article>
                        <article class="guest-feature">
                            <strong>Reportes instantáneos</strong>
                            <span>Genere PDFs y Excel desde el panel sin perder velocidad.</span>
                        </article>
                    </div>
                </div>
            </section>

            <section class="guest-form-side">
                <div class="guest-form-card">
                    <div class="guest-form-topbar">
                        <div>
                            <strong>Acceso al sistema</strong>
                            <small>Autenticación segura para usuarios autorizados</small>
                        </div>
                        <a href="{{ route('welcome') }}" class="guest-back-link js-cinematic-bridge">
                            <i class="bi bi-arrow-left"></i>
                            Volver
                        </a>
                    </div>
                    <div class="guest-form-body">
                        {{ $slot }}
                    </div>
                </div>
            </section>
        </main>
    </div>

    @include('partials.cinematic-bridge')
</body>
</html>
