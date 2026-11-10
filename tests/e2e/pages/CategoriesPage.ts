import { expect, type Locator, type Page } from '@playwright/test';
import { BasePage } from './BasePage';

export type CategoryData = {
    nombre: string;
    descripcion?: string;
    estado?: 'Activo' | 'Inactivo';
};

export class CategoriesPage extends BasePage {
    readonly heading: Locator;
    readonly catalogTitle: Locator;
    readonly newCategoryLink: Locator;
    readonly pdfReportLink: Locator;
    readonly excelReportLink: Locator;

    readonly createHeading: Locator;
    readonly nameInput: Locator;
    readonly descriptionInput: Locator;
    readonly statusSelect: Locator;
    readonly submitButton: Locator;
    readonly cancelLink: Locator;

    static readonly columns = ['#', 'Nombre', 'Descripcion', 'Estado', 'Acciones'];

    constructor(page: Page) {
        super(page, {
            path: '/listacategorias',
            sidebarLabel: /Categorías/,
            searchPlaceholder: 'Buscar categoria, descripcion o estado',
        });

        this.heading = page.getByRole('heading', { level: 2, name: 'Categorias', exact: true });
        this.catalogTitle = page.getByText('Catalogo de categorias');
        this.newCategoryLink = page.getByRole('link', { name: 'Nueva categoria' });
        this.pdfReportLink = page.getByRole('link', { name: 'Reporte PDF' });
        this.excelReportLink = page.getByRole('link', { name: 'Reporte Excel' });

        this.createHeading = page.getByRole('heading', { level: 2, name: 'Nueva categoría' });
        this.nameInput = page.getByLabel('Nombre');
        this.descriptionInput = page.getByLabel('Descripción');
        this.statusSelect = page.getByLabel('Estado');
        this.submitButton = page.getByRole('button', { name: 'Registrar' });
        this.cancelLink = page.getByRole('link', { name: 'Cancelar' });
    }

    async verifyPageLoaded() {
        await expect(this.page).toHaveURL(this.urlPattern);
        await expect(this.page).toHaveTitle('Lista de categorias');
        await expect(this.heading).toBeVisible();
        await expect(this.catalogTitle).toBeVisible();
        await expect(this.table).toBeVisible();
        await expect(this.newCategoryLink).toBeVisible();
        await expect(this.sidebarLink).toHaveClass(/\bactive\b/);
    }

    async verifyTableHeaders() {
        await expect(this.table.getByRole('columnheader')).toHaveText(CategoriesPage.columns);
    }

    async openCreateForm() {
        await this.newCategoryLink.click();
        await this.page.waitForURL(/\/listacategorias\/create$/);
        await expect(this.createHeading).toBeVisible();
    }

    async fillCategoryForm({ nombre, descripcion, estado = 'Activo' }: CategoryData) {
        await this.nameInput.fill(nombre);
        if (descripcion !== undefined) {
            await this.descriptionInput.fill(descripcion);
        }
        await this.statusSelect.selectOption({ label: estado });
    }

    async submitCategoryForm() {
        await this.waitForNavigation(() => this.submitButton.click());
    }

    async createCategory(data: CategoryData) {
        await this.openCreateForm();
        await this.fillCategoryForm(data);
        await this.submitCategoryForm();
    }

    async deleteCategory(nombre: string) {
        await this.deleteItem(nombre, 'Categoría eliminada exitosamente.');
    }
}
