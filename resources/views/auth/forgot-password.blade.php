<x-guest-layout hero-title="RECUPERAR" hero-text="Recupere su acceso mediante su correo electrónico.">
    <div class="mb-4">
        <span class="auth-eyebrow">Recuperación</span>
        <h2 class="auth-title">Recuperar contraseña</h2>
        <p class="auth-copy mb-0">Ingrese su correo electrónico para recibir el enlace de recuperación.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" class="form-control auth-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button class="btn auth-submit w-100" type="submit">Enviar enlace</button>
        <p class="auth-footer mb-0 mt-4">¿Recordó su contraseña? <a class="auth-link" href="{{ route('login') }}">Volver al login</a></p>
    </form>
</x-guest-layout>
