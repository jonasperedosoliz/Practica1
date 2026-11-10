import { execSync } from 'node:child_process';

export default function globalSetup() {
    execSync('php artisan db:seed --class=E2EUserSeeder --force', {
        stdio: 'inherit',
        env: process.env,
    });
}
