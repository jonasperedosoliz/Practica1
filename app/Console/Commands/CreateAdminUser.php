<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin
                            {--email= : Correo del administrador}
                            {--name=Administrador : Nombre visible del administrador}
                            {--password= : Contraseña (preferible usar prompt interactivo)}';

    protected $description = 'Crea o actualiza la cuenta administradora sin publicar secretos en el repositorio';

    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('Correo del administrador');
        $name = $this->option('name') ?: 'Administrador';
        $password = $this->option('password') ?: $this->secret('Contraseña del administrador');
        $passwordConfirmation = $this->option('password')
            ? $password
            : $this->secret('Confirmar contraseña');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $user->forceFill([
                'name' => $name,
                'password' => $password,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            $this->info("Administrador actualizado: {$email}");
        } else {
            User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            $this->info("Administrador creado: {$email}");
        }

        return self::SUCCESS;
    }
}
