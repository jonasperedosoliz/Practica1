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
                            {--name= : Nombre visible del administrador}
                            {--password= : Contraseña (requerida solo al crear; opcional al actualizar)}
                            {--promote-only : Solo marca is_admin=true sin cambiar nombre ni contraseña}';

    protected $description = 'Crea o actualiza la cuenta administradora sin publicar secretos en el repositorio';

    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('Correo del administrador');

        $emailValidator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'string', 'email', 'max:255']]
        );

        if ($emailValidator->fails()) {
            foreach ($emailValidator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($this->option('promote-only')) {
            return $this->promoteExistingAdministrator($user, $email);
        }

        if ($user) {
            return $this->updateExistingAdministrator($user, $email);
        }

        return $this->createAdministrator($email);
    }

    private function promoteExistingAdministrator(?User $user, string $email): int
    {
        if (! $user) {
            $this->error("No existe un usuario con el correo {$email}. Use el comando sin --promote-only para crearlo.");

            return self::FAILURE;
        }

        $originalPassword = $user->password;

        $user->forceFill([
            'is_admin' => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        $user->refresh();

        if ($user->password !== $originalPassword) {
            $this->error('La contraseña cambió de forma inesperada.');

            return self::FAILURE;
        }

        $this->info("Administrador promovido sin cambiar contraseña: {$email}");

        return self::SUCCESS;
    }

    private function updateExistingAdministrator(User $user, string $email): int
    {
        $name = filled($this->option('name')) ? $this->option('name') : $user->name;
        $password = $this->option('password');

        // Sin --password se conserva la credencial actual (caso producción).
        if (blank($password)) {
            $user->forceFill([
                'name' => $name,
                'is_admin' => true,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            $this->info("Administrador promovido sin cambiar contraseña: {$email}");

            return self::SUCCESS;
        }

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
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

        $user->forceFill([
            'name' => $name,
            'password' => $password,
            'is_admin' => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        $this->info("Administrador actualizado: {$email}");

        return self::SUCCESS;
    }

    private function createAdministrator(string $email): int
    {
        $name = $this->option('name')
            ?: ($this->input->isInteractive() ? $this->ask('Nombre del administrador', 'Administrador') : 'Administrador');

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

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->info("Administrador creado: {$email}");

        return self::SUCCESS;
    }
}
