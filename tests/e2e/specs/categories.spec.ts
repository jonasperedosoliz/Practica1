import { test, expect, testUser } from '../fixtures';

test.describe('Módulo de Categorías', () => {
    test.beforeEach(async ({ loginPage }) => {
        await loginPage.loginAndWaitForDashboard(testUser.email, testUser.password);
    });

    test('el usuario autenticado navega a Categorías desde el menú lateral', async ({ categoriesPage }) => {
        await expect(categoriesPage.sidebarLink).toBeVisible();

        await categoriesPage.gotoFromSidebar();

        await categoriesPage.verifyPageLoaded();
    });

    test('la tabla de categorías carga sin errores de renderizado', async ({ page, categoriesPage, pageErrors }) => {
        const response = await categoriesPage.goto();

        expect(response?.status()).toBe(200);
        await categoriesPage.verifyPageLoaded();
        await categoriesPage.verifyTableHeaders();

        const rows = categoriesPage.dataRows();
        await expect(rows.first()).toBeVisible();
        expect(await rows.count()).toBeLessThanOrEqual(7);

        await expect(page.getByText(/Whoops|Server Error|Exception|Undefined (variable|index|array key)/i)).toHaveCount(0);
        await expect(page.locator('body')).not.toContainText('{{');
        expect(pageErrors, 'Errores de JavaScript en la página').toEqual([]);
    });

    test('crea una categoría nueva y aparece en el listado', async ({ categoriesPage }) => {
        const categoria = {
            nombre: `E2E Categoria ${Date.now()}`,
            descripcion: 'Categoría creada por la prueba automatizada de Playwright.',
            estado: 'Activo' as const,
        };

        await categoriesPage.goto();
        await categoriesPage.createCategory(categoria);

        await expect(categoriesPage.page).toHaveURL(/\/listacategorias$/);
        await categoriesPage.expectSuccessAlert('Categoría creada exitosamente.');

        await categoriesPage.search(categoria.nombre);
        const row = categoriesPage.rowByName(categoria.nombre);
        await expect(row).toHaveCount(1);
        await expect(row).toContainText(categoria.descripcion);
        await expect(row).toContainText('Activo');

        await categoriesPage.deleteCategory(categoria.nombre);
        await categoriesPage.search(categoria.nombre);
        await expect(categoriesPage.rowByName(categoria.nombre)).toHaveCount(0);
    });
});
