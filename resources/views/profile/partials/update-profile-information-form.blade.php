<section>
    <header class="profile-section-head">
        <span class="section-label">Datos de usuario</span>
        <h3>Información del perfil</h3>
        <p>Actualice su nombre y correo electrónico principal desde este formulario.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form-stack">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="form-label">Nombre completo</label>
            <input id="name" name="name" type="text" class="form-control profile-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div>
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-control profile-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="profile-note mt-3">
                    <strong>Su correo aún no está verificado.</strong>
                    <div class="mt-2">
                        <button form="send-verification" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            Reenviar enlace de verificación
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success mt-2 fw-semibold">
                            Se envió un nuevo enlace de verificación a su correo.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
            <button type="submit" class="btn btn-primary-theme px-4 py-2 rounded-3">Guardar cambios</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success fw-semibold">Cambios guardados correctamente.</span>
            @endif
        </div>
    </form>
</section>
