<x-guest-layout hero-title="Crear cuenta" hero-text="Regístrese con su correo para explorar el catálogo de productos.">
    <form method="POST" action="{{ route('register') }}" class="auth-stack">
        @csrf

        <div class="mb-4">
            <span class="auth-eyebrow">Registro</span>
            <h2 class="auth-title">Crear cuenta</h2>
            <p class="auth-copy mb-0">Acceda al catálogo con su correo y contraseña.</p>
        </div>

        <div class="auth-field">
            <label for="name" class="auth-label">Nombre completo</label>
            <input id="name" class="auth-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <div class="auth-field">
            <label for="email" class="auth-label">Correo electrónico</label>
            <input id="email" class="auth-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Contraseña</label>
            <input id="password" class="auth-control" type="password" name="password" required autocomplete="new-password">
            @error('password') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <div class="auth-field">
            <label for="password_confirmation" class="auth-label">Confirmar contraseña</label>
            <input id="password_confirmation" class="auth-control" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation') <div class="invalid-copy">{{ $message }}</div> @enderror
        </div>

        <button class="auth-submit" type="submit">Registrarme</button>
        <p class="auth-footer mb-0 mt-4">¿Ya tiene cuenta? <a class="auth-link js-cinematic-bridge" href="{{ route('login') }}">Iniciar sesión</a></p>
    </form>
</x-guest-layout>
