@extends('layouts.app')

@section('title', 'Perfil')
@section('header', 'Perfil')
@section('subheader', 'Actualice sus datos, proteja su acceso y gestione su cuenta.')

@section('content')
    <section class="profile-hero">
        <div class="profile-hero-identity">
            <span class="profile-hero-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 2)) }}</span>
            <div>
                <span class="dash-kicker"><i class="bi bi-person-badge"></i> Cuenta administradora</span>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
            </div>
        </div>
        <div class="profile-hero-meta">
            <div>
                <span>Estado</span>
                <strong>Activa</strong>
            </div>
            <div>
                <span>Rol</span>
                <strong>Administrador</strong>
            </div>
            <div>
                <span>Acceso</span>
                <strong>Seguro</strong>
            </div>
        </div>
    </section>

    <div class="profile-grid">
        <section class="profile-card">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="profile-card">
            @include('profile.partials.update-password-form')
        </section>
    </div>

    <section class="profile-card profile-danger mt-3">
        @include('profile.partials.delete-user-form')
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function (event) {
        const toggle = event.target.closest('[data-password-toggle]');

        if (!toggle) {
            return;
        }

        const input = document.getElementById(toggle.getAttribute('data-password-toggle'));

        if (!input) {
            return;
        }

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const icon = toggle.querySelector('i');

        if (icon) {
            icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        }
    });
</script>
@endpush
