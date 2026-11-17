<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class IsAdminMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_includes_is_admin_column(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'is_admin'));
    }

    public function test_migration_backfills_existing_users_as_administrators(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('is_admin');
        });

        $this->assertFalse(Schema::hasColumn('users', 'is_admin'));

        DB::table('users')->insert([
            'name' => 'Admin Produccion',
            'email' => 'jonasperedosoliz@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require database_path('migrations/2026_11_17_120000_add_is_admin_to_users_table.php');
        $migration->up();

        $this->assertTrue(Schema::hasColumn('users', 'is_admin'));
        $this->assertSame(
            1,
            (int) DB::table('users')->where('email', 'jonasperedosoliz@gmail.com')->value('is_admin')
        );
    }
}
