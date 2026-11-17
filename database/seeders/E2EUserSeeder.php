<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class E2EUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('E2E_USER_EMAIL');
        $password = env('E2E_USER_PASSWORD');

        if (! filled($email) || ! filled($password)) {
            throw new RuntimeException(
                'Defina E2E_USER_EMAIL y E2E_USER_PASSWORD en el entorno local antes de ejecutar E2EUserSeeder.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'QA E2E',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );
    }
}
