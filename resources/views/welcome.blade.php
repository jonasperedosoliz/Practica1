<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #132238;
            --slate: #61748b;
            --navy: #131c32;
            --blue: #3f78ff;
            --blue-soft: #78a3ff;
            --teal: #1db6a4;
            --paper: #f5f8fc;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(63, 120, 255, 0.10), transparent 20%),
                radial-gradient(circle at bottom right, rgba(29, 182, 164, 0.08), transparent 20%),
                linear-gradient(180deg, #f4f7fb 0%, #fbfdff 100%);
        }

        a { text-decoration: none; }

        .landing-shell {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 18px 0 30px;
        }

        .landing-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.05rem 1.25rem;
            border-radius: 22px;
            background: rgba(255,255,255,.84);
            border: 1px solid rgba(19,34,56,.06);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            backdrop-filter: blur(10px);
        }

        .landing-brand {
            display: flex;
            align-items: center;
            gap: .8rem;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .landing-mark {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            transform: rotate(18deg);
            background: linear-gradient(135deg, var(--blue), var(--blue-soft));
            box-shadow: 0 10px 18px rgba(63, 120, 255, 0.25);
        }

        .landing-actions {
            display: flex;
            gap: .9rem;
            flex-wrap: wrap;
        }

        .landing-actions a {
            padding: .8rem 1.2rem;
            border-radius: 999px;
            font-weight: 700;
        }

        .nav-ghost {
            color: var(--ink);
            background: rgba(19,34,56,.05);
        }

        .nav-primary {
            color: #fff;
            background: linear-gradient(135deg, #356dff, #5f8eff);
            box-shadow: 0 16px 24px rgba(53, 109, 255, 0.2);
        }

        .hero-card {
            margin-top: 18px;
            border-radius: 0 0 46px 46px;
            background:
                radial-gradient(circle at top right, rgba(96, 142, 255, 0.15), transparent 20%),
                linear-gradient(140deg, #131b31 0%, #1d2845 45%, #202d4e 100%);
            color: #fff;
            padding: 2rem 2rem 2.2rem;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.18);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 2rem;
            align-items: center;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .5rem .85rem;
            border-radius: 999px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.08);
            color: rgba(255,255,255,.82);
            font-size: .82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .hero-copy h1 {
            margin: 1rem 0 1rem;
            font-family: 'Outfit', sans-serif;
            font-size: clamp(3rem, 5vw, 4.7rem);
            line-height: .95;
            letter-spacing: -.05em;
            max-width: 620px;
        }

        .hero-copy h1 span {
            color: #77a7ff;
        }

        .hero-copy p {
            margin: 0 0 2rem;
            max-width: 590px;
            color: rgba(226, 235, 251, 0.8);
            font-size: 1.13rem;
            line-height: 1.75;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-cta a {
            padding: 1rem 1.4rem;
            border-radius: 18px;
            font-weight: 800;
        }

        .hero-cta-primary {
            background: linear-gradient(135deg, #6aa7ff, #4f87ff);
            color: #fff;
            box-shadow: 0 18px 28px rgba(79, 135, 255, 0.22);
        }

        .hero-cta-secondary {
            color: #fff;
            border: 1px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.04);
        }

        .hero-preview {
            display: flex;
            justify-content: center;
        }

        .hero-analytics {
            width: min(100%, 360px);
            border-radius: 28px;
            padding: 1rem;
            background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(248,251,255,.88));
            box-shadow: 0 26px 46px rgba(8, 15, 30, 0.18);
            transform: rotate(-1deg);
        }

        .hero-screen {
            height: 248px;
            border-radius: 22px;
            background:
                linear-gradient(180deg, rgba(13,18,30,.95), rgba(20,27,45,.95)),
                #101826;
            position: relative;
            overflow: hidden;
            padding: 1rem;
        }

        .hero-bars {
            position: absolute;
            inset: 18px 18px auto 18px;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: .45rem;
            align-items: end;
            height: 92px;
        }

        .hero-bars span {
            display: block;
            border-radius: 10px 10px 4px 4px;
            background: linear-gradient(180deg, #3ee7cf, #2797ff);
        }

        .hero-line {
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 30px;
            height: 90px;
        }

        .hero-line svg {
            width: 100%;
            height: 100%;
        }

        .feature-grid {
            margin: -18px auto 0;
            width: min(960px, calc(100% - 24px));
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .feature-card {
            background: rgba(255,255,255,.92);
            border-radius: 24px;
            padding: 1.6rem;
            border: 1px solid rgba(19,34,56,.06);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            margin-bottom: 1rem;
        }

        .icon-blue { background: rgba(63,120,255,.10); color: #356dff; }
        .icon-green { background: rgba(29,182,164,.12); color: #169786; }
        .icon-pink { background: rgba(255,86,132,.10); color: #ff4d7d; }

        .feature-card h3 {
            margin: 0 0 .75rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
        }

        .feature-card p {
            margin: 0;
            color: var(--slate);
            line-height: 1.7;
        }

        .landing-footer {
            text-align: center;
            padding: 4.2rem 1rem 1.4rem;
            color: var(--slate);
        }

        .landing-footer h4 {
            margin: 0 0 .5rem;
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            color: var(--ink);
        }

        @media (max-width: 992px) {
            .hero-grid,
            .feature-grid {
                grid-template-columns: 1fr;
            }

            .landing-shell {
                width: min(100%, calc(100% - 20px));
            }

            .hero-card {
                border-radius: 0 0 34px 34px;
            }
        }

        @media (max-width: 576px) {
            .landing-nav,
            .hero-card,
            .feature-card {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .landing-actions {
                width: 100%;
            }

            .landing-actions a {
                flex: 1 1 auto;
                text-align: center;
            }

            .hero-copy h1 {
                font-size: 2.55rem;
            }
        }
    </style>
</head>
<body>
    <main class="landing-shell">
        <header class="landing-nav">
            <div class="landing-brand">
                <span class="landing-mark"></span>
                <span>AppWeb-GestionProductos</span>
            </div>

            <nav class="landing-actions">
                @guest
                    <a href="{{ route('login') }}" class="nav-ghost">Ingresar</a>
                    <a href="{{ route('register') }}" class="nav-primary">Comenzar Gratis</a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-primary">Ir al panel</a>
                @endguest
            </nav>
        </header>

        <section class="hero-card">
            <div class="hero-grid">
                <div class="hero-copy">
                    <span class="hero-kicker">Sistema de gestión administrativa</span>
                    <h1>El panel definitivo para <span>gestionar</span> tu organización.</h1>
                    <p>Automatiza y centraliza el inventario, organiza tus categorías con exactitud y accede a reportes en tiempo real. Diseñado para una experiencia profesional, rápida y clara.</p>

                    <div class="hero-cta">
                        @guest
                            <a href="{{ route('register') }}" class="hero-cta-primary">Crear una cuenta</a>
                            <a href="{{ route('login') }}" class="hero-cta-secondary">Iniciar sesión</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="hero-cta-primary">Abrir panel</a>
                        @endguest
                    </div>
                </div>

                <div class="hero-preview">
                    <div class="hero-analytics">
                        <div class="hero-screen">
                            <div class="hero-bars">
                                <span style="height: 46%"></span>
                                <span style="height: 74%"></span>
                                <span style="height: 60%"></span>
                                <span style="height: 88%"></span>
                                <span style="height: 52%"></span>
                                <span style="height: 72%"></span>
                                <span style="height: 63%"></span>
                                <span style="height: 94%"></span>
                            </div>
                            <div class="hero-line">
                                <svg viewBox="0 0 300 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 72C22 68 36 38 58 40C82 43 87 82 115 78C146 73 146 28 176 25C205 23 213 63 243 65C269 66 282 48 300 40" stroke="#7DB0FF" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M0 86C21 84 34 62 58 59C81 56 93 75 116 76C146 77 152 49 177 48C202 46 215 65 242 67C263 68 281 58 300 51" stroke="#3DE0C8" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="feature-grid">
            <article class="feature-card">
                <span class="feature-icon icon-blue">□</span>
                <h3>Gestión de Inventario</h3>
                <p>Control total sobre tus productos, sincronización instantánea y organización limpia sin fisuras estructurales.</p>
            </article>

            <article class="feature-card">
                <span class="feature-icon icon-green">◇</span>
                <h3>Categorización</h3>
                <p>Familias de productos con estados dinámicos controlados inteligentemente bajo una interfaz moderna y legible.</p>
            </article>

            <article class="feature-card">
                <span class="feature-icon icon-pink">↗</span>
                <h3>Reportes Instantáneos</h3>
                <p>Genera documentos y reportes exportables directamente desde el sistema con una presentación más profesional.</p>
            </article>
        </section>

        <footer class="landing-footer">
            <h4>Sistemas Informáticos · CEFTE 2026</h4>
            <p class="mb-2">Construyendo interfaces robustas sobre Laravel.</p>
            <hr class="mx-auto my-4" style="max-width: 920px; border-color: rgba(19,34,56,.08);">
            <small>© 2026 Todos los derechos reservados. Desarrollado para la práctica y excelencia de Software.</small>
        </footer>
    </main>
</body>
</html>
