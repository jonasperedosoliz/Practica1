<header class="profile-section-head">
    <span class="crud-panel-label danger">Zona sensible</span>
    <h3>Eliminar cuenta</h3>
    <p>Esta acción borra definitivamente su cuenta y los datos vinculados. Úsela solo si realmente desea salir del sistema.</p>
</header>

<div class="profile-danger-box">
    <div>
        <strong>Eliminación irreversible</strong>
        <p>Al confirmar, se cerrará la sesión y no podrá recuperar esta cuenta.</p>
    </div>
    <button
        type="button"
        class="btn btn-action-delete"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="bi bi-trash3"></i> Eliminar cuenta
    </button>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="profile-modal-form">
        @csrf
        @method('delete')

        <h2>¿Seguro que desea eliminar su cuenta?</h2>
        <p>
            Una vez eliminada, todos sus recursos y datos se borrarán permanentemente. Ingrese su contraseña para confirmar.
        </p>

        <div class="crud-field">
            <label for="password">Contraseña <span>*</span></label>
            <div class="password-field-wrap">
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control profile-control pe-5 @if($errors->userDeletion->has('password')) is-invalid @endif"
                    placeholder="Contraseña"
                >
                <button type="button" class="password-toggle-btn" data-password-toggle="password" aria-label="Mostrar u ocultar contraseña">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @if($errors->userDeletion->has('password'))
                <div class="invalid-feedback d-block">{{ $errors->userDeletion->first('password') }}</div>
            @endif
        </div>

        <div class="crud-form-actions justify-content-end">
            <button type="button" class="btn btn-cancel" x-on:click="$dispatch('close')">Cancelar</button>
            <button type="submit" class="btn btn-action-delete">Eliminar definitivamente</button>
        </div>
    </form>
</x-modal>
