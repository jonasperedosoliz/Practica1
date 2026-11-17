function requiredEnv(name: string): string {
    const value = process.env[name];

    if (!value) {
        throw new Error(
            `Defina ${name} en el entorno local antes de ejecutar las pruebas E2E.`
        );
    }

    return value;
}

export const testUser = {
    email: requiredEnv('E2E_USER_EMAIL'),
    password: requiredEnv('E2E_USER_PASSWORD'),
};
