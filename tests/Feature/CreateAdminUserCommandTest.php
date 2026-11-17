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
        $this->assertTrue(Hash::check('SecurePass123!', $admin->password));
    }

    public function test_command_updates_existing_administrator_without_deleting_others(): void
    {
        $existing = User::factory()->create([
            'email' => 'admin@instituto.tech',
            'name' => 'Viejo Nombre',
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
        $this->assertTrue(Hash::check('NuevaClave123!', $existing->password));
    }
}
