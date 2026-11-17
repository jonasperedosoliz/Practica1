<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->get('/register')->assertOk();
    }

    public function test_new_users_can_register_and_access_catalog_only(): void
    {
        $response = $this->post('/register', [
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('catalogo', absolute: false));

        $user = User::query()->where('email', 'cliente@example.com')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->is_admin);

        $this->get(route('catalogo'))->assertOk();
        $this->get(route('dashboard'))->assertRedirect(route('catalogo'));
    }
}
