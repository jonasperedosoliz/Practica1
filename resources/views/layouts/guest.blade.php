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

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ink: #142135;
            --slate: #5f7188;
            --navy: #0f172d;
            --navy-soft: #1d2740;
            --blue: #3b82f6;
            --blue-soft: #74a7ff;
            --teal: #1fb6a6;
            --paper: #f4f7fb;
            --white: #ffffff;
            --danger: #d24a64;
            --success: #1e8f5c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.12), transparent 24%),
                radial-gradient(circle at bottom right, rgba(31, 182, 166, 0.12), transparent 22%),
                linear-gradient(180deg, #eef3f9 0%, #f8fbff 100%);
        }

        a { text-decoration: none; }

        .guest-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(360px, 1.02fr) minmax(420px, .98fr);
            align-items: stretch;
        }

        .guest-showcase {
            position: relative;
            overflow: hidden;
            padding: 2rem;
            display: flex;
        }

        .guest-showcase-card {
            position: relative;
            width: 100%;
            border-radius: 34px;
            background:
                radial-gradient(circle at top right, rgba(116, 167, 255, 0.18), transparent 24%),
                radial-gradient(circle at bottom left, rgba(31, 182, 166, 0.14), transparent 22%),
                linear-gradient(160deg, #111a30 0%, #1a2340 56%, #243155 100%);
            box-shadow: 0 30px 60px rgba(17, 24, 39, 0.24);
            color: #fff;
            padding: 2.2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .guest-brand {
            display: flex;
            align-items: center;
            gap: .8rem;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .guest-brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--blue), var(--blue-soft));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 18px 24px rgba(59, 130, 246, 0.25);
        }

        .guest-brand-mark::before {
            content: '';
            width: 18px;
            height: 18px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.9);
            transform: rotate(12deg);
        }

        .guest-nav {
            display: flex;
            gap: .8rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .guest-nav a {
            padding: .75rem 1rem;
            border-radius: 999px;
            color: rgba(255,255,255,.9);
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            font-weight: 700;
            transition: transform .18s ease, background-color .18s ease, border-color .18s ease;
        }

        .guest-nav a:hover {
            transform: translateY(-1px);
            background: rgba(255,255,255,.12);
            border-color: rgba(255,255,255,.18);
        }

        .guest-copy {
            max-width: 560px;
            padding: 2rem 0;
        }

        .guest-kicker {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .45rem .85rem;
            border-radius: 999px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.88);
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
        }

        .guest-copy h1 {
            margin: 0 0 1rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: clamp(3rem, 5vw, 4.8rem);
            line-height: .96;
            letter-spacing: -.05em;
            max-width: 520px;
        }

        .guest-copy h1 span {
            color: #7db0ff;
        }

        .guest-copy p {
            margin: 0;
            max-width: 520px;
            font-size: 1.1rem;
            line-height: 1.7;
            color: rgba(234, 241, 255, 0.76);
        }

        .guest-feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .guest-feature {
            padding: 1.1rem;
            border-radius: 22px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            backdrop-filter: blur(8px);
        }

        .guest-feature strong {
            display: block;
            font-family: 'Outfit', sans-serif;
            font-size: 1.02rem;
            margin-bottom: .45rem;
        }

        .guest-feature span {
            display: block;
            color: rgba(234, 241, 255, 0.74);
            line-height: 1.55;
            font-size: .92rem;
        }

        .guest-form-side {
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guest-form-card {
            width: 100%;
            max-width: 560px;
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(20, 33, 53, 0.08);
            border-radius: 30px;
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.12);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .guest-form-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.2rem 1.45rem;
            border-bottom: 1px solid rgba(20, 33, 53, 0.08);
            background: linear-gradient(180deg, rgba(244,247,251,.88), rgba(255,255,255,.82));
        }

        .guest-form-topbar strong {
            font-family: 'Outfit', sans-serif;
            font-size: 1.02rem;
            color: var(--ink);
        }

        .guest-form-topbar small {
            color: var(--slate);
            display: block;
            margin-top: .2rem;
        }

        .guest-back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: .65rem 1rem;
            border-radius: 999px;
            color: var(--ink);
            background: rgba(20,33,53,.05);
            font-weight: 700;
        }

        .guest-form-body {
            padding: 2rem;
        }

        .auth-eyebrow {
            display: inline-block;
            margin-bottom: .75rem;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: .8rem;
            font-weight: 800;
        }

        .auth-title {
            margin: 0 0 .55rem;
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            line-height: 1;
            color: var(--ink);
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
            color: var(--ink);
        }

        .auth-control {
            width: 100%;
            min-height: 56px;
            border-radius: 16px;
            border: 1px solid rgba(20, 33, 53, 0.12);
            background: rgba(255,255,255,.96);
            padding: 0 1rem;
            font: inherit;
            color: var(--ink);
        }

        .auth-control:focus {
            outline: none;
            border-color: rgba(59, 130, 246, .38);
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, 0.08);
        }

        .auth-submit {
            width: 100%;
            min-height: 56px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #356dff, #5d8cff);
            color: #fff;
            font-weight: 800;
            box-shadow: 0 18px 28px rgba(53, 109, 255, 0.22);
            cursor: pointer;
        }

        .auth-link {
            color: #265fda;
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
            background: rgba(30, 143, 92, 0.10);
            border: 1px solid rgba(30, 143, 92, 0.16);
            color: var(--success);
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

        @media (max-width: 1100px) {
            .guest-feature-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .guest-shell {
                grid-template-columns: 1fr;
            }

            .guest-showcase,
            .guest-form-side {
                padding: 1rem;
            }

            .guest-showcase-card {
                min-height: 440px;
            }

            .guest-nav {
                justify-content: flex-start;
            }
        }

        @media (max-width: 576px) {
            .guest-showcase-card,
            .guest-form-body {
                padding: 1.35rem;
            }

            .guest-form-topbar {
                padding: 1rem 1.2rem;
            }

            .guest-copy h1 {
                font-size: 2.6rem;
            }

            .auth-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <main class="guest-shell">
        <section class="guest-showcase">
            <div class="guest-showcase-card">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                            <div class="guest-brand">
                                <span class="guest-brand-mark"></span>
                                <span>AppWeb-GestionProductos</span>
                            </div>

                            <nav class="guest-nav">
                                <a href="{{ route('welcome') }}">Inicio</a>
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}">Ingresar</a>
                                @endif
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Crear cuenta</a>
                                @endif
                            </nav>
                        </div>

                        <div class="guest-copy">
                            <span class="guest-kicker">Panel administrativo y operativo</span>
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
                            <span>Genere PDFs desde el panel sin sacrificar ligereza ni velocidad de carga.</span>
                        </article>
                    </div>
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
                    <a href="{{ route('welcome') }}" class="guest-back-link">Volver</a>
                </div>
                <div class="guest-form-body">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </main>
</body>
</html>
