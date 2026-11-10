import { test, expect, testUser } from '../fixtures';
import type { ProductData } from '../pages/ProductsPage';

const LARAVEL_ERROR_TEXT = /Whoops|Server Error|Exception|Undefined (variable|index|array key)/i;

test.describe('Módulo de Productos', () => {
    let tempCategory: string | null = null;

    test.beforeEach(async ({ loginPage }) => {
        await loginPage.loginAndWaitForDashboard(testUser.email, testUser.password);
    });

    test.afterEach(async ({ categoriesPage }) => {
        if (!tempCategory) {
            return;
        }
        // El borrado en cascada de la categoría elimina cualquier producto huérfano si el test falló a medias.
        await categoriesPage.goto();
        await categoriesPage.deleteCategory(tempCategory);
        tempCategory = null;
    });

    test('navega a Productos desde el menú lateral y la tabla carga sin errores', async ({ page, productsPage, pageErrors }) => {
        await expect(page).toHaveURL(/\/dashboard$/);
        await expect(productsPage.sidebarLink).toBeVisible();

        const response = await productsPage.gotoFromSidebar();

        expect(response.status()).toBe(200);
        await productsPage.verifyPageLoaded();

        const rows = productsPage.dataRows();
        await expect(rows.first()).toBeVisible();
        expect(await rows.count()).toBeLessThanOrEqual(7);

        await expect(page.getByText(LARAVEL_ERROR_TEXT)).toHaveCount(0);
        await expect(page.locator('body')).not.toContainText('{{');
        expect(pageErrors, 'Errores de JavaScript en la página').toEqual([]);
    });

    test('registra un producto nuevo, lo verifica en la tabla y lo elimina', async ({ categoriesPage, productsPage }) => {
        const stamp = Date.now();

        await test.step('crear categoría temporal activa', async () => {
            tempCategory = `E2E Cat Prod ${stamp}`;
            await categoriesPage.goto();
            await categoriesPage.createCategory({ nombre: tempCategory, estado: 'Activo' });
            await categoriesPage.expectSuccessAlert('Categoría creada exitosamente.');
        });

        const producto: ProductData = {
            nombre: `E2E Producto ${stamp}`,
            descripcion: 'Producto creado por la prueba automatizada de Playwright.',
            precio: 1499.9,
            stock: 25,
            categoria: tempCategory!,
        };

        await test.step('registrar el producto', async () => {
            await productsPage.goto();
            await productsPage.openCreateForm();
            await expect(productsPage.categorySelect.getByRole('option', { name: producto.categoria })).toHaveCount(1);

            await productsPage.fillProductForm(producto);
            const confirmation = await productsPage.submitProductForm();

            expect(confirmation).toContain('Producto creado exitosamente.');
        });

        await test.step('verificar los datos en la tabla', async () => {
            await productsPage.expectProductInTable(producto);
        });

        await test.step('eliminar el producto de prueba', async () => {
            await productsPage.deleteProduct(producto.nombre);
            const row = await productsPage.searchProduct(producto.nombre);
            await expect(row).toHaveCount(0);
            await expect(productsPage.dataRows()).toContainText(`No se encontraron productos para "${producto.nombre}"`);
        });
    });
});
