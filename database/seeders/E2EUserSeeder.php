<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class E2EUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('E2E_USER_EMAIL', 'qa.e2e@example.com')],
            [
                'name' => 'QA E2E',
                'password' => Hash::make(env('E2E_USER_PASSWORD', 'Password123!')),
                'email_verified_at' => now(),
            ]
        );
    }
}
