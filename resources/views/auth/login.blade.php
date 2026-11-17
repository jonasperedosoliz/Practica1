<x-guest-layout hero-title="Acceso seguro" hero-text="Ingresa a tu cuenta para continuar con la gestión del sistema.">
    <form method="POST" action="{{ route('login') }}" class="auth-stack">
        @csrf

        <div class="mb-4">
            <span class="auth-eyebrow">Login</span>
            <h2 class="auth-title">Iniciar sesión</h2>
            <p class="auth-copy mb-0">Ingrese sus datos para continuar.</p>
        </div>

        @if (session('status'))
            <div class="auth-alert">{{ session('status') }}</div>
        @endif

        <div class="auth-field">
            <label for="email" class="auth-label">Correo electrónico</label>
            <input id="email" class="auth-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Contraseña</label>
            <input id="password" class="auth-control" type="password" name="password" required autocomplete="current-password">
            @error('password') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <div class="auth-row">
            <label for="remember_me" class="auth-check">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Recordarme</span>
            </label>
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Recuperar contraseña</a>
            @endif
        </div>

        <button class="auth-submit" type="submit">Entrar</button>
    </form>
</x-guest-layout>
