<section>
    <header class="profile-section-head">
        <span class="section-label">Seguridad</span>
        <h3>Cambiar contraseña</h3>
        <p>Laravel no permite mostrar la contraseña actual registrada porque está protegida por hash. Sí puede escribir una nueva y verla temporalmente con el icono de ojo.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form-stack">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="form-label">Contraseña actual</label>
            <div class="password-field-wrap">
                <input id="update_password_current_password" name="current_password" type="password" class="form-control profile-control pe-5 @if($errors->updatePassword->has('current_password')) is-invalid @endif" autocomplete="current-password">
                <button type="button" class="password-toggle-btn" data-password-toggle="update_password_current_password" aria-label="Mostrar u ocultar contraseña">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="form-label">Nueva contraseña</label>
            <div class="password-field-wrap">
                <input id="update_password_password" name="password" type="password" class="form-control profile-control pe-5 @if($errors->updatePassword->has('password')) is-invalid @endif" autocomplete="new-password">
                <button type="button" class="password-toggle-btn" data-password-toggle="update_password_password" aria-label="Mostrar u ocultar contraseña">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password'))
                <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="form-label">Confirmar nueva contraseña</label>
            <div class="password-field-wrap">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control profile-control pe-5 @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" autocomplete="new-password">
                <button type="button" class="password-toggle-btn" data-password-toggle="update_password_password_confirmation" aria-label="Mostrar u ocultar contraseña">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="invalid-feedback d-block">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex flex-wrap align-items-center gap-3 pt-2">
            <button type="submit" class="btn btn-actualizar px-4 py-2 rounded-3">Actualizar contraseña</button>

            @if (session('status') === 'password-updated')
                <span class="text-success fw-semibold">La contraseña fue actualizada correctamente.</span>
            @endif
        </div>
    </form>
</section>
