@extends('layouts.app')

@section('title', 'Perfil')
@section('header') Perfil @endsection
@section('subheader') Actualice sus datos personales, cambie su contraseña de forma segura y mantenga protegida su cuenta. @endsection

@section('content')
    <div class="profile-grid">
        <section class="crud-card card">
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <section class="crud-card card">
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </section>
    </div>

    <section class="crud-card card mt-4">
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
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
