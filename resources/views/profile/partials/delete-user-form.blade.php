<section class="space-y-6">
    <header class="profile-section-head">
        <span class="section-label">Zona sensible</span>
        <h3>Eliminar cuenta</h3>
        <p>Esta acción borra definitivamente su cuenta y todos los datos vinculados. Úsela solo si realmente desea salir del sistema.</p>
    </header>

    <button
        type="button"
        class="btn btn-danger rounded-3 px-4 py-2"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        Eliminar cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="h4 fw-bold text-dark mb-2">¿Seguro que desea eliminar su cuenta?</h2>

            <p class="text-muted mb-3">
                Una vez eliminada, todos sus recursos y datos se borrarán permanentemente. Ingrese su contraseña para confirmar esta acción.
            </p>

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

            <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary rounded-3 px-4" x-on:click="$dispatch('close')">Cancelar</button>
                <button type="submit" class="btn btn-danger rounded-3 px-4">Eliminar definitivamente</button>
            </div>
        </form>
    </x-modal>
</section>
