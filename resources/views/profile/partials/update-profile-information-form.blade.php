<header class="profile-section-head">
    <span class="crud-panel-label">Datos de usuario</span>
    <h3>Información del perfil</h3>
    <p>Actualice su nombre y correo electrónico principal.</p>
</header>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="profile-form-stack">
    @csrf
    @method('patch')

    <div class="crud-field">
        <label for="name">Nombre completo <span>*</span></label>
        <input id="name" name="name" type="text" class="form-control profile-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="crud-field">
        <label for="email">Correo electrónico <span>*</span></label>
        <input id="email" name="email" type="email" class="form-control profile-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="profile-note mt-3">
                <strong>Su correo aún no está verificado.</strong>
                <div class="mt-2">
                    <button form="send-verification" class="btn btn-cinematic-soft">
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

    <div class="crud-form-actions">
        <button type="submit" class="btn btn-cinematic">
            <i class="bi bi-check2-circle"></i> Guardar cambios
        </button>

        @if (session('status') === 'profile-updated')
            <span class="profile-success">Cambios guardados correctamente.</span>
        @endif
    </div>
</form>
