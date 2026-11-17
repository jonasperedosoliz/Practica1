<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_administrator_without_hardcoded_secrets(): void
    {
        $this->artisan('app:create-admin', [
            '--email' => 'admin@instituto.tech',
            '--name' => 'Administrador',
            '--password' => 'SecurePass123!',
        ])->assertSuccessful();

        $admin = User::query()->where('email', 'admin@instituto.tech')->first();

        $this->assertNotNull($admin);
        $this->assertSame('Administrador', $admin->name);
        $this->assertTrue($admin->is_admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue(Hash::check('SecurePass123!', $admin->password));
    }

    public function test_command_updates_existing_administrator_without_deleting_others(): void
    {
        $existing = User::factory()->create([
            'email' => 'admin@instituto.tech',
            'name' => 'Viejo Nombre',
            'is_admin' => false,
        ]);

        $other = User::factory()->create([
            'email' => 'otro@instituto.tech',
        ]);

        $this->artisan('app:create-admin', [
            '--email' => 'admin@instituto.tech',
            '--name' => 'Administrador',
            '--password' => 'NuevaClave123!',
        ])->assertSuccessful();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', [
            'id' => $other->id,
            'email' => 'otro@instituto.tech',
        ]);

        $existing->refresh();
        $this->assertSame('Administrador', $existing->name);
        $this->assertTrue($existing->is_admin);
        $this->assertTrue(Hash::check('NuevaClave123!', $existing->password));
    }

    public function test_promote_only_marks_existing_user_as_admin_without_changing_password(): void
    {
        $existing = User::factory()->create([
            'email' => 'jonasperedosoliz@gmail.com',
            'name' => 'Jonas Peredo',
            'password' => Hash::make('ClaveOriginal123!'),
            'is_admin' => false,
        ]);

        $originalHash = $existing->password;

        $this->artisan('app:create-admin', [
            '--email' => 'jonasperedosoliz@gmail.com',
            '--promote-only' => true,
        ])->assertSuccessful();

        $existing->refresh();

        $this->assertTrue($existing->is_admin);
        $this->assertTrue($existing->isAdmin());
        $this->assertSame('Jonas Peredo', $existing->name);
        $this->assertSame($originalHash, $existing->password);
        $this->assertTrue(Hash::check('ClaveOriginal123!', $existing->password));
    }

    public function test_non_interactive_update_without_password_promotes_without_resetting_credentials(): void
    {
        $existing = User::factory()->create([
            'email' => 'admin@instituto.tech',
            'name' => 'Admin Actual',
            'password' => Hash::make('ClaveOriginal123!'),
            'is_admin' => false,
        ]);

        $this->artisan('app:create-admin', [
            '--email' => 'admin@instituto.tech',
        ])->assertSuccessful();

        $existing->refresh();

        $this->assertTrue($existing->is_admin);
        $this->assertSame('Admin Actual', $existing->name);
        $this->assertTrue(Hash::check('ClaveOriginal123!', $existing->password));
    }
}
