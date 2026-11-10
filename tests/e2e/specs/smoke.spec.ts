import { test, expect } from '../fixtures';

test.describe('Smoke test - disponibilidad del entorno', () => {
    test('la página de inicio responde correctamente', async ({ page }) => {
        const response = await page.goto('/');
        await page.waitForLoadState('domcontentloaded');

        expect(response, 'El servidor no devolvió respuesta').not.toBeNull();
        expect(response!.status()).toBe(200);
        await expect(page.locator('body')).toBeVisible();
    });

    test('la página de login carga el formulario', async ({ loginPage, page }) => {
        const response = await loginPage.goto();

        expect(response!.ok()).toBeTruthy();
        await expect(page).toHaveURL(/\/login$/);
        await expect(page).toHaveTitle(/.+/);
        await loginPage.expectLoaded();
    });

    test('las rutas protegidas redirigen al login sin sesión', async ({ page }) => {
        await page.goto('/dashboard');

        await expect(page).toHaveURL(/\/login$/);
    });
});
